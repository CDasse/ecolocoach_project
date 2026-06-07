<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/scripts/main.js',
        'entrypoint' => true,
    ],
    '@axe-core/playwright' => [
        'version' => '4.11.3',
    ],
    'axe-core' => [
        'version' => '4.11.4',
    ],
    '@playwright/test' => [
        'version' => '1.60.0',
    ],
    'playwright/test' => [
        'version' => '1.60.0',
    ],
];
