<?php
/**
 * Created by PhpStorm.
 * User: Frost Wong <frostwong@gmail.com>
 * Date: 29/12/2017
 * Time: 16:47
 */


include __DIR__ . '/../vendor/autoload.php';

$prefix = <<< PREFIX
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <style>
thead {
    display: table-row-group;
}
</style>
    <link href="https://fe.ksyun.com/project/resource/css/markdown-theme-default.css" rel="stylesheet">
</head>
<body>
<div class="markdown-body">
PREFIX;

$suffix = <<<SUFFIX
</div>
</body>
</html>
SUFFIX;


$mdFile = __DIR__ . '/../article/' . $argv[1];


$filename = pathinfo($mdFile, PATHINFO_FILENAME);

$mdFileContent = file_get_contents($mdFile);

$parsedown = new Parsedown();

$body = $parsedown->text($mdFileContent);

$html = $prefix . $body . $suffix;

file_put_contents(__DIR__ . '/../article/' . $filename . '.html', $html);