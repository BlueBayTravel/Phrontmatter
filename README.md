# Phrontmatter

```php
// Parse a document.
Phrontmatter::parse("---\nfoo: bar---\nThis is actual content!")->foo;

// Dependency injection example.
$phrontmatter->parse("---\nfoo: bar---\nThis is actual content!")->getContent();
````

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
composer require bluebaytravel/phrontmatter
```

Add the service provider to `config/app.php` in the `providers` array.

```php
BlueBayTravel\Phrontmatter\PhrontmatterServiceProvider::class
```

If you want you can use the [facade](http://laravel.com/docs/facades). Add the reference in `config/app.php` to your aliases array.

```php
'Phrontmatter' => BlueBayTravel\Phrontmatter\Facades\Phrontmatter::class
```

## License

Blue Bay Travel Phrontmatter is licensed under [The MIT License (MIT)](LICENSE).
