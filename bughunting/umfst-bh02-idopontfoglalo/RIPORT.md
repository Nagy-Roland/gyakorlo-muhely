# A rakoncátlan időpontfoglaló – hibariport

Repó: https://github.com/<felhasznalo>/umfst-bh02-idopontfoglalo
Készítette: <név>, <csoport>


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
- **Hiba leírása és reprodukálása:** 
- **Gyökérok (sor + magyarázat):** 
- **Javítás (commit link):** 
- **Hogyan tesztelted (kézi tesztlépések, konzolos ellenőrzés vagy egységteszt):** 
- **Tanulság / érintett alapelv:** 

## 4. hiba
- **Hiba leírása és reprodukálása:** 
- **Gyökérok (sor + magyarázat):** 
- **Javítás (commit link):** 
- **Hogyan tesztelted (kézi tesztlépések, konzolos ellenőrzés vagy egységteszt):** 
- **Tanulság / érintett alapelv:** 

## 5. hiba
- **Hiba leírása és reprodukálása:** 
- **Gyökérok (sor + magyarázat):** 
- **Javítás (commit link):** 
- **Hogyan tesztelted (kézi tesztlépések, konzolos ellenőrzés vagy egységteszt):** 
- **Tanulság / érintett alapelv:** 

## 6. hiba
- **Hiba leírása és reprodukálása:** 
- **Gyökérok (sor + magyarázat):** 
- **Javítás (commit link):** 
- **Hogyan tesztelted (kézi tesztlépések, konzolos ellenőrzés vagy egységteszt):** 
- **Tanulság / érintett alapelv:** 

## Összegzés
- Mit tanultam: 
- Melyik alapelv sérült a leggyakrabban: 
