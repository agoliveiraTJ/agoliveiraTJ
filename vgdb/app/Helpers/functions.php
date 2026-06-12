<?php

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function base_url(string $path = ''): string
{
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $base = ($scriptDir === '/' || $scriptDir === '.') ? '' : $scriptDir;

    return $base . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return base_url($path);
}

function selected($value, $expected): string
{
    return (string)$value === (string)$expected ? 'selected' : '';
}

function checked_array(array $values, $expected): string
{
    return in_array((int)$expected, array_map('intval', $values), true) ? 'checked' : '';
}
