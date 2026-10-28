# A dékáni hivatal „működő” kapcsolati űrlapja – hibariport

https://github.com/Nagy-Roland/gyakorlo-muhely/tree/main/bughunting/umfst-bh01-kapcsolati-urlap
Készítette: Nagy Roland

## 1. hiba
- **Hiba leírása és reprodukálása (lépések, böngésző, segédtechnológia):** A képernyőolvasó a mezőknél csak „szerkesztés, üres” szöveget mond, gépelés után pedig nincs azonosító.
- **Gyökérokok (melyik sor, melyik szabály sérül):** Az űrlapmezőkhöz nincsenek explicit `<label>` elemek rendelve (hiányzik a `for` és az `id` kapcsolat). Ez sérti a WCAG 1.3.1 (Információ és kapcsolatok) és 3.3.2 (Címkék vagy útmutatások) kritériumait.
- **Javítás (commit link, előtte/utána kódrészlet):**
  - *Előtte:* `<input type="text" name="nev" placeholder="Teljes név" required>`
  - *Utána:* `<label for="nev">Teljes név</label>`<br>`<input type="text" id="nev" name="nev" placeholder="Teljes név" required>`
- **Hogyan tesztelted (W3C validátor, Lighthouse, Tab-bejárás, képernyőolvasó):** Képernyőolvasóval és akadálymentességi ellenőrzővel tesztelve, hogy a fókuszáláskor a helyes mezőnevet olvassa-e fel a rendszer.
- **Tanulság / érintett alapelv (pl. Szemantika előbb, stílus később; WCAG-kritérium):** A vizuális `placeholder` szöveg nem helyettesíti a szemantikus `<label>` elemet; a segédtechnológiák számára elengedhetetlen a formális kapcsolat.

## 2. hiba
- **Hiba leírása és reprodukálása (lépések, böngésző, segédtechnológia):** A főcím fekete marad, pedig a CSS-ben zöldnek kellene lennie.
- **Gyökérokok (melyik sor, melyik szabály sérül):** A `style.css` 3. sorában a `.cim` szelektorban el lett gépelve a tulajdonság neve: `colour` szerepel a helyes `color` helyett. A CSS nem ismeri a brit helyesírást, így érvénytelenként elutasítja ezt a szabályt, emiatt a szövegszín nem változik meg zöldre.
- **Javítás (commit link, előtte/utána kódrészlet):**
  - *Előtte:* `.cim { colour: #0e7c66; font-size: 2rem; }`
  - *Utána:* `.cim { color: #0e7c66; font-size: 2rem; }`
- **Hogyan tesztelted (W3C validátor, Lighthouse, Tab-bejárás, képernyőolvasó):** Böngészőben frissítve az oldalt ellenőriztem, hogy a főcím megkapta-e a helyes zöld színt.
- **Tanulság / érintett alapelv (pl. Szemantika előbb, stílus később; WCAG-kritérium):** A CSS tulajdonságnevek pontos helyesírása elengedhetetlen; egy elgépelt betű miatt a stílus nem lép életbe.

## 3. hiba
- **Hiba leírása és reprodukálása (lépések, böngésző, segédtechnológia):** Mobilon az e-mail mezőre kattintva a szokásos szöveges billentyűzet jelenik meg (hiányzik a `@` karakter a gyorsbillentyűről), és hibás formátumú e-mail címmel is elküldhető az űrlap.
- **Gyökérokok (melyik sor, melyik szabály sérül):** Az e-mail mező `type="text"` értékkel volt ellátva a helyes `type="email"` helyett. Ez sérti a szemantikus HTML5 űrlapkezelési elveket és a WCAG 3.3.1 (Hibaazonosítás) / használhatósági ajánlásait.
- **Javítás (commit link, előtte/utána kódrészlet):**
  - *Előtte:* `<input type="text" name="email" placeholder="E-mail cím" required>`
  - *Utána:* `<input type="email" id="email" name="email" placeholder="E-mail cím" required>`
- **Hogyan tesztelted (W3C validátor, Lighthouse, Tab-bejárás, képernyőolvasó):** Mobil nézetben (vagy reszponzív módban) ellenőrizve, hogy az e-mail specifikus billentyűzet jön-e fel, illetve böngészőben tesztelve a beépített e-mail validációt.
- **Tanulság / érintett alapelv (pl. Szemantika előbb, stílus később; WCAG-kritérium):** Mindig a megfelelő HTML5 input típust kell használni a mező tartalmának megfelelően, mert ez támogatja a mobil eszközöket és a natív validációt.

## 4. hiba
- **Hiba leírása és reprodukálása (lépések, böngésző, segédtechnológia):** 
- **Gyökérok (melyik sor, melyik szabály sérül):** 
- **Javítás (commit link, előtte/utána kódrészlet):** 
- **Hogyan tesztelted (W3C validátor, Lighthouse, Tab-bejárás, képernyőolvasó):** 
- **Tanulság / érintett alapelv (pl. Szemantika előbb, stílus később; WCAG-kritérium):** 

## 5. hiba
- **Hiba leírása és reprodukálása (lépések, böngésző, segédtechnológia):** 
- **Gyökérok (melyik sor, melyik szabály sérül):** 
- **Javítás (commit link, előtte/utána kódrészlet):** 
- **Hogyan tesztelted (W3C validátor, Lighthouse, Tab-bejárás, képernyőolvasó):** 
- **Tanulság / érintett alapelv (pl. Szemantika előbb, stílus később; WCAG-kritérium):** 

## 6. hiba
- **Hiba leírása és reprodukálása (lépések, böngésző, segédtechnológia):** 
- **Gyökérok (melyik sor, melyik szabály sérül):** 
- **Javítás (commit link, előtte/utána kódrészlet):** 
- **Hogyan tesztelted (W3C validátor, Lighthouse, Tab-bejárás, képernyőolvasó):** 
- **Tanulság / érintett alapelv (pl. Szemantika előbb, stílus később; WCAG-kritérium):** 

## 7. hiba
- **Hiba leírása és reprodukálása (lépések, böngésző, segédtechnológia):** 
- **Gyökérok (melyik sor, melyik szabály sérül):** 
- **Javítás (commit link, előtte/utána kódrészlet):** 
- **Hogyan tesztelted (W3C validátor, Lighthouse, Tab-bejárás, képernyőolvasó):** 
- **Tanulság / érintett alapelv (pl. Szemantika előbb, stílus később; WCAG-kritérium):** 

## Összegzés
- Mit tanultam: 
- Melyik alapelv sérült a leggyakrabban: 
