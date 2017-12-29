<?php
/**
 * Created by PhpStorm.
 * User: Frost Wong <frostwong@gmail.com>
 * Date: 29/12/2017
 * Time: 23:22
 */

namespace SubtlePHP\WkHtmlTo\PDF;


use Psr\Log\LoggerInterface;
use RuntimeException;

class Factory
{
    /**
     * @var string
     */
    private $pdfPath = '/data/documents/pdf';

    /**
     * @var string
     */
    private $temporaryHtmlPath = '/data/documents/html';

    /**
     * @var string
     */
    private $binary = '/usr/local/bin/wkhtmltopdf';

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @return string
     */
    public function getTemporaryHtmlPath(): string
    {
        return $this->temporaryHtmlPath;
    }

    /**
     * @param string $temporaryHtmlPath
     * @return Factory
     */
    public function setTemporaryHtmlPath(string $temporaryHtmlPath): Factory
    {
        $this->temporaryHtmlPath = $temporaryHtmlPath;
        return $this;
    }

    /**
     * Get contents of PDF file.
     *
     * @param mixed $html html to convert to PDF
     * @param string $output PDF basename without extension
     * @param array $options custom options for generating
     * @return bool|string
     * @throws \RuntimeException
     */
    public function getOutputFromHtml($html, $output, array $options = []): string
    {
        $this->generateFromHtml($html, $output, $options);

        $outputFile = $this->getPDFPath() . '/' . $output . '.pdf';

        return file_get_contents($outputFile);
    }

    /**
     * Generate PDF file and put it in the right place.
     *
     * @param $html
     * @param $output
     * @param array $options
     * @throws \RuntimeException
     */
    public function generateFromHtml($html, $output, array $options = []): void
    {
        $inputContent = '';

        if (\is_array($html)) {
            foreach ($html as $item) {
                $inputContent .= $item . "\n";
            }
        } else {
            $inputContent = $html;
        }

        $this->doGenerate($inputContent, $output, $options);
    }

    /**
     * @param $inputContent
     * @param $output
     * @param array $options
     * @throws RuntimeException
     */
    private function doGenerate($inputContent, $output, array $options = []): void
    {
        $inputFile = $this->getTemporaryHtmlPath() . '/' . (microtime(true) * 10000) . '.html';

        file_put_contents($inputFile, $inputContent);

        if (!is_file($inputFile) || is_dir($inputFile)) {
            throw new RuntimeException('file ' . $inputFile . ' cannot be converted to PDF file');
        }

        $configLine = new ConfigResolver($options);
        $command = $this->getBinary() . $configLine . ' ' . $inputFile . ' ' . $this->getPDFPath() .
            '/' . $output . '.pdf';

        shell_exec($command);

        if ($this->getLogger()) {
            $this->getLogger()->info($command);
        } else {
            echo $command, "\n";
        }
    }

    /**
     * Get binary file.
     *
     * @return string
     */
    public function getBinary(): string
    {
        return $this->binary;
    }

    /**
     * Set custom binary file.
     *
     * @param $binary
     * @return Factory
     */
    public function setBinary($binary): self
    {
        $this->binary = $binary;
        return $this;
    }

    /**
     * Get PDF output path.
     *
     * @return string
     */
    public function getPDFPath(): string
    {
        return $this->pdfPath;
    }

    /**
     * Set PDF output path.
     *
     * @param $path
     * @return Factory
     */
    public function setPdfPath($path): Factory
    {
        $this->pdfPath = $path;
        return $this;
    }

    /**
     * Get logger.
     *
     * @return LoggerInterface
     */
    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Set logger.
     *
     * @param LoggerInterface $logger
     * @return Factory
     */
    public function setLogger(LoggerInterface $logger): Factory
    {
        $this->logger = $logger;
        return $this;
    }
}
