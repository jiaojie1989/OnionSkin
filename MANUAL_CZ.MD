
## Ochrana
Systém je chráněn proti těmto druhům útokům:
 * CSRF = Antiforgery token systém. K vidění v /src/OnionSkin/Smarty/Form.class.php (tvorba) a /src/OnionSkin/Models/Model.class.php (verifikace)
 * RFI = 
 * LFI = 

### URL Injection
Web stojí na robustním Router systému napsaném pro tento software. Díky němu se matchují pouze validní linky, například:
Záznam v router.ini:
´´´[InsertData]
page="\OnionSkin\Pages\DataPage"
method="POST"
model="\OnionSkin\Models\DataModel"
url="Data/{id:int}/{name:string};Data/{id:int}"
´´´
Díky tomu jsou následující požadavky validní:
POST /Data/15/Testovani
POST /Data/9
A tyto nejsou validní:
GET /Data/15/Testovani
POST /Data/
POST /Data/Testovani/5

### SQL Injection
Proti SQL Injection se stránka brání na několika úrovní. Zaprvé jak již bylo zmíněno u URL Injection robustním router systémem.
Následně se veškeré data z URL,GET a POST mapují do modelů, veškerá data mimo model jsou zahozena ještě než se k nim dostane samotná stránka.
Více v Mapování

### XSS

## Instalace

### IIS 
 * IIS samo nainstaluje vše potřebné z web.config
 * Vyplnění config/configuration.ini

### Apache, Nginx
#### Požadavky:
 * Povolit .htaccess v php.ini
 * Povolit Cache systém v php.ini (apc cache,atd.), vyplnit v config/configuration.ini
 * Vyplnění config/configuration.ini


# Router

