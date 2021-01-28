# Configuration

## Discord API

### Create and authoize bot

- Create a new Discord Application on [Developpers Portal](https://discord.com/developers/applications).
- Get client ID after application has been created.
- Authorize bot on a specific server with [Permissions Calculator](https://discordapi.com/permissions.html#2147483647).
- After needed fields has beens filled, clic on auto generated link on the bottom of the page.
- Authorize bot on the server.

### Configure AfpaTicket
- Always on [Developpers Portal](https://discord.com/developers/applications) clic on **bot** in the left menu.
- Copy bot private **token** and.
- Paste token in AfpaTicket configuration: directly inside bdd (**discord_token_configs**) or from **admin page**.
- Enter guild (server) ID and save.
- After submission, you can select a notification channel.

## CONFIGURATION FILE

```
; ----------------
; PATHS
; ----------------
[PATHS]
PATH_HOME       = /home/PROD/ticket/
PATH_FILES      = files/HTML/
PATH_SQL        = files/SQL/
PATH_CLASS      = modules/
BASE_HREF       = /
PATH_UPLOAD     = upload

; ----------------
; DATABASE
; ----------------
[DATABASE]
DB_HOST    = localhost
DB_LOGIN   = DatabaseLogin
DB_PSW     = "DatabasePassword"
DB_NAME    = DatabaseName

; ----------------
; CAPTCHA GOOGLE API
; ----------------
SERVER_KEY = "6Lf9RtcZAAAAAEUQUscEcS-Cr0chxdnhxZMKteSG"

; ----------------
; MAIL
; ----------------
[MAIL]
MAIL_FROM   = "afpaticket.afpalab@afpa.fr"
MAIL_BCC    = "jean-jacques.pagan@afpa.fr"

; ----------------
; GLOBAL
; ----------------
[GLOBAL]
plateform   = prod
DOMAIN = "https://ticket.eloce-formation-afpa.com/"
```
