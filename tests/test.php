<?php
require_once __DIR__ . '/../vendor/autoload.php'; 

use PhpTextFilters\HtmlEntities;
use PhpTextFilters\PrefixPostfix;

$text = 'Umlaut Ä - Alpha α - Quote " - Pound £ - Russian Ж - Brace ( - SQuote \' - Tick `';

$fHtml = new HtmlEntities();
$fPref = new PrefixPostfix(
    [
        'prefix' => '<< ',
        'postfix' => ' >>'
    ]
);

print_r(
  [
    'html' => $fHtml->run($text),
    'prefix' => $fPref->run('hello world')
  ]
);

