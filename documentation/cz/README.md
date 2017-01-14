# OnionSkin - Nástroj pro sdílení a ukládání kusů kódu.
## Rozcestník
 * [WA1 Požadavky](WA1Requirements.md) (Web by měl splňovat všechny požadované body)
 * [Zadání](About.md)
 * [Implementace](Implementace.md)
 * [Databáze](Database.md)
 * [Ukázky webu (Screenshoty)](Screenshots.md)


## Požadavky na server
 * Apache, Nginx, IIS či jiný web server podporující PHP.
 * PHP 7.0+
   * V případě přítomnosti PHP 5.* je potřeba změnit solící metodu v src/OnionSkin/Entities/User.class.php (metoda generatePassword).
 * Vhodnou databázi viz: [Databáze](Database.md#Druh_databáze)
 * Pro lepší výkon je třeba nastavit cachování, což obnáší doinstalaci a aktivaci cache enginu do php (xcache, memcache, apc). Více v [Databáze](Database.md#Cachování)   

## Nastavení práv
Z hlediska bezpečnosti je nejlepší nastavit:
```
<FilesMatch "\.(css|js|php)$">
Order Deny,Allow
   Allow from all
</FilesMatch>
```
V případě že nemáte přístup k apache, iis, či nginx. Se ujistěte že jsou na serveru povoleny .htaccess soubory a všechny soubory mají chmod 777 (O případnou restrikci se postará sama aplikace).

**!!!Document root musí ukazovat na složku public!!!**

## Instalace 
 1. Stáhněte si celý obsah repositáře.
 2. Spusťte ve staženém repositáři konzoli a zadejte: ```php composer.phar install```
 3. Vyplňte DB údaje v config/configuration.ini.
 4. Vše hotovo a můžete spustit aplikaci.
 5. **!!!Document root musí ukazovat na složku public!!!**


> První spuštění bude trvat delší dobu. Aplikace během ní sama vytváří tabulky v DB, compiluje scss do css a minimalizuje javascript.


