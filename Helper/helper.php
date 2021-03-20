<?php

/**
 * @param string|int|array $var
 */
function dd($var): void
{
    echo '<pre>';
    var_dump($var);
    die();
}

/**
 * @param string|int|array $var
 */
function dump($var): void
{
    echo '<pre>';
    var_dump($var);
}

/**
 * Convert the string with hyphens to StudlyCaps,
 * e.g. post-authors => PostAuthors
 *
 * @param string $data
 * @return string
 */
function convertToStudlyCaps(string $data): string
{
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $data)));
}