# Mars Time Converter API Symfony 5

## Usage

There's no need to configure anything to run the application. If you have installed Symfony, run this command and access the application in your browser at the given URL (<https://localhost:8000> by default):

```bash
$ cd my_project/
$ symfony serve
```

If you don't have the Symfony binary installed, run `php -S localhost:8000 -t public/` to use the built-in PHP web server or configure a web server like Nginx or Apache to run the application.
Don't forget to run composer install too.

```
composer install
```

## End point

```
/:timeUTC
```

## Example

```
localhost:8000/2020-03-18T19:56:55Z
```

## Returned json

```
{
  "MarsSolDate": "51,976.43194",
  "MartianCoordinatedTime": "10:21:60"
}
```

## Tests

Execute this command to run tests:

```bash
$ cd my_project/
$ ./bin/phpunit
```
