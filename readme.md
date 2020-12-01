# URL Helper Package

![Packagist License](https://img.shields.io/packagist/l/spresnac/laravel-url-helper?style=for-the-badge)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/spresnac/laravel-url-helper?style=for-the-badge)
![Codecov](https://img.shields.io/codecov/c/gh/spresnac/laravel-url-helper?style=for-the-badge) 
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/spresnac/laravel-url-helper/tests?style=for-the-badge)
[![StyleCI](https://github.styleci.io/repos/312022644/shield?style=for-the-badge)](https://github.styleci.io/repos/312022644?branch=main)

# Installation
First things first, so require the package:

```
composer require spresnac/laravel-url-helper
```

# Usage
## Content Helper (0.2+)
### getHrefs() (0.2+)
You put in some HTML code as string, you will retrieve a Collection with only the URLs inside a `href`
```
$content_helper = new ContentHelper('insert HTML here');
$result = $content_helper->getHrefs();
// $result is an Collection with all the hrefs in it.
```

### getHrefsAsArray() (0.2+)
You put in some HTML code as string, you will retrieve an array with only the URLs inside a `href`
```
$content_helper = new ContentHelper('insert HTML here');
$result = $content_helper->getHrefsAsArray();
// $result is an Collection with all the hrefs in it.
```

## URL Helper (0.3+)
### normalize_url(string $url): string (0.3+)
Normalizes URL with .. in it and leaves the all oher URL "as is".
```
$url_helper = new URLHelper();
$normalized_url = $url_helper->normalize('https://example.com/my/dir/with/two/../init.html');
// $normalized_url is now https://example.com/my/dir/with/init.html
```

### build_url(array $parsed_url): string (0.3+)
This is the missing opposite of `parse_url` to rebuild a url from its parts.
```
$url_helper = new URLHelper();
$parsed_url = parse_url('http://example.com/test/url.php');
$my_url = $url_helper->build_url($parsed_url);
```

# Tests
Simply run
```
composer test-ci
```
or
```
vendor/bin/phpunit 
```

# Finally
Be productive 😉
