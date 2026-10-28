<?php
declare(strict_types=1);

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS'])]);
session_start();
$_SESSION['csrf'] ??= bin2hex(random_bytes(32));
const ALAP_URL = 'http://localhost:8000';
const LEJARAT_PERC = 30;

$pdo = new PDO('sqlite:' . __DIR__ . '/fiokok.db', null, null, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
$pdo->exec('PRAGMA foreign_keys = ON');
if (!$pdo->query("SELECT name FROM sqlite_master WHERE name = 'felhasznalok'")->fetch()) {
    $pdo->exec(file_get_contents(__DIR__ . '/schema.sql'));
    $pdo->prepare('INSERT INTO felhasznalok (email, jelszo_hash) VALUES (?, ?)')      // tesztfiók
        ->execute(['anna@umfst.ro', password_hash('regi-jelszo-123', PASSWORD_DEFAULT)]);
}

function e(?string $s): string { return htmlspecialchars($s ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function most(int $plusz = 0): string { return gmdate('Y-m-d H:i:s', time() + $plusz); }
function atiranyit(string $hova): never { header('Location: ' . $hova, true, 303); exit; }
function oldal(string $cim, string $html, int $status = 200): never {
    http_response_code($status);
    header('Content-Type: text/html; charset=UTF-8');
    header('Referrer-Policy: no-referrer');          // a tokenes URL ne kerüljön Referer fejlécbe
    header('Cache-Control: no-store');
    echo '<!doctype html><html lang="hu"><head><meta charset="utf-8"><meta name="robots" content="noindex">'
       . '<title>' . e($cim) . '</title></head><body><h1>' . e($cim) . '</h1>' . $html . '</body></html>';
    exit;
}
function csrf_mezo(): string { return '<input type="hidden" name="csrf" value="' . e($_SESSION['csrf']) . '">'; }
function csrf_ellenoriz(): void {
    if (!hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) oldal('Lejárt űrlap', '<p>Töltsd újra az oldalt.</p>', 403);
}
function level_kuld(string $cim, string $targy, string $torzs): void {
    // Élesben: üzenetsorba tesszük (queue), hogy a válaszidő ne függjön a küldéstől.
    file_put_contents(__DIR__ . '/levelek.log', "To: $cim\nSubject: $targy\n\n$torzs\n----\n", FILE_APPEND | LOCK_EX);
}
function uj_token_es_level(PDO $pdo, int $id, string $email): void {
    $pdo->prepare('UPDATE jelszo_tokenek SET felhasznalva = ? WHERE felhasznalo_id = ? AND felhasznalva IS NULL')
        ->execute([most(), $id]);                                    // csak a legutóbbi link működjön
    $token = bin2hex(random_bytes(32));
    $pdo->prepare('INSERT INTO jelszo_tokenek (felhasznalo_id, token_hash, lejar, letrehozva, ip) VALUES (?, ?, ?, ?, ?)')
        ->execute([$id, hash('sha256', $token), most(LEJARAT_PERC * 60), most(), $_SERVER['REMOTE_ADDR'] ?? null]);
    level_kuld($email, 'Jelszó-visszaállítás – UMFST', "Új jelszót itt állíthatsz be (" . LEJARAT_PERC . " percig érvényes):\n"
        . ALAP_URL . '/uj-jelszo?token=' . $token . "\n\nHa nem te kérted, hagyd figyelmen kívül – a jelszavad nem változott.");
}
/** Token ellenőrzése; hiba esetén hibaoldal. */
function token_sor(PDO $pdo, string $token): array {
    if (!preg_match('/^[a-f0-9]{64}$/', $token)) oldal('Hibás link', '<p>A link sérült.</p>', 400);
    $st = $pdo->prepare('SELECT t.id, t.felhasznalo_id, t.lejar, t.felhasznalva, f.email FROM jelszo_tokenek t
                         JOIN felhasznalok f ON f.id = t.felhasznalo_id WHERE t.token_hash = ?');
    $st->execute([hash('sha256', $token)]);
    $t = $st->fetch();
    if (!$t) oldal('Érvénytelen link', '<p><a href="/elfelejtett">Kérj új linket.</a></p>', 404);
    if ($t['felhasznalva'] !== null || $t['lejar'] < most()) {
        oldal('A link lejárt vagy már felhasználták', '<p><a href="/elfelejtett">Kérj új linket.</a></p>', 410);
    }
    return $t;
}

$ut = (string)parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$m = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// ---------- 1. Link kérése ----------
if ($ut === '/elfelejtett') {
    if ($m === 'POST') {
        csrf_ellenoriz();
        $email = mb_strtolower(trim((string)($_POST['email'] ?? '')));
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $st = $pdo->prepare('SELECT id FROM felhasznalok WHERE email = ?');
            $st->execute([$email]);
            if ($id = $st->fetchColumn()) {
                $db = $pdo->prepare('SELECT COUNT(*) FROM jelszo_tokenek WHERE felhasznalo_id = ? AND letrehozva > ?');
                $db->execute([$id, most(-3600)]);
                if ((int)$db->fetchColumn() < 3) uj_token_es_level($pdo, (int)$id, $email);   // max. 3 / óra
            }
        }
        atiranyit('/elfelejtett?elkuldve=1');      // létező, nem létező, hibás cím: MINDIG ugyanez
    }
    oldal('Elfelejtett jelszó', isset($_GET['elkuldve'])
        ? '<p role="status">Ha létezik ilyen fiók, elküldtük a visszaállító linket. A link ' . LEJARAT_PERC . ' percig érvényes.</p>'
        : '<form method="post">' . csrf_mezo() . '<label>E-mail <input type="email" name="email" required></label><button>Link kérése</button></form>');
}

// ---------- 2. Új jelszó beállítása ----------
if ($ut === '/uj-jelszo') {
    $token = (string)($m === 'POST' ? ($_POST['token'] ?? '') : ($_GET['token'] ?? ''));
    $t = token_sor($pdo, $token);

    if ($m === 'POST') {
        csrf_ellenoriz();
        $j1 = (string)($_POST['jelszo'] ?? '');
        $j2 = (string)($_POST['jelszo2'] ?? '');
        $hiba = match (true) {
            mb_strlen($j1) < 12            => 'A jelszó legalább 12 karakter legyen.',
            mb_strlen($j1) > 128           => 'A jelszó legfeljebb 128 karakter lehet.',
            $j1 !== $j2                    => 'A két jelszó nem egyezik.',
            stripos($j1, explode('@', $t['email'])[0]) !== false => 'A jelszó ne tartalmazza az e-mail címed.',
            default                        => '',
        };
        if ($hiba === '') {
            $pdo->beginTransaction();
            $u = $pdo->prepare('UPDATE jelszo_tokenek SET felhasznalva = ? WHERE id = ? AND felhasznalva IS NULL AND lejar > ?');
            $u->execute([most(), $t['id'], most()]);
            if ($u->rowCount() !== 1) {
                $pdo->rollBack();
                oldal('A link lejárt vagy már felhasználták', '', 410);
            }
            $pdo->prepare('UPDATE felhasznalok SET jelszo_hash = ?, session_verzio = session_verzio + 1 WHERE id = ?')
                ->execute([password_hash($j1, PASSWORD_DEFAULT), $t['felhasznalo_id']]);
            $pdo->prepare('UPDATE jelszo_tokenek SET felhasznalva = ? WHERE felhasznalo_id = ? AND felhasznalva IS NULL')
                ->execute([most(), $t['felhasznalo_id']]);
            $pdo->commit();
            session_regenerate_id(true);
            level_kuld($t['email'], 'A jelszavad megváltozott', 'Ha nem te voltál, azonnal írj a helpdesk@umfst.ro címre.');
            atiranyit('/belepes?visszaallitva=1');
        }
        $_SESSION['hiba'] = $hiba;
        atiranyit('/uj-jelszo?token=' . $token);
    }
    $hiba = $_SESSION['hiba'] ?? '';
    unset($_SESSION['hiba']);
    oldal('Új jelszó beállítása', ($hiba ? '<p role="alert">' . e($hiba) . '</p>' : '')
        . '<p>Fiók: <strong>' . e($t['email']) . '</strong></p><form method="post">' . csrf_mezo()
        . '<input type="hidden" name="token" value="' . e($token) . '">'
        . '<label>Új jelszó <input type="password" name="jelszo" minlength="12" required autocomplete="new-password"></label>'
        . '<label>Még egyszer <input type="password" name="jelszo2" minlength="12" required autocomplete="new-password"></label>'
        . '<button>Mentés</button></form>');
}

// ---------- 3. Belépés (A tesztekhez és ellenőrzéshez) ----------
if ($ut === '/belepes') {
    if ($m === 'POST') {
        csrf_ellenoriz();
        $email = mb_strtolower(trim((string)($_POST['email'] ?? '')));
        $jelszo = (string)($_POST['jelszo'] ?? '');

        $st = $pdo->prepare('SELECT id, jelszo_hash, session_verzio FROM felhasznalok WHERE email = ?');
        $st->execute([$email]);
        $felhasznalo = $st->fetch();

        if ($felhasznalo && password_verify($jelszo, $felhasznalo['jelszo_hash'])) {
            $_SESSION['user_id'] = $felhasznalo['id'];
            $_SESSION['session_verzio'] = $felhasznalo['session_verzio'];
            oldal('Sikeres belépés', '<p>Üdvözlet, <strong>' . e($email) . '</strong>! Sikerült bejelentkezned.</p><p><a href="/elfelejtett">Vissza az elfelejtett jelszóhoz</a></p>');
        } else {
            oldal('Hiba', '<p role="alert">Hibás e-mail cím vagy jelszó.</p><p><a href="/belepes">Próbáld újra</a></p>', 401);
        }
    }

    $uzenet = isset($_GET['visszaallitva']) ? '<p role="status">Az új jelszavad beállítva. Jelentkezz be vele.</p>' : '';
    oldal('Belépés', $uzenet . '<form method="post">' . csrf_mezo()
        . '<label>E-mail <input type="email" name="email" required autocomplete="email"></label>'
        . '<label>Jelszó <input type="password" name="jelszo" required autocomplete="current-password"></label>'
        . '<button>Belépés</button></form>');
}
atiranyit('/elfelejtett');