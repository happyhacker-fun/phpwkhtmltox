<?php
/**
 * Created by PhpStorm.
 * User: Frost Wong <frostwong@gmail.com>
 * Date: 30/12/2017
 * Time: 00:17
 */

use SubtlePHP\WkHtmlTo\PDF\Factory;

require __DIR__ . '/../../vendor/autoload.php';

$pdf = (new Factory())->setPdfPath(__DIR__ . '/tmp/pdf')
    ->setTemporaryHtmlPath(__DIR__ . '/tmp/html')
    ->setBinary('/usr/local/bin/wkhtmltopdf');

$html = [
    '<p>kdfjsdl</p>',
    '<h1>ksdjflsadj</h1>',
];

$pdf->generateFromHtml($html, 'test', [
    'print-media-type' => '',
]);