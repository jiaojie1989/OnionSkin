# Klient
## Javascript
 * kontrola formuláře onSubmit: Kontrola pomocí jquery.validate který sám přepisuje onSubmit a přidává formulářům metodu "validate". Př.: logování, registrace, tvorba snippetu
 * validace pomocí HTML5: Př.: logování, registrace
 * **zajímavost:** Rozšíření jquery.validate o regex kontrolu (js/loginpanel.js), automatické prodlužování výšky textarea při psaní (js/textarea_autogrown.js). Kompilace a minimalizace js do složky public/js_c

## Validita
 * Plně validní html5
 * Formuláře přístupné

## CSS
 * Plně relační formátování s využítím bootstrap4 alpha
 * Jediné formátování  u elementu je z js knihovny datatables, kterému nejde zabránit.
 * Styly mimo html
 * Skinovatelnost -> Po přihlášení v nastavení může uživatel změnit skin.
 * Styl pro tisk -> Přímo v hlavních stylech nastavení pro tisk. U tmavého skinu se mění barva pozadí z "černé" na bílou, ruší se pozadí stránky, schovává se horní menu.
 * **zajímavost:** Styly psané v Scss s kompilací na serveru, vlastní implementace glyphicon, minimalizace stylů pomocí kompilátoru scss.

# Server
## Validace
 * Rozlišení poviných a nepoviných údajů: "* This field is required." pod inputem.
 * Odolnost proti dvojímu odeslání: Redirect
 * Odolnost proti špatnému zadání: Prováděna na několika frontách, Router validuje prettyurl (například i to že daná část url má být integer,atd). Model validuje vstupní data podle annotací viz [Implementace](Implementace.md). Následně se s DB pracuje přes Doctrine ORM, který zamezuje SQL Injection

## Databáze
 * tři  tabulky: User, Folder, Snippet
 * hesla jsou osolená

## Navigace
 * Viz [http://server.jirifryc.cz/Public](http://server.jirifryc.cz/Public)
 * Stránkování, filtrování, změna pořadí
 * **Ajax** načítání

## Šablony
 * Vše v šablonovacím engine Smarty s vlastními rozšířeními Smarty.

## OOP
 * Veškerý kód v OOP viz [Implementace](Implementace.md).

## Zajímavost
 * Vlastní engine s routerem, využití knihoven Smarty, Doctrine, kompilace javascriptu a scss, dále viz [Implementace](Implementace.md).