<?php
/**
 * Copyright (c) Ivan Klimchuk - All Rights Reserved
 * Unauthorized copying, changing, distributing this file, via any medium, is strictly prohibited.
 * Written by Ivan Klimchuk <ivan@klimchuk.com>, 2019
 */

declare(strict_types = 1);

/** @var xPDOTransport $transport */
/** @var array $options */

if (!$transport->xpdo) {
    return false;
}

$extensions = [
    'pdo' => 'PHP Data Objects',
    'curl' => 'Client URL Library',
    'simplexml' => 'SimpleXML',
    'json' => 'JavaScript Object Notation',
    'xmlwriter' => 'XMLWriter',
    'bcmath' => 'BCMath Arbitrary Precision Mathematics', // or gmp?
    'openssl' => 'OpenSSL'
];

foreach ($extensions as $ext => $title) {
    if (!extension_loaded($ext)) {
        $message = sprintf('
            PHP extension `%s` (https://php.net/manual/en/book.%s.php) does not loaded. 
            This PHP extension is required for a proper work of this package.
            Please, ask your sysadmin or hosting company to install and configure it before continue.',
                       $title, $ext === 'bcmath' ? 'bc' : $ext
        );

        $transport->xpdo->log(xPDO::LOG_LEVEL_ERROR, $message);

        return false;
    }
}

return true;
