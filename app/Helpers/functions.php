<?php

use JetBrains\PhpStorm\NoReturn;


/**
 * Dump data in a readable format.
 *
 * @param mixed $data
 * @return void
 */
function dump(...$data): void
{
    echo '<pre style="background: #f4f4f4; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">';
    foreach ($data as $item) {
        print_r($item);
    }
    echo '</pre>';
}

/**
 * Dump data and stop execution.
 *
 * @param mixed $data
 * @return void
 */
#[NoReturn] function dd(...$data): void
{
    dump(...$data);
    die();
}

