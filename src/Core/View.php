<?php

declare(strict_types=1);

namespace App\Core;

/** Rendu des templates dans le layout commun. */
final class View
{
    /** @param array<string, mixed> $data */
    public static function render(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        ob_start();
        require dirname(__DIR__, 2) . '/templates/' . $template . '.php';
        $content = ob_get_clean();
        require dirname(__DIR__, 2) . '/templates/layout.php';
    }
}
