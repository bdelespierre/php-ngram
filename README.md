# php-ngram

[N-gram](https://en.wikipedia.org/wiki/N-gram) implementation in PHP

## Function

```PHP
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
```

## Example

```PHP
<?php

echo json_encode(ngram('Paris', 3)); // ["P","Pa","Par","ari","ris","is","s"]
```
