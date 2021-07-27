# paymaya-checkout-laraplate

Basic Laravel boiler plate for consuming PayMaya checkout APIs.

Includes:
- Basic implementation of PayMaya checkout APIs
- Saving transaction data to database received from webhook
- Uses moneyphp/money for handling amounts

## Installation

Install using composer

```bash
composer require stonedleaf/paymaya-checkout-laraplate
```

To register the webhooks, run the following command (Note: this will remove existing webhooks)
```bash
php artisan paymaya:webhook
```

## Configuration

Kindly check config/paymaya.php

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
