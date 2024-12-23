## Running local project

Up project with Joilson provided settings

```
./bin/setup
```

Access the web project in your browser

http://localhost:8082/

## Project structure

- PHP 8.4
- Mysql 8
- Architecture MVC
- Framework Laravel 11
- docker provided by laravel sail (reason: only for local)

## Best practices

- Controllers
- Requests
- DTOs
- API doc with Open API
- Authenticated api routes with JWT for registered user credentials
- Repositories
- Services
- Unit Tests
- Feature Tests
- Code coverage: 96%
- Strategy pattern for reports
- database relations provided by models
- Mysql View for complex reports
- Custom error handler for handle custom API exceptions
- Custom Test case for handle testes with DatabaseRefresh with mysql views
- Test with model factories
- Front with Vuejs

## Custom Scripts

See code coverage

```
./vendor/bin/sail php artisan test --coverage
```

Up or access NPM

```
./vendor/bin/sail npm run dev
```

Access Artisan commands

```
 ./vendor/bin/sail php artisan (before ./vendor/bin/sail up -d)
```

