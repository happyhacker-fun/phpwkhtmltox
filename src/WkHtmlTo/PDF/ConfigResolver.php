<?php
/**
 * Created by PhpStorm.
 * User: Frost Wong <frostwong@gmail.com>
 * Date: 29/12/2017
 * Time: 23:31
 */

namespace SubtlePHP\WkHtmlTo\PDF;


class ConfigResolver
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private static $defaultConfig = [
        'lowquality' => '',
        'margin-left' => 10,
        'margin-top' => 15,
        'margin-right' => 10,
        'margin-bottom' => 15,

        'load-media-error-handling' => 'ignore',
        'load-error-handling' => 'ignore',

        'print-media-type' => '',
        'header-center' => '',
        'header-line' => '',
        'header-font-size' => 12,
        'header-font-name' => 'simsun',
        'header-spacing' => 5,
        'header-right' => '[isodate]',

        'encoding' => 'utf-8',
        'footer-center' => '[page]/[toPage]',
        'footer-left' => 'what ever you like',
        'footer-right' => '',
        'footer-line' => '',
        'footer-font-size' => 12,
        'footer-font-name' => 'simsun',
        'footer-spacing' => 5,

        'toc' => [
            'toc-header-text' => 'Table Of Contents',
            'header-left' => 'TableOfContents',
            'toc-level-indentation' => '2em',
            'toc-text-size-shrink' => 0.8,
        ]
    ];

    public function __construct(array $options)
    {
        $this->config = $options + static::$defaultConfig;
    }

    /**
     * @return string
     */
    public function __toString():string
    {
        return $this->doResolve($this->config);
    }

    /**
     * @param array $config
     * @return string
     */
    private function doResolve(array $config): string
    {
        $configLine = '';
        foreach ($config as $key => $item) {
            if (is_scalar($item)) {
                $configLine .= ' --' . $key . ' ' . $this->quote($item);
            } else {
                $configLine .= ' ' . $key;
                foreach ((array)$item as $k => $v) {
                    $configLine .= ' --' . $k . ' ' . $this->quote($v);
                }
            }
        }

        return $configLine;
    }

    /**
     * @param $value
     * @return string
     */
    private function quote($value): string
    {
        if (is_numeric($value) || $value === '') {
            return $value;
        }

        return '"' . $value . '"';
    }
}