Yii 2 Admin Project Template
============================

Yii 2 Admin Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for rapidly creating admin backends projects.

Features:
* Application files in its folder.
* [AdminLTE](https://github.com/almasaeed2010/AdminLTE) theme imported
* User schema and user login/register forms.
* AdminLTE specific widgets exposed as Yii2 widgets:
  * Box (with expanded/collapsed state)
  * Tabs
  * Select2
  * GridView
  * ItemList (wrapper for nice AdminLTE lists)
  * TimePicker
  * TypeAhead (bootstrap version from @bower/typeahead.js)
   

DIRECTORY STRUCTURE
-------------------

    bin/   contains command line utilities
    app/   contains your application 
          assets/         contains assets definition
          base/           contains base classes
          commands/       contains console commands (controllers)
          components/     contains various components (Menu, etc)
          config/         contains application configurations
          controllers/    contains Web controller classes
          forms/          contains web forms
          helpers/        contains application helpers
          mail/           contains view files for e-mails
          models/         contains model classes
          tests/          contains various tests for the basic application
          views/          contains view files for the Web application
          widgets/        contains widgets ready to use in views
    vendor/      contains dependent 3rd-party packages
    runtime/     contains files generated during runtime
    web/         contains the entry script and Web resources
    config.php   local site application configuration

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.

INSTALLATION
------------

Clone repository:
~~~
git clone https://github.com/skoro/yii2-admin-template.git yii2-admin
~~~

Get composer and install required plugin and project dependencies:
~~~
curl -sS https://getcomposer.org/installer | php
php composer.phar global require "fxp/composer-asset-plugin"
php composer.phar install
~~~

Set directory permissions:
~~~
chmod 777 ./runtime ./web/assets
~~~

Edit configuration:
~~~
cp config-sample.php config.php
~~~

Set cookie validation key in `config.php` file to some random secret string:

```php
'request' => [
    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey' => '<secret random string goes here>',
],
```

CONFIGURATION
-------------

Your local site configuration reside in `config.php`. You can create `config.php`
by copy `config-sample.php`.

### Database

Edit the file `config.php` in web root folder with real data, for example:
```php
'db' => [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    // Or SQLite3 database (directory data must be already created and must be
    // writable by webserver).
    // 'dsn' => 'sqlite:@runtime/data/db.sq3',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

Import database migrations:
```
./bin/yii migrate
```
This imports user schema to your database.

### Enable debug mode

Uncomment following lines in `config.php`:
```php
define('YII_DEBUG', true);
define('YII_ENV', 'dev');
```

If you are on local network (not 127.0.0.1) make debug modules happy with
following lines:
```php
    'modules' => [
        'debug' => [
            'allowedIPs' => ['192.168.1.*'],
        ],
        'gii' => [
            'allowedIPs' => ['192.168.1.*'],
        ],
    ],
```
These lines enable `debug` and `gii` modules for clients from `192.168.1.*`
subnetwork.

TESTING
-------

After application has been installed and configured it's time to test it.
First of all, create user via command `yii` line utility:
```
./bin/yii user/create mail@address.com "User name"
```

Then launch local web server:
```
./bin/yii serve
```

Now you can access the application through the following URL and try to login:
```
http://localhost:8080
```
