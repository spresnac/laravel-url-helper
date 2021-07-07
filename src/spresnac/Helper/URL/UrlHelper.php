<?php

namespace spresnac\Helper\URL;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class UrlHelper
{
    /**
     * This is for building a valid URL from inputs with `..` as folder in an url.
     *
     * @param string $url
     * @param bool $lower_result
     * @return Stringable|string
     */
    public function normalize_url(string $url, bool $lower_result = true)
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
     * @param array $parsed_url
     * @return string
     */
    public function build_url(array $parsed_url)
    {
        $scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'].'://' : '';
        $host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port = isset($parsed_url['port']) ? ':'.$parsed_url['port'] : '';
        $user = isset($parsed_url['user']) ? $parsed_url['user'] : '';
        $pass = isset($parsed_url['pass']) ? ':'.$parsed_url['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
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
}
