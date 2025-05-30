<?php
use Illuminate\Support\Str;
if (!function_exists('highlightMatches')) {
    function highlightMatches($text, $searchTerm)
    {
        $highlighted = preg_replace("/($searchTerm)/i", '<span class="bg-yellow-200">$1</span>', $text);
        return $highlighted;
    }
}
