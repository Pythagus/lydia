# Lydia payment
[Lydia](https://lydia-app.com/fr) is an online-payment solution. This package presents an implementation of this tool in 
an Object-Oriented view. This is a stand-alone package.

## Version
This package works since PHP 7.3. Please refer to the next table to check whether your PHP version is compatible with this package.

|Package version|PHP version|
|---------------|-----------|
| 1.x           | 7.x, 8.x  |


## Installation

### With composer
Use the package manager [composer](https://getcomposer.org/) to install this package.

```bash
composer require pythagus/lydia
```

### Without package manager
You can clone the current repository and completely use this package. You need to make (or use) an autoload package 
(like [composer](https://getcomposer.org/)) to correctly discover the files.

## Usage
This section describes how to correctly and fully use this package.

### The Lydia facade
The ```Pythagus\Lydia\Lydia``` class allows you to custom the Lydia main interactions with your application. 
**You need to extend this class**. The package won't work otherwise. You can refer to the [example/MyLydiaFacade](example/MyLydiaFacade) 
class to have an example how to override this class.

When you override the ```Lydia``` class, you need to àdd the next line to be taking into account:
```php 
Lydia::setInstance(new MyLydiaFacade()) ;
```
If you are using a framework, you can add this line when your application is starting. If you are not, you need to add this 
line before every request you make.

**Note :** if you are using a framework, you will probably have a redirect response manager. So you can override the ```Lydia.redirect()``` 
method to use your framework instead.

### Configuration
You have an example of a configuration file in the [example folder](example). The ```MyLydiaFacade``` class show you what you should 
override to adapt this package to your application. I suggest you copying the ```lydia.php``` config file and only add your personal keys.

#### Properties
The ```properties``` key in the ```example/lydia.php``` config file allows you to declare some properties that won't change from a 
request to another (like the currency).

### Lydia requests
For now, the package implements 3 Lydia's requests:

#### PaymentRequest
Make a payment request to the Lydia's server. You need to use the ```setFinishCallback()``` method to define the return route using by 
Lydia to redirect the user. You also need to define **amount** and **recipient** parameters like:
```php
$request = new PaymentRequest() ;
$request->setFinishCallback('my/route') ;
$data = $request->execute([
	'amount'    => 5,
	'recipient' => 'test@test.com'
]) ;

// Save your data.

return $request->redirect() ;
```

The ```execute()``` method will redirect the user to the Lydia's page. After payment, the user will be redirected to ```my/route```.

#### PaymentStateRequest
Check the state of a payment. You need to set the ```request_uuid``` that is given in the ```Lydia.savePaymentData()``` array when the payment is requested.
You can execute the request like:
```php
$request = new PaymentStateRequest("payment_request_uuid") ;
$state   = $request->execute() ;
```

#### RefundRequest
Refund partially or globally a transaction. You need to set the ```transaction_identifier``` that is given in the ```PaymentRequest``` finish route.
You need to add the **amount** parameter.
You can execute the request like:
```php
$request = new RefundRequest("payment_transaction_identifier") ;
$status  = $request->execute([
	'amount' => 10
]) ;
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](LICENSE)