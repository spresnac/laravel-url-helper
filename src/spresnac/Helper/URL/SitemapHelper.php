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
            $sitemap_string = file_get_contents($input_url);
        } catch (Exception $e) {
            return collect();
        }

        if ($sitemap_string === false) {
            return collect();
        }

        return $this->process_input_from_string($sitemap_string);
    }
}
