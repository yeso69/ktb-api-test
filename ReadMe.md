# ExpenseReport API

This is a REST API developed with Symfony 5 and API Platform to handle expense reports.

## Installation

1. Clone the repository:

    ```
    git clone https://github.com/yeso69/ktb-api-test.git
    ```

2. Install the dependencies:

    ```
    cd ktb-api-test
    composer install
    ```

3. Configure the database:

    ```
    cp .env .env.local
    ```

   Then, edit the `.env.local` file and set the database URL to your local database.

4. Create the database schema:

    ```
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

5. Load fixtures:

    ```
    php bin/console hautelook:fixtures:load
    ```

With the fixtures loaded, it creates a company with a user that has 5 expanse reports. You will be able to use the user with id 1 to create expanse reports.

## Usage

### Running the server

To start the development server, use the following command:
```
php -S localhost:8000 -t public
```
This will start the server on `http://localhost:8000`. You can then access the API by visiting the endpoint URLs in your web browser or using a tool like `curl` or `Postman`.

## API Documentation

API Platform provides an interactive documentation (Swagger UI) for your API. You can access it by visiting the following URL in your web browser:

http://localhost:8001/api

This will bring up the API documentation, where you can explore the different endpoints and make test requests. Note that this documentation is only available in a development environment, and should not be used in production.

### Endpoints

- `GET /api/expense_reports`: Returns a collection of all expense reports.
- `POST /api/expense_reports`: Creates a new expense report.
- `GET /api/expense_reports/{id}`: Returns a single expense report by ID.
- `PUT /api/expense_reports/{id}`: Updates an existing expense report by ID.
- `DELETE /api/expense_reports/{id}`: Deletes an existing expense report by ID.

### Example

Here's an example of an ExpenseReport POST request:

```json
{
    "date": "2022-10-19T00:00:00+00:00",
    "amount": 100,
    "type": "Food",
    "user": "/api/users/1"
}
```

### Running the tests

To run the tests, use the following command:
```
php bin/phpunit
```
This will run the PHPUnit tests located in the `tests/` directory. Make sure that your development environment meets the requirements for running PHPUnit tests.

### Authentication

Please note that this API does not implement any authentication mechanism. For production use, it is recommended to implement OAuth2 for authentication and authorization.
