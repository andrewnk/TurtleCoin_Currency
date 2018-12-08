# TurtleCoin_Currency
This module adds TurtleCoin currency to Magento 2. Magento 2 uses PHP ICUData for currency values so adding a new currency to Magento 2 is not that straight forward. This module uses custom resource files to add TurtleCoin to Magento 2. If you will be using a currency other than TurtleCoin as your base currency, you have the ability to hook into CoinMarketCap's API to automatically pull up-to-date exhange rates.

Installation:
```console
composer config repositories.turtlecoin/currency vcs https://github.com/andrewnk/TurtleCoin_Currency.git
composer require turtlecoin/currency:dev-master
php bin/magento module:enable TurtleCoin_Currency
php bin/magento setup:upgrade
```

Using:
You have the option to use TurtleCoin as your Base Currency (the default currency you would use to price your products) or as an additional Allowed Currency (the customer will be able to switch between currencies on the frontend). Navigate to ```Stores > General > Currency Setup``` to make the necessary changes.

If you are going to use TurtleCoin as an Additional Currency you will first need to set up an account (the free option is enough) at [CoinMarketCap](https://pro.coinmarketcap.com/) and get an API Key. Once you have your key navigate to ```Stores > TurtleCoin > Currency```, enter in the API Key and save. You may test your key by pressing the ```Test API``` button. If the test request fails, check your exception.log for details.

Notes:
Use composer to install this module, because without proper autoload configuration this module won't work

This module modifies the core table ```directory_currency_rate```. It extends the column length  for *currency_from* and *currency_to* from 3 to 4 to allow us to have four character currencies like *TRTL*

If you are not using TurtleCoin as your base currency, you will need to ensure your base currency is in the list of fiat currencies accepted by the CoinMarketCap endpoint:

| Currency | Currency Code |
| ---- | ---- |
| United States dollar ($)  | USD |
| Australian dollar ($)     | AUD |
| Brazilian real (R$)       | BRL |
| Canadian dollar ($)       | CAD |
| Swiss franc (Fr)          | CHF |
| Chilean peso ($)          | CLP |
| Chinese yuan (¥)          | CNY |
| Czech koruna (Kč)         | CZK |
| Danish krone (kr)         | DKK |
| Euro (€)                  | EUR |
| British pound (£)         | GBP |
| Hong Kong dollar ($)      | HKD |
| Hungarian forint (Ft)     | HUF |
| Indonesian rupiah ( Rp)   | IDR |
| Israeli new shekel (₪)    | ILS |
| Indian rupee (₹)          | INR |
| Japanese yen (¥)          | JPY |
| South Korean won (₩)      | KRW |
| Mexican peso ($)          | MXN |
| Malaysian ringgit (RM)    | MYR |
| Norwegian krone (kr)      | NOK |
| New Zealand dollar ($)    | NZD |
| Philippine piso (₱)       | PHP |
| Pakistani rupee (₨)       | PKR |
| Polish złoty (zł)         | PLN |
| Russian ruble (₽)         | RUB |
| Swedish krona (kr)        | SEK |
| Singapore dollar ($)      | SGD |
| Thai baht (฿)             | THB |
| Turkish lira (₺)          | TRY |
| New Taiwan dollar ($)     | TWD |
| South African rand (R)    | ZAR |

Code to add a new currency type was adapted from this [module](https://github.com/aminlatif/Babirusa_Toman.git)