<?php

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;


require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

$environment = 'dev';
$debugEnabled = true;

$kernel = new Kernel($environment, $debugEnabled);

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
