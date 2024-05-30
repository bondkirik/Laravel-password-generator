

## Clone the project from git repository:

git clone ...

## Start docker file:

docker-compose up --build -d

## Install dependencies:

docker-compose run composer install

## Copy ".env.example" to ".env" file:

cp .env.example .env

## Generate new application security token:

docker-compose run artisan key:generate

## Start Project:
## http://localhost:8080/

- input Password Length
- select any checkboxes you wish
- generate password

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
