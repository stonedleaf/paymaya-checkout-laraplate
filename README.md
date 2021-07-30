
# Paymaya Checkout Laraplate

![Packagist version](https://img.shields.io/packagist/v/stonedleaf/paymaya-checkout-laraplate) ![License](https://img.shields.io/packagist/l/stonedleaf/paymaya-checkout-laraplate) ![enter image description here](https://img.shields.io/packagist/dt/stonedleaf/paymaya-checkout-laraplate)

Basic starter kit for consuming PayMaya checkout APIs in Laravel

Includes:
- Basic implementation of PayMaya checkout APIs
- Saving transaction data to database received from webhook
- Uses moneyphp/money for handling amounts

## Installation

Install using composer

```bash
composer require stonedleaf/paymaya-checkout-laraplate
```

Publish the files
```bash
php artisan vendor:publish --provider=Stonedleaf\PaymayaCheckoutLaraplate\PaymayaServiceProvider
```

To register the webhooks, run the following command (Note: this will remove existing webhooks)
```bash
php artisan paymaya:webhook
```

To delete all paymaya API settings (Webhook and Shop Customizations), run the following command
```bash
php artisan paymaya:clear
```

## Configuration

**Configuration File**

Kindly check `config/paymaya.php`

**Overriding Transaction Model**

To use your own transaction model, inform your new transaction model in your application's `App\Providers\AppServiceProvider` class using the following code as reference

  ```php
use App\Models\PayMaya\Transaction;

public function boot()
{
    Paymaya::useTransactionModel(Transaction::class);
}
```

**Overriding Migrations**

If you would like to prevent the default migrations from running, you may use `ignoreMigrations`. Usually this should be called in the `register` method of your `AppServiceProvider`

  ```php
use Stonedleaf\PaymayaCheckoutLaraplate\Paymaya;

public function register()
{
    Paymaya::ignoreMigrations();
}
```

Afterwards, you may use your own migrations. Make sure you replaced the transaction model above

**Overriding Routes**

If you would like to prevent the default routes from running, you may use `ignoreMigrations`. Usually this should be called in the `register` method of your `AppServiceProvider`

  ```php
use Stonedleaf\PaymayaCheckoutLaraplate\Paymaya;

public function register()
{
    Paymaya::ignoreRoutes();
}
```

Afterwards, make sure you point the `webhook_routes` setting in `config/paymaya.php` to the correct routes.

For webhook controller reference, you may check `Stonedleaf\PaymayaCheckoutLaraplate\Http\Controllers\WebhookController.php`

## Examples

< under construction >

For API, you may checkout `Stonedleaf\PaymayaCheckoutLaraplate\CheckoutBuilder.php`

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
