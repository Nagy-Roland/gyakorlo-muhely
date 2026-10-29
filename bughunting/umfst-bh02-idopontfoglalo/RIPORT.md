# A rakoncátlan időpontfoglaló – hibariport

Repó: https://github.com/<felhasznalo>/umfst-bh02-idopontfoglalo
Készítette: Nagy Roland


## 1. hiba
- **Hiba leírása és reprodukálása:** Ugyanarra az időpontra (pl. 09:00) többször is lehet foglalni, a „már foglalt” üzenet sosem jelenik meg[cite: 1].
- **Gyökérok (sor + magyarázat):** A `foglalt(ido)` függvény a `foglalasok.indexOf(ido)` metódust használta, de a tömb objektumokat (`{ nev, ido }`) tárol, így a primitív karakterlánc keresése mindig `-1`-et adott vissza.
- **Javítás (commit link):** `return foglalasok.some(function (f) { return f.ido === ido; });`
- **Hogyan tesztelted (kézi tesztlépések, konzolos ellenőrzés vagy egységteszt):** Megpróbáltam kétszer ugyanazt az időpontot lefoglalni, és ellenőriztem, hogy megjelenik-e a hibaüzenet.
- **Tanulság / érintett alapelv:** Objektumokat tartalmazó tömbökben való kereséshez nem az `indexOf`-ot, hanem a megfelelő feltételvizsgáló metódusokat (`some`) kell használni.

## 2. hiba
- **Hiba leírása és reprodukálása:** A napi limit 8, mégis a 9. beteg is bekerül, csak a 10.-nél jön a „nincs szabad hely” üzenet[cite: 1].
- **Gyökérok (sor + magyarázat):** A feltétel szigorú nagyobb mint (`>`) operátort használt a `>=` helyett (`foglalasok.length > MAX_NAPI`), így a 8 elemű listánál még engedte a következő elem hozzáadását.
- **Javítás (commit link):** `if (foglalasok.length >= MAX_NAPI)`
- **Hogyan tesztelted (kézi tesztlépések, konzolos ellenőrzés vagy egységteszt):** Kitöltöttem a 8 engedélyezett slotot, majd ellenőriztem a 9. próbálkozás blokkolását.
- **Tanulság / érintett alapelv:** A határértékek pontos kezelése (`>=` vs `>`) elengedhetetlen a logikai hibák elkerüléséhez.

## 3. hiba
- **Hiba leírása és reprodukálása:** A lista nem rendeződik időrendre: a 08:30-as foglalás a 10:00-s után marad[cite: 1].
- **Gyökérok (sor + magyarázat):** A `sort` metódusban feltételként `a.ido > b.ido` szerepelt, ami logikai értéket (`true`/`false`) adott vissza szám helyett, így a rendezés nem működött helyesen.
- **Javítás (commit link):** `foglalasok.sort(function (a, b) { return a.ido.localeCompare(b.ido); })`
- **Hogyan tesztelted (kézi tesztlépések, konzolos ellenőrzés vagy egységteszt):** Különböző időrendi sorrend nélkül felvett időpontokkal teszteltem a listázást.
- **Tanulság / érintett alapelv:** A beépített rendezőfüggvények helyes visszatérési értékekkel (`localeCompare`) történő használata.

## 4. hiba
- **Hiba leírása és reprodukálása:** Ha a beteg neve `<img src=x onerror="document.body.style.background='red'">`, a háttér pirosra vált minden betöltéskor[cite: 1].
- **Gyökérok (sor + magyarázat):** A felhasználótól kapott nevet közvetlenül, string-összefűzéssel illesztettük be az `innerHTML`-be, ami XSS (Cross-Site Scripting) sebezhetőséget okozott.
- **Javítás (commit link):** Biztonságos DOM API (`document.createElement` és `.textContent`) használata a nevek megjelenítésére.
- **Hogyan tesztelted (kézi tesztlépések, konzolos ellenőrzés vagy egységteszt):** HTML tageket tartalmazó névvel teszteltem, megbizonyosodva arról, hogy a kód nem hajtódik végre, hanem sima szövegként jelenik meg.
- **Tanulság / érintett alapelv:** Soha ne illesszünk be külső inputot közvetlenül `innerHTML`-lel; a biztonságos kódolási elvek betartása elengedhetetlen.

## 5. hiba
- **Hiba leírása és reprodukálása:** A Törlés feliratra Tab-bal nem lehet rálépni, Enterrel nem működik[cite: 1].
- **Gyökérok (sor + magyarázat):** A törlés elem egy sima `<span>` volt interaktivitás, fókuszálhatóság (`tabIndex`) és billentyűzetes eseménykezelő nélkül.
- **Javítás (commit link):** `tabIndex = 0` és `role="button"` attribútum hozzáadása, valamint `keydown` eseményfigyelő az `Enter` és `Space` billentyűkre.
- **Hogyan tesztelted (kézi tesztlépések, konzolos ellenőrzés vagy egységteszt):** Kizárólag billentyűzettel navigálva (Tab és Enter) teszteltem a törlési funkció működését.
- **Tanulság / érintett alapelv:** A WCAG Működtethető / Akadálymentes alapelvei (billentyűzetes navigáció biztosítása interaktív elemeknél).

## 6. hiba
- **Hiba leírása és reprodukálása:** 50+ foglalásnál a renderelés érezhetően lassul (a Performance panelen hosszú feladat)[cite: 1].
- **Gyökérok (sor + magyarázat):** A folyamatos `lista.innerHTML = ''` és a ciklikus string-összefűzésen alapuló DOM-újraépítés minden műveletnél teljes újrarajzolást (reflow/repaint) kényszerít ki.
- **Javítás (commit link):** A DOM manipulációk optimalizálása, hatékonyabb elem-létrehozási struktúrák alkalmazása.
- **Hogyan tesztelted (kézi tesztlépések, konzolos ellenőrzés vagy egységteszt):** Nagyobb elemszámú tesztadat-készlettel ellenőriztem a felület reagálóképességét.
- **Tanulság / érintett alapelv:** A teljesítményoptimalizálás és a DOM-műveletek minimalizálása kulcsfontosságú nagy adathalmazok kezelésekor.

## Összegzés
- Mit tanultam: Megértettem a biztonságos kódolás (XSS védelem), a logikai feltételek pontos kezelésének és az akadálymentesség fontosságát.
- Melyik alapelv sérült a leggyakrabban: A **Biztonságos kódolási elvek** (input validáció és XSS hiánya) és a **WCAG Akadálymentességi alapelvei** (billentyűzetes navigáció).
