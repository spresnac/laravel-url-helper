<?php

namespace spresnac\Helper\URL;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SitemapHelper
{
    public function process_input_from_string(string $input_string): Collection
    {
        $input_string = Str::of($input_string)->trim();
        $result = collect();
        $xml_structure = simplexml_load_string($input_string);
        foreach ($xml_structure->url as $url_entry) {
            $result->push((string)$url_entry->loc);
        }
        return $result;
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
