# UMFST Élettani Tanszék – Egyoldalas weboldal

## A projekt célja
Az UMFST Élettani Tanszékének akadálymentes, szemantikus HTML5-ön alapuló bemutatkozó weboldala, amely megfelel az EU Web Accessibility Directive előírásainak.

## Használt szemantikus elemek és indoklásuk
* **`<!doctype html>` és `<html lang="hu">`**: Dokumentumtípus és a magyar nyelv beállítása a képernyőolvasók számára.
* **`<header>` és `<nav>`**: Tartalmazza a logót, a címet (`<h1>`) és a fő navigációs menüt.
* **`<main>`**: Az oldal egyedi fő tartalmának tárolója, amelyhez a „skip link” (`#tartalom`) kapcsolódik.
* **`<section>`**: Logikai fejezetekre bontja az oldalt (bemutatkozás, oktatók, fogadóórák).
* **`<article>`**: Az egyes oktatók kártyáinak egységbe zárása.
* **`<figure>` és `<figcaption>`**: Az oktatók portréinak és képaláírásainak szemantikus egysége.
* **`<table>`, `<caption>`, `<th scope>`**: A fogadóórák áttekinthető és akadálymentes táblázatos megjelenítése.
* **`<address>`**: Az elérhetőségek jelölése kattintható `tel:` és `mailto:` linkekkel.

## Élő demó
