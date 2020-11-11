# URL Helper Package

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
![PHP from Packagist](https://img.shields.io/packagist/php-v/spresnac/laravel-url-helper.svg)
![Packagist](https://img.shields.io/packagist/l/spresnac/laravel-url-helper.svg)
[![Build Status](https://travis-ci.org/spresnac/laravel-url-helper.svg?branch=master)](https://travis-ci.org/spresnac/laravel-url-helper)  
[![codecov](https://codecov.io/gh/spresnac/laravel-url-helper/branch/master/graph/badge.svg)](https://codecov.io/gh/spresnac/laravel-url-helper) 
[![StyleCI](https://github.styleci.io/repos/312022644/shield?branch=master)](https://github.styleci.io/repos/312022644)

# Installation
First things first, so require the package:

```
composer require spresnac/laravel-url-helper
```

# Usage
## Content Helper
### getHrefs()
You put in some HTML code as string, you will retrieve a Collection with only the URLs inside a `href`
```
$content_helper = new ContentHelper('insert HTML here');
$result = $content_helper->getHrefs();
// $result is an Collection with all the hrefs in it.
```

### getHrefsAsArray()
You put in some HTML code as string, you will retrieve an array with only the URLs inside a `href`
```
$content_helper = new ContentHelper('insert HTML here');
$result = $content_helper->getHrefsAsArray();
// $result is an Collection with all the hrefs in it.
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