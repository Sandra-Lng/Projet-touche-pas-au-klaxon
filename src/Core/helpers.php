<?php

declare(strict_types=1);

if (!function_exists('e')) {
    /** Échappe une valeur pour l'affichage HTML. */
    function e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('csrf_field')) {
    /** Champ caché contenant le jeton CSRF. */
    function csrf_field(): string
    {
        return '<input type="hidden" name="csrf" value="' . e(\App\Core\Session::csrfToken()) . '">';
    }
}

if (!function_exists('format_date')) {
    /** Formate une date SQL en jj/mm/aaaa hh:mm. */
    function format_date(string $date): string
    {
        return (new DateTimeImmutable($date))->format('d/m/Y H:i');
    }
}

if (!function_exists('input_datetime')) {
    /** Convertit une date SQL au format d'un champ datetime-local. */
    function input_datetime(mixed $date): string
    {
        return $date ? str_replace(' ', 'T', substr((string) $date, 0, 16)) : '';
    }
}
