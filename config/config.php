<?php

declare(strict_types=1);

/** Configuration (surchargeable par variables d'environnement). */
return [
    'db_host' => getenv('DB_HOST') ?: 'localhost',
    'db_name' => getenv('DB_NAME') ?: 'touche_pas_au_klaxon',
    'db_user' => getenv('DB_USER') ?: 'root',
    'db_pass' => getenv('DB_PASS') !== false ? getenv('DB_PASS') : '',
];
