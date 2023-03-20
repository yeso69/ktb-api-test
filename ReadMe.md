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
    php bin/console doctrine:fixtures:load
    ```

With the fixtures loaded, you now have a user with id 1, that belongs to a company. You can use it to create expanse reports.

## Usage

The API exposes endpoints with the following format: `/api/expense_reports`

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

## Running the tests

To run the tests, use the following command:
```
php bin/phpunit
```
This will run the PHPUnit tests located in the `tests/` directory. Make sure that your development environment meets the requirements for running PHPUnit tests.

### Authentication

Please note that this API does not implement any authentication mechanism. For production use, it is recommended to implement OAuth2 for authentication and authorization.
