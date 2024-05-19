# File Cast

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mohammedmanssour/file-cast.svg?style=flat-square)](https://packagist.org/packages/mohammedmanssour/file-cast)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mohammedmanssour/file-cast/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mohammedmanssour/file-cast/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mohammedmanssour/file-cast.svg?style=flat-square)](https://packagist.org/packages/mohammedmanssour/file-cast)

This Laravel package makes file management straightforward. It automatically saves uploaded files to the disk and stores their paths in the database. When you retrieve these files, it wraps the paths in easy-to-use value objects. The package also keeps track of any changes, ensuring old files are deleted when updates occur. It’s a simple way to keep your file handling neat and efficient.

## Features

-   Mapping uploaded files from the Request to the Model.
-   Old files are automatically deleted upon model update or deletion.
-   File Value Object for easy access

## Installation

You can install the package via composer:

```bash
composer require mohammedmanssour/file-cast
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="file-cast-config"
```

## Usage

1. Add the `FileCast` to your casts list

```php
protected $casts = [
    'government_id' => FileCast::class, // uses default public disk that can be change from configuratuin. and uses table name as a path
    'verification_video' => FileCast::class.':s3', // uses s3 disk for upload and uses table name as a path
    'profile_picture' => FileCast::class.':s3,pics', // uses s3 disk for upload and uses pics as a path
];
```

2. **Optional**, if you want to clean old files upon model update or delete, add the following observer to your model

```php
User::observe(UploadedFilesObserver::class);
```

3. On Model Retrieval, the casted attribute is converted to a file object that provides the following method

```php
$model->profile_picture->path(); // return the saved path in the db.
$model->profile_picture->fullPath(); // return the full path based on the provided disk
$model->profile_picture->size(); // return the file size
$model->profile_picture->url(); // return the file url based on the provided disk
$model->profile_picture->exists(); // return true of false
$model->profile_picture->delete(); // delete the file
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

-   [Mohammed Manssour](https://github.com/mohammedmanssour)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
