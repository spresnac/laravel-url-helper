<?php

namespace spresnac\Helper\URL;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SitemapHelper
{
    protected Collection $results;

    public function __construct()
    {
        $this->results = collect();
    }

    public function process_input_from_string(string $input_string): Collection
    {
        $input_string = Str::of($input_string)->trim();
        $xml_structure = simplexml_load_string($input_string);

        foreach ($xml_structure->sitemap as $sitemap_entry) {
            $this->results->push((string) $sitemap_entry->loc);
            $this->process_input_from_url((string) $sitemap_entry->loc);
        }

        foreach ($xml_structure->url as $url_entry) {
            $this->results->push((string) $url_entry->loc);
        }

        return $this->results;
    }

    public function process_input_from_url(string $input_url): Collection
    {
        try {
            $sitemap_string = $this->getUrlContent($input_url);
        } catch (Exception $e) {
            return collect();
        }

        if ($sitemap_string === false) {
            return collect();
        }

        return $this->process_input_from_string($sitemap_string);
    }

    protected function getUrlContent($url): string
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYSTATUS, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_DEFAULT_PROTOCOL, 'https');
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:94.0) Gecko/20100101 Firefox/94.0');
        curl_setopt($curl_handle, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, [
            'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'DNT:1',
            'Pragma:no-cache',
            'content-length:0',
        ]);
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);

        return $query;
    }
}
