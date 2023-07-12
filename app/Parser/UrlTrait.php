<?php

namespace App\Parser;

trait UrlTrait
{
    public function getFullNormalizedUrl($host, $url): array|string
    {
        $withHostUrl = $this->withHost($host, $url);
        return $this->normalizeUrl($withHostUrl);
    }

    private function normalizeUrl($url): array|string
    {
        return str_replace("//", "/", $url);
    }

    private function withHost($host, $url)
    {
        if (str_contains($url, $host)) {
            return $url;
        } else {
            return $host . $url;
        }
    }
}
