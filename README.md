# phpwkhtmltopdf

<!-- TOC -->

- [phpwkhtmltopdf](#phpwkhtmltopdf)
    - [解析数组形式的配置](#解析数组形式的配置)
    - [例子](#例子)

<!-- /TOC -->
为了用 PHP 解决 HTML 转 PDF 的麻烦, 简单的封装了一个库, 它的主要作用有两个:

1. 解析数组形式的配置
1. 调用 wkthmltopdf 二进制文件生成 PDF

## 解析数组形式的配置

更有三种形式的选项

1. 类似`--header-line`, 是单独的选项, 不带值, 在配置里面写作:

```php
[
    'header-line' => '',
]
```

2. 类似`toc`这种大类选项, 作为二级数组

```php
[
    'toc' => [
        'toc-header-text' => 'kkkk',
    ],
]
```

3. 类似`--page-size A4` 这种有选项又有值的

```php
[
    'page-size' => 'A4'
]
```

## 例子

```php
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
```
