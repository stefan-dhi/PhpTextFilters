<?php
require_once __DIR__ . '/../vendor/autoload.php'; 

use PhpTextFilters\HtmlEntities;
use PhpTextFilters\PrefixPostfix;
use PhpTextFilters\Length;
use PhpTextFilters\RegexReplace;
use PhpTextFilters\TitleCaseShort;

$text = 'Umlaut Ä - Alpha α - Quote " - Pound £ - Russian Ж - Brace ( - SQuote \' - Tick `';

$fHtml = new HtmlEntities();
$fPref = new PrefixPostfix(
    [
        'prefix' => '<< ',
        'postfix' => ' >>'
    ]
);
$fTitle = new TitleCaseShort([
    'maxWords' => 4
]);
$fRegex = new RegexReplace();
$fLength = new Length(['max' => 25]);

print_r(
  [
    // should encode various special characters as HTML entities
    'html' => $fHtml->run($text),
    // should wrap into pairs of pointy brackets
    'prefix' => $fPref->run('hello world'),
    // should replace all characters except letter & numbers
    'regex' => $fRegex->run('Hi! This will be $300.'),
    // should titlecase all words except USA
    'title1' => $fTitle->run('hello from the USA'),
    // should uppercase the first letter
    'title2' => $fTitle->run('łorem ipsum dolor amet unicum est.'),
    // should cut on word boundary below 25 char
    'length1' => $fLength->run('łorem ipsum dolor amet unicum est.'),
    // should cut after 'y'
    'length2' => $fLength->run('abcdefghijklmnopqrstuvwxyz'),
  ]
);


