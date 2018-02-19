<?php

function ngram(string $str, int $length = 3): array
{
    if (empty($str)) {
        return [];
    }

    $ngram = [];
    $str = str_repeat(' ', $length - 1) . $str;
    for ($i = 0; $i < strlen($str); $i++) {
        $ngram[] = trim(substr($str, $i, $length));
    }

    return $ngram;
}

function ngram_similartiy(string $a, string $b, int $length = 3): float
{
    $a = preg_replace('/\s+/', '', strtolower(remove_accents($a)));
    $b = preg_replace('/\s+/', '', strtolower(remove_accents($b)));

    $ngrama = ngram($a, $length);
    $ngramb = ngram($b, $length);

    return count(array_intersect($ngrama, $ngramb)) / ((count($ngrama) + count($ngramb)) / 2);
}

function ngram_index(array $items, int $length = 3): Generator
{
    foreach ($items as $item) {
        yield (string) $item => ngram($item, $length);
    }
}

function ngram_find_closest(string $str, array $items, int $length = 3): string
{
    $ngram = ngram($str, $length);
    foreach (ngram_index($items, $length) as $item => $index) {
        $results[$item] = count(array_intersect($ngram, $index));
    }

    $keys = array_keys($results, max($results));
    return array_shift($keys);
}

function remove_accents(string $str, string $charset = 'utf-8'): string
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

    return $str;
}
