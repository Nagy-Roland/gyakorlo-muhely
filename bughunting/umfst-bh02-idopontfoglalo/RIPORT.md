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
- **Hiba leírása és reprodukálása:** 
- **Gyökérok (sor + magyarázat):** 
- **Javítás (commit link):** 
- **Hogyan tesztelted (kézi tesztlépések, konzolos ellenőrzés vagy egységteszt):** 
- **Tanulság / érintett alapelv:** 

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
