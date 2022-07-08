# Todo
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/a5a1e7be090d48059abe8c786f24455c)](https://www.codacy.com/gh/AnaMltk/Todo/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=AnaMltk/Todo&amp;utm_campaign=Badge_Grade)
## Prerequisites
- PHP 7 or higher
- Symfony 5
- Mysql
- Composer
- XDebug (optional)

## Installation

### Clone the repo

`$ git clone https://github.com/AnaMltk/Todo.git yourFolderName`

`$ cd yourFolderName`

### Edit .env file OR create .env.local to avoid commiting sensible information

`DATABASE_URL="mysql://db_user:db_password:@127.0.0.1:3306/db_name?serverVersion=5.7"`

For database connection, assign the values to db_name, db_user and db_password.

### Create database
run

`$ php bin/console doctrine:database:create`

### Composer

run

`$ composer update`

### Run latest migration

run

`$ php bin/console doctrine:migrations:migrate`

### Upload data fixtures
run

`$ php bin/console doctrine:fixtures:load`

To login, use the credentials information in data fixtures. 

## Testing

### Create test database
`$ php bin/console --env= test doctrine:database:create`

### Run migrations 
`$ php bin/console --env=test doctrine:migrations:migrate`

### Load fixtures
`$ php bin/console --env=dev doctrine:fixtures:load`

### To run automated tests run 
`./vendor/bin/phpunit`

If you have installed and enabled XDebug, to monitor code coverage you can run 

`XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html coverage`

The detailed coverage is in the file [index](coverage/index.html)




