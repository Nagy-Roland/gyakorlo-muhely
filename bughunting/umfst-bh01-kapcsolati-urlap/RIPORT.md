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
- **Hiba leírása és reprodukálása (lépések, böngésző, segédtechnológia):** 
- **Gyökérok (melyik sor, melyik szabály sérül):** 
- **Javítás (commit link, előtte/utána kódrészlet):** 
- **Hogyan tesztelted (W3C validátor, Lighthouse, Tab-bejárás, képernyőolvasó):** 
- **Tanulság / érintett alapelv (pl. Szemantika előbb, stílus később; WCAG-kritérium):** 

## 3. hiba
- **Hiba leírása és reprodukálása (lépések, böngésző, segédtechnológia):** 
- **Gyökérok (melyik sor, melyik szabály sérül):** 
- **Javítás (commit link, előtte/utána kódrészlet):** 
- **Hogyan tesztelted (W3C validátor, Lighthouse, Tab-bejárás, képernyőolvasó):** 
- **Tanulság / érintett alapelv (pl. Szemantika előbb, stílus később; WCAG-kritérium):** 

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
