# Implementace webu

## Zabezpečení
 * XSS - všechny vkládané i zobrazované data jsou stripované od html tagů.
 * RFI a LFI - veškeré vkládané data jsou na každém kroku stripovány.
 * CSRF - Web je RESTful, tudíž GET request pouze zobrazuje data a všechny POST,DELETE,PUT,PATCH requesty obsahují  AntiForgeryToken a validační systém zabraňující CSRF útoku. (Jedinou vyjímkou je systém složek z důvodu rozpracované práce nad rámec WA1)
 * SQL Injection - Ochrana probíhá na třech úrovních, Router pro validaci cesty, Model pro validaci vstupních dat a následně Doctrine ORM pro validaci před manipulací s DB.
 * Path Injection - Router spolehlivě zabraňuje zadání nesprávné url a validuje datové typy v parametrech cesty.
 * Unvalidated redirect/forwards - Veškeré redirecty vyvolané serverem nejprve prochází přes Router. Čímž se zabraňuje redirectování uživatele na nechtěnou stránku.  

## Použité knihovny

 * Smarty - Šablonový framework
 * Doctrine - Databázový framework pro Entity managment
 * Doctrine-DataTables - Stránkování, filtrace a zobrazování dat v tabulkách z Doctrine ORM Entit
 * Leafo-LessPHP - Kompilace Less
 * Leafo-ScssPHP - Kompilace Scss
 * Bootstrap 4 - Frontend framework
 * Minify - Minimalizace js
 * Highlight.js - Zobrazování syntaxe kódu

## Struktura aplikace
 * cache - Cache využívaná Smarty template enginem
 * compileCache - Cache využívaná pro kompilaci js a scss
 * config - Nastavení aplikace
   * configuration.ini - Nastavení připojení k databázi,atd.
   * router.ini - Nastavení cest, pretty url a mapování modelů
   * languages.json - Podporované přípony
 * documentation - Dokumentace projektu
   * cz - Česká
   * en - Anglická
 * fonts - Fonty a znaky využívané v projektu
 * js - Nezkompilované js scripty
 * lang - Jazyky aplikace
 * public - **Public složka, jediná dostupná z webu**
   * js_c - Zkompilované a minimalizované js scripty
   * styles_c - Zkompilované a minimalizované styly 
   * index.php - Startovní script
   * .htaccess - Pro apache/nginx - pretty url
 * src - Zdrojové kódy aplikace   
 * styles - Nezkompilované styly
 * templates - Template webu
 * templates_c - Zkompilované template
 * vendor - Knihovny
 * .htaccess - Pojistka proti nastavení document root na tuto složku
 * composer.json - Pro knihovny
 * web.config - Pro IIS - pretty url, připravuje cache a provede celou instalaci

V celém projektu se nachází pouze dva ne-OOP soubory a to
index.php a src/onionskin_autoload.php . OOP soubory končí koncovkou .class.php, zatímco ne-OOP končí pouze .php
**index.php slouží jako zaváděcí script a pro jednoduchou obsluhu aplikace:**
```php
require_once('src/onionskin_autoload.php');

use OnionSkin\Engine;
use OnionSkin\Routing\Request;

Engine::Debug(true);   //Debug mode
Engine::Init();        //Prepare database, configuration, sessions, etc.
//Engine::BakeCss();     //Comment this if you dont want to bake CSS everytime.
//Engine::BakeJs();     //Comment this if you dont want to bake JS everytime.
//Engine::BakeLanguageTypes(); //Develop only. Try to determinate which languages can be highlighted in hightlight.js
Engine::Execute(Request::Current());     //Execute action.
```
a src/onionskin_autoload.php jak už název napovídá zavádí autoload. 

## Struktura kódu
 * OnionSkin - Hlavní package
  * Entities - Package s databázovými entitami
  * Exceptions - Package s exceptions
  * Models - Package s modely pro validaci
  * Pages - Package se stránkami
  * Routing - Package pro routování
    * Annotations - Anotace pro routování a modely
  * Smarty - Pluginy a rozšíření pro Smarty 
  * Engine - Základní třída celého projektu
  * Lang - Načítá jazykové sady
  * Page - Abstraktní třída pro stránky
  * UtilsINI - Utilita pro zápis a čtení INI

## Router
Router je založený na záznamech v conf/router.ini, každý záznam má tuto strukturu:
```
[VolitelnýNázev]
page="\OnionSkin\Pages\EditPage" # Package s classname stránky pro spouštění.
url="/Edit/{id:int}/{name:string}" # URL pro matchování
method="GET;POST" # HTTP Methody které mají projít oddělené středníkem (GET,POST,DELETE,PUT,PATCH)
model="\OnionSkin\Models\EditModel" # Model pro bindování a validaci.
```

### Bindování částí url
Jak lze vidět v ukázce, určité části lze bindovat v tomto formátu: {id:int} kde "id" je název proměnné a "int" je typ proměnné.
Povolené proměnné:
 * int
 * string
 * float
 * long


### Modely
Modely rozšiřující \OnionSkin\Models\Model slouží pro bindování a validaci proměných pomocí anotací, nejlépe demonstrované na ukázce:
```php
namespace OnionSkin\Models;
class TestModel extends Model
{
@Validate(type="string")
@StringLength(min=3,max=9)
@AllowHTML
@Post(id="text")
public $text;


@Validate(type="email")
@Enum(values={"email@email.com","test@test.cz"})
@Required
@Get(id="email")
public $email;
}
```
#### Bindovací annotace
 * Get - Parametr se nabinduje z GET parametru
 * Post - Parametr se nabinduje z POST requestu
 * Path - Parametr se nabinduje z url cesty

#### Validační annotace
 * Enum - Povolené hodnoty
 * AllowHTML - Povolí html tagy uvnitř parametru
 * StringLength - Délka stringu
 * NumericRange - Rozmezí pro čísla
 * Required - Daný parametr nesmí být null
 * Validate - Obsah se validuje na zadaný typ
  * int
  * string
  * email
  * telephone
  * float
  * long
 
#### Validační annotace pro metody
 * PostValidate - Slouží pro vlastní validaci pomocí kódu uvnitř metody.  