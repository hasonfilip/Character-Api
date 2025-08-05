# Character API
Jednoduchá aplikace, která vrací data z databáze ve formátu JSON vyvinutá v symfony 

## Nasazení
`git clone https://github.com/hasonfilip/Character-Api.git`
`cd Character-Api`

Aplikace vyžaduje přístup k databázi v proměnné prostředí DATABASE_URL; vložte ho do .env
`echo 'DATABASE_URL="postgres://app:!ChangeMe!@127.0.0.1:5432/app"' >> .env`

Nebo ho uložte do vaultu
`php bin/console secrets:set DATABASE_URL`

Ujistěte se, že máte nainstalovaný a povolený driver pro příslušnou databázi
`sudo apt install php-pgsql`

Nainstalujte závislosti:
`composer install`

Spusťte server:
`symfony server:start`

Nebo nakonfigurujte váš webový server dle https://symfony.com/doc/current/setup/web_server_configuration.html
