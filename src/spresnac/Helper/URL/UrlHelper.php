<?php

namespace spresnac\Helper\URL;

use Illuminate\Support\Str;

class UrlHelper
{
    /**
     * This is for building a valid URL from inputs with `..` as folder in an url.
     *
     * @param  string  $url  The url to be normalized
     * @param  bool  $lower_result  You want the result to be lowercased?
     * @return string The normalized url
     */
    public function normalize_url(string $url, bool $lower_result = true): string
    {
        $url = Str::of($url)->trim();
        if ($lower_result) {
            $url = $url->lower();
        }
        if ($url->contains('..')) {
            $url_token = parse_url($url);
            $path_token = Str::of($url_token['path'])->explode('/');
            $path_fragment = $path_token;

            while ($path_fragment->contains('..')) {
                $path_fragment->each(function (string $path_part, $key) use (&$path_fragment) {
                    if ($path_part === '..') {
                        $path_fragment->pull($key - 1);
                        $path_fragment->pull($key);
                        $path_fragment = $path_fragment->values();

                        return false;
                    }
                });
            }
            $path_fragment = $path_fragment->reject(function (string $item) {
                return $item === '';
            });
            $path_string = implode('/', $path_fragment->toArray());
            $url_token['path'] = Str::of($path_string)->start('/');
            $url = $this->build_url($url_token);
        }

        return $url;
    }

    /**
     * This is the missing function to reverse the `parse_url` function.
     *
     * @param  array  $parsed_url
     * @return string
     *
     * @see https://www.php.net/parse_url
     */
    public function build_url(array $parsed_url): string
    {
        $scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'].'://' : '';
        $host = $parsed_url['host'] ?? '';
        $port = isset($parsed_url['port']) ? ':'.$parsed_url['port'] : '';
        $user = $parsed_url['user'] ?? '';
        $pass = isset($parsed_url['pass']) ? ':'.$parsed_url['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = $parsed_url['path'] ?? '';
        $query = isset($parsed_url['query']) ? '?'.$parsed_url['query'] : '';
        $fragment = isset($parsed_url['fragment']) ? '#'.$parsed_url['fragment'] : '';

        return $scheme.
            $user.
            $pass.
            $host.
            $port.
            $path.
            $query.
            $fragment;
    }

    /**
     * This will return the "main url part" of a url; this reflects the Second-level domain plus the top-level domain.
     *
     * @example https://something.strange.example.com/foobar will return example.com
     *
     * @param  string  $url  Your url
     * @return string The main domain part only
     */
    public function getMainDomainPart(string $url): string
    {
        if (trim($url) === '' ||
            ($url_data = parse_url($url)) === false ||
            array_key_exists('host', $url_data) === false) {
            return '';
        }
        $collect_host = collect(explode('.', $url_data['host']));
        while ($collect_host->count() > 2) {
            $collect_host->shift();
        }

        return implode('.', $collect_host->toArray());
    }

    /**
     * This will return the "subdomain" of a url.
     *
     * @example https://something.strange.example.com/foobar will return something.strange
     *
     * @param  string  $url  Your url
     * @return string The subdomain part only
     */
    public function getSubdomainPart(string $url): string
    {
        if (trim($url) === '' ||
            ($url_data = parse_url($url)) === false ||
            array_key_exists('host', $url_data) === false) {
            return '';
        }
        $exploded_host_parts = collect(explode('.', $url_data['host']));
        $subdomain_parts = collect();
        while ($exploded_host_parts->count() > 2) {
            $subdomain_parts->push($exploded_host_parts->shift());
        }

        return implode('.', $subdomain_parts->toArray());
    }

    /**
     * Checks, if this is a full URL including protocol, host and everything.
     * If it is a relative url, it will automaticly complete the url and return the result.
     *
     * @param  string  $url  Your url to fullfill
     * @param  string  $root_url  Your starting point containing the root url
     * @return string The complete Url
     */
    public function getFullEffectiveUrl(string $url, string $root_url): string
    {
        $parsed_url = collect(parse_url(url: $url));
        if ($parsed_url->has(['scheme', 'host'])) {
            return $url;
        }

        $parsed_root = collect(parse_url($root_url));
        if ($parsed_url->has('host') && ! $parsed_url->has('scheme')) {
            return $parsed_root->get('scheme').':'.$url;
        }
        if (! $parsed_url->has('host') && ! $parsed_url->has('scheme')) {
            if (Str::of($url)->startsWith('/')) {
                return $parsed_root->get('scheme').
                    '://'.
                    $parsed_root->get('host').
                    $url;
            }
            if (Str::of($url)->startsWith('#')) {
                return $root_url.$url;
            }

            $path = Str::of($parsed_root->get('path'))->beforeLast('/');

            return $parsed_root->get('scheme').
                '://'.
                $parsed_root->get('host').
                $path.
                '/'.
                $url;
        }
    }
}
