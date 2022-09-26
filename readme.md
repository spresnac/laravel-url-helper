# URL Helper Package

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
![PHP from Packagist](https://img.shields.io/packagist/php-v/spresnac/laravel-url-helper.svg)
[![codecov](https://codecov.io/gh/spresnac/laravel-url-helper/branch/main/graph/badge.svg?token=6BEX55062B)](https://codecov.io/gh/spresnac/laravel-url-helper)
[![CI Status](https://github.com/spresnac/laravel-url-helper/workflows/tests/badge.svg)](https://github.com/spresnac/laravel-url-helper/actions)

---
# Content:

- [Installation](#installation)
- [Usage](#usage)
  - [Content Helper](#content-helper) 
  - [URL Helper](#url-helper)
  - [Sitemap Helper](#sitemap-helper)
- [Tests](#tests)
- [Finally](#finally)

---

# Installation
First things first, so require the package:

```shell
composer require spresnac/laravel-url-helper
```

---

# Usage
## Content Helper
Every time you need to get URLs from some kind of Text or HTML, this class is a helping hand for you.  
1. Make an instance of the class
2. Use the constructor or the `setContent` method to put in your content as string.
3. Get your URLs by using one of the following methods.

---

### getContent(): string
This will just the content you put in via constructor or `setContent` method.

---

### getHrefs(): Collection
You will retrieve a Collection with only the URLs inside a `href`
```php
$content_helper = new ContentHelper('insert HTML here');
$result = $content_helper->getHrefs();
// $result is an Collection with all the hrefs in it.
```

---

### getHrefsAsArray(): array
You will retrieve an array with only the URLs inside a `href`
```php
$content_helper = new ContentHelper('insert HTML here');
$result = $content_helper->getHrefsAsArray();
// $result is an Collection with all the hrefs in it.
```

---

### getSrcUrls(): Collection
You will retrieve a collection of urls from `src` sources.
```php
$content_helper = new ContentHelper('insert HTML here');
$result = $content_helper->getSrcUrls();
// $result is an Collection with all the src-urls in it.
```

---

### getLinksFromPlaintext(): Collection
This method will try to find all the urls in a plaintext string.
```php
$content_helper = new ContentHelper('insert some plaintext here');
$result = $content_helper->getLinksFromPlaintext();
// $result is an Collection with all the urls from the plaintext in it.
```

---

### getAllTheLinks(): Collection
This will execute `getHrefs`, `getSrcUrls` and `getLinksFromPlaintext` and will return a uniqueified collection of all the urls.
```php
$content_helper = new ContentHelper('insert some html or plaintext here');
$result = $content_helper->getAllTheLinks();
// $result is an Collection with all the urls.
```

---

## URL Helper
Some useful helper functions to handle URL related manipulating or info-gatherings.

---

### normalize_url(string $url): string|false
Normalizes URL with .. in it and leaves the all oher URL "as is".
```php
$url_helper = new URLHelper();
$normalized_url = $url_helper->normalize('https://example.com/my/dir/with/two/../init.html');
// $normalized_url is now https://example.com/my/dir/with/init.html
```
Returns `false` in case of error

---

### build_url(array $parsed_url): string 
This is the missing opposite of `parse_url` to rebuild a url from its parts.
```php
$url_helper = new URLHelper();
$parsed_url = parse_url('https://example.com/test/url.php');
$my_url = $url_helper->build_url($parsed_url);
```

---

### getMainDomainPart(string $url): string
This will return the "Main Domain" part of an URL. The "Main Domain" is like the SLD + TLD domain part.
```php
$url_helper = new URLHelper();
$main_domain_part = $url_helper->getMainDomainPart('https://www3.example.com/some/url');
// $main_domain_part is now "example.com"
```

---

### getSubdomainPart(string $url): string
This will return the Subdomain part of an URL.
```php
$url_helper = new URLHelper();
$sub_domain_part = $url_helper->getMainDomainPart('https://www3.brick.example.com/some/url');
// $sub_domain_part is now "www3.brick"
```

---

## Sitemap Helper
Handling with web-sitemaps can be handy with some helpers at your side.

---

### process_input_from_string(string $input_string): Collection
Will return all the urls inside a sitemap as Collection
```php
$sitemap_helper = new SitemapHelper();
$urls = $sitemap_helper->process_input_from_string('content_of_your_sitemap_as_string');
// $urls are a collection of all the urls found
```

---

### process_input_from_url(string $input_url): Collection (0.5+)
Returns the urls in a sitemap url as Collection
```php
$sitemap_helper = new SitemapHelper();
$urls = $sitemap_helper->process_input_from_url('url_to_your_sitemap');
// $urls are a collection of all the urls found
```

---

# Tests
Simply run
```shell
composer test-ci
```
or
```shell
vendor/bin/phpunit 
```

---

# Finally
Be productive 😉
