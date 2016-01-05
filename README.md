# Phrontmatter

[![StyleCI](https://styleci.io/repos/47688815/shield)](https://styleci.io/repos/47688815)
[![Build Status](https://img.shields.io/travis/BlueBayTravel/Phrontmatter.svg?style=flat-square)](https://travis-ci.org/BlueBayTravel/Phrontmatter)

```php
// Parse a document.
Phrontmatter::parse("---\nfoo: bar---\nThis is actual content!")->foo;

// Dependency injection example.
$phrontmatter->parse("---\nfoo: bar---\nThis is actual content!")->getContent();
````

For more information on Frontmatter, see the [Jekyll documentation](http://jekyllrb.com/docs/frontmatter/).

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
composer require bluebaytravel/phrontmatter
```

### Laravel Installation

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
