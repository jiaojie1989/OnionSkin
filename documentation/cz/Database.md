# Databáze
## UML Diagram
![Alt text](http://www.plantuml.com/plantuml/png/ZPB1ReCm38RlUGghfoqQPRjELQLT-WBTpiWbBeiK4fIuMwkfxxuKmX1Gf74X-7Di_jzcLn5_aeSVKHeC0Jv2_DXiuE7zoPDwXEqs8W0fjMK9mtEAUOLMKaOOs6jRoG5Oh6aQfngrcGQRsFBRUVLcrHuDJt7WYvaLCcYh65F8nBecsHsBqbDygKWEpXb2Uqj7LMihhYA9srlTDCJ_q1Uwp5vXdaSCCDUVvtVfqHary52ZCQa-bYM5K1ZwefaRh7akb-ayz-LY6SztJ42bMWkcyTefVTGZ10dHkT4UMRkRJzTarAxz_x5FTzVWJ-Y2JN72dYplHdwqQNB9pP5IIAkqFEr5gN7gGYGXg-VrMguWsxQdbrKI-0hxqw6J44Ix-GbdMNybhKoY8zJL4FrIzJsoSOzV)
### Vysvětlivky:
 * Primární klíč je označen **tučně**.
 * Cizí klíč s vazbou je označen *kurzívou*.
   * Snippet->user_id na User->user_id
   * Snippet->folder_id na Folder->folder_id
   * Folder->parentFolder_id na Folder->folder_id
   * Folder->user_id na User->user_id
 * Not null hodnoty jsou označeny * za datovým typem
 * Ostatní limitace jako délka stringu nalezne u jednotlivých entit v src/OnionSkin/Entities

Z návrhu lze vidět o jedno propojení víc než by bylo třeba kdyby každý uživatel měl svojí "root" složku místo null záznamu. Nicméně se u aplikace počítá s tím že většina uživatelů nevyužije systém složek a vše bude tvořit do "rootu".

## Druh databáze
OnionSkin funguje se všemi databázemi s [Doctrine Plafroms konektorem](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/platforms.html).
### MySQL
Pro MySQL je doporučováno využít Innodb z důvodu plné transactionality. Tudíž plnou podporu pro rollbacky dat. Zároveň nabízí row-level lock oproti MyISAM která nabízí pouze table-level lock. (Při manipulaci s daty v tabulce není třeba lockovat záznamy které s daty nijak nesouvisí.)

### Cachování
Pro rychlejší čtení z databáze je vhodné nastavit [Cachování](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/caching.html)

## PlantUML zápis DB
Tento zápis převedený na diagram vidíte na horní části této stránky.
```plantuml
together {
class User << (T,red) >> {
  **int*           user_id**
  string*      username
  string*      email
  string*      passwordAndSalt
  string*      style
  string*      lang
  datetime*  date_created
  boolean*   admin
}

class Snippet << (T,red) >> {
  **int*          snippet_id**
  //int             user_id//
  //int             folder_id//
  smallint*   access_level
  string*      title
  string*      text
  string*      syntax
  datetime*  date_added
  datetime*  date_modified
  datetime   date_expiration
}
}
class Folder << (T,red) >>{
  **int*           folder_id**
  //int              parentFolder_id//
  //int*            user_id//
  string*       name
  datetime*  date_created
  datetime*  date_modified
}



Folder "0..*" -> "0..1" Folder: Subfolders
User "0..1" -- "0..*" Snippet
User "1" -- "0..*" Folder
Snippet "0..*" -- "0..1" Folder
```