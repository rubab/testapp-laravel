
## Set up .env file

cp .env.example .env

update .env variables to set up project.

## To setup sqlite DB 

`DB_DATABASE_TEMP=` give absolute path of database file in `.env` file

## Install dependencies
`composer install`

## Run following commands

for migrations run command, `php artisan migrate --database=sqlite`

- To update MySQL DB: `php artisan migrate`
- To run project on localhost `php artisan serve`
- To run jobs in background: `php artisan queue:work`
