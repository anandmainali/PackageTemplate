# PackageTemplate
[![Latest Version](https://img.shields.io/github/issues/anandmainali/PackageTemplate)](https://github.com/anandmainali/PackageTemplate/releases)
![forks](https://img.shields.io/github/forks/anandmainali/PackageTemplate)
![stars](https://img.shields.io/github/stars/anandmainali/PackageTemplate)
![license](https://img.shields.io/github/license/anandmainali/PackageTemplate)
[![Total Downloads](https://img.shields.io/packagist/dt/anandmainali/PackageTemplate?style=flat-square)](https://packagist.org/packages/anandmainali/packagetemplate)

Package template helps to create a structure of package with single command. It also provides other commands
to generate files just as in laravel.

## Installation
Use the package manager <a href="https://packagist.org/packages/anandmainali/packagetemplate" target="_blank">composer</a> to install PackageTemplate.

<code>composer require anandmainali/packagetemplate</code>

## Enable the package (Optional)
This package implements Laravel auto-discovery feature. After you install it, the package provider and facade are added automatically for laravel >= 5.5.

## Configuration
After installation, you have to publish config file.

<code>php artisan vendor:publish --tag=package-config</code>

This will generate `package.php` file inside the config folder.

### Package.php

```php
<?php

return [
  /**
   * Main folder to holds all the packages. Contains packages with VendorName. 
   */
  'path' => 'packages',
  
  /**
   * The VendorName will be generated inside the main folder.
   */
  'vendorName' => "VendorName",
  
  /**
   * These are the folders that will be generated while creating package.
   */
  'folders' => [
    'controllers', 'databases/migrations', 'models', 'policies', 'resources/views', 'routes'
  ],
  
  /**
   * These are the files that will be generated while creating package.
   */
  'files' => ['routes/web']

];
```

Now, you can start building your package. To generate package,

` php artisan create:package PackageName ` 

And, all the files and folders you specified in `config.php` will be generated.

### Other Available Commands with `php artisan`

<b>Note:-</b> The `PackageName` is used to generate files inside the package. 

```
create:model ModelName PackageName
create:controller ControllerName PackageName --r //--r is optional. It is used to create resource controller.
create:migration MigrationName TableName PackageName
create:policy PolicyName PackageName
```
