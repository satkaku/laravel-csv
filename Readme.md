# laravel-csv
simple CSV manipulation for Laravel.
Also you can select encoding.

## Getting started
Add to composer.json
```
'monokakure/laravel-csv': 'dev-master'
```
Install your composer
```
composer install
```

Add ServiceProvider to app.php
```php
'Monokakure\CSV\CSVServiceProvider',
```
If you want, add Alias
```php
'CSV'=> 'Monokakure\CSV\CSVFacade',
```

## Usage
+ from array
```php
CSV::create($arr, $header);
```
+ get CSV
```php
CSV::create($arr, $header)->build();
```
+ You can select Encode
```php
CSV::setEncode('SJIS-win', 'UTF-8')->create($arr, $header)->build();
```
+ get Response
```php
CSV::create($arr, $header)->render();
```
+ parse CSV
```php
CSV::parse('sample.csv');
```

## Extend
If you want, you can use extended Monokakure\CSV\CSV class.
Override Monokakure\CSV\Factory#getCSV method.