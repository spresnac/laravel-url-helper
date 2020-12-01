# URL Helper Package

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
![PHP from Packagist](https://img.shields.io/packagist/php-v/spresnac/laravel-url-helper.svg)
[![codecov](https://codecov.io/gh/spresnac/laravel-url-helper/branch/main/graph/badge.svg?token=6BEX55062B)](https://codecov.io/gh/spresnac/laravel-url-helper) 
[![StyleCI](https://github.styleci.io/repos/312022644/shield)](https://github.styleci.io/repos/312022644)
[![CI Status](https://github.com/spresnac/laravel-url-helper/workflows/tests/badge.svg)](https://github.com/spresnac/laravel-url-helper/actions)

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
