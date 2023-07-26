# php-firebase-cloud-messaging
PHP API for Firebase Cloud Messaging from Google

Currently this app server library only supports sending Messages/Notifications via HTTP V1 API.

See original Firebase docs: https://firebase.google.com/docs/

# Setup
Install via Composer:
```
composer require rhinos-solutions/php-firebase-cloud-messaging
```

Or add this to your composer.json and run "composer update":

```
"require": {
    "rhinos-solutions/php-firebase-cloud-messaging": "dev-master"
}
```

# Send message to Device
```php
use rhinos\PhpFirebaseCloudMessaging\Client;
use rhinos\PhpFirebaseCloudMessaging\Message;
use rhinos\PhpFirebaseCloudMessaging\Recipient\Device;

$client = new Client();
$client->setServiceAccount(__DIR__.'/google-service-account.json');
$client->setProject('<<FIREBASE_PROJECT_ID>>');

$message = new Message();
$message->addRecipient(new Device('_YOUR_DEVICE_TOKEN_'));
$message
    ->setNotification('some title', 'some body')
    ->setData('key', 'value')
;

$response = $client->send($message);
var_dump($response->getStatusCode());
var_dump($response->getBody()->getContents());
```
