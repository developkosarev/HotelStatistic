# Installation

Download application and run these commands:

```bash
$ cd HotelStatistic/
$ composer install
$ npm install
$ npm run build
```

Database setup

- Create two MySQL databases for dev and test environments
- Create settings files .env.local and .env.test.local and override an DATABASE_URL in there files
- After that run these commands:

```bash
$ php bin/console doctrine:database:create --env=dev
$ php bin/console doctrine:schema:update --force --env=dev
$ php bin/console doctrine:fixtures:load --env=dev
$ php bin/console doctrine:database:create --env=test
$ php bin/console doctrine:schema:update --force --env=test
$ php bin/console doctrine:fixtures:load --env=test
```

## Usage

Run `php -S localhost:8000 -t public/` and access the application in your
browser at the given URL (<https://localhost:8000> by default):

## Unit Tests: 
./vendor/bin/phpunit --colors --verbose --testdox