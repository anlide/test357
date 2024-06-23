# Test357

This project is designed to calculate commissions for transactions based on their BIN and currency.

## Installation

Clone the repository:

   ```sh
   git clone https://github.com/anlide/test357.git
   cd test357
   composer install
   ```

## Start the service

To start the service, run the following command:

    docker-compose up -d

## Usage the service

http://localhost:8845

## Run the tests

   ```sh
   docker-compose exec php vendor/bin/phpunit tests
   ```
