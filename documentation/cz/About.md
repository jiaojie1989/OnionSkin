# O projektu
## Zadání
Vytvořte web pro sdílení krátkých útržků kódu s vyznačenou syntaxí kódu. Útržky půjdou třídit do složek, nastavovat jejich viditelnost a bude možné získávat jejich obsah bez přítomnosti UI prvků. Uživatelé se budou moci registrovat a přihlašovat, měnit vzhled a jazyk aplikace a míti skryté (private) útržky.

## Use case
![http://www.plantuml.com/plantuml/png/bP1D2i8m48NtFSKixQ8NA2AKkgmRmGF4T1g3SL8ogTruUDF_W2Au2M_cVRpa9I_gXwOS1CEealp2wCPv44bUMQMmNfVRc2J32VjNbiNRJKxMb3gnMTTc1zYL3eL78Eo1IRSj-dJsWrbfzj1sLwFbul9Y6spym1HI8ZC8O_uXdVKeFTOh34yjm6YwnzTRfIcQpwZ2Wz2bSR4r_eW6GnFRqzRa6rVU1AaVN41EWiICDDRKwFW36Rycok3q3G00](http://www.plantuml.com/plantuml/png/bP1D2i8m48NtFSKixQ8NA2AKkgmRmGF4T1g3SL8ogTruUDF_W2Au2M_cVRpa9I_gXwOS1CEealp2wCPv44bUMQMmNfVRc2J32VjNbiNRJKxMb3gnMTTc1zYL3eL78Eo1IRSj-dJsWrbfzj1sLwFbul9Y6spym1HI8ZC8O_uXdVKeFTOh34yjm6YwnzTRfIcQpwZ2Wz2bSR4r_eW6GnFRqzRa6rVU1AaVN41EWiICDDRKwFW36Rycok3q3G00)

### Use case v formátu plantuml
```
:Admin: as Admin
:User: as User
:LoggedUser: as LoggedUser

User <|-- LoggedUser
LoggedUser <|-- Admin

User -up-> (Create new snippet)
User -> (List public snippets)
User -left-> (Access all public snippets)
User -left-> (Access all protected snippets via link)
User -> (Login)
User -> (Register)
LoggedUser -left-> (Delete own snippet)
LoggedUser -left-> (Change own snippet)
LoggedUser -> (Manage own folders)
LoggedUser -> (List own snippets)

```