<?php

namespace staabm\PHPStanBaselineAnalysis;

use Iterator;
use Nette\Neon\Neon;
use RuntimeException;

final class Baseline {
    /**
     * @var array
     */
    private $content;

    /**
     * @var string
     */
    private $filePath;

    static public function forFile(string $filePath):self {

        $content = file_get_contents($filePath);
        $decoded = Neon::decode($content);

        if (!is_array($decoded)) {
            throw new RuntimeException(sprintf('expecting baseline %s to be non-empty', $filePath));
        }

        $baseline = new self();
        $baseline->content = $decoded;
        $baseline->filePath = $filePath;
        return $baseline;
    }

    /**
     * @return Iterator<string>
     */
    public function getIgnoreErrors(): Iterator {
        if (!array_key_exists('parameters', $this->content) || !is_array($this->content['parameters'])) {
            throw new RuntimeException(sprintf('missing paramters from baseline %s', $this->filePath));
        }
        $parameters = $this->content['parameters'];

        if (!array_key_exists('ignoreErrors', $parameters) || !is_array($parameters['ignoreErrors'])) {
            throw new RuntimeException(sprintf('missing ignoreErrors from baseline %s', $this->filePath));
        }
        $ignoreErrors = $parameters['ignoreErrors'];

        /**
         * @var array{message: string, count: int, path: string} $error
         */
        foreach($ignoreErrors as $error) {
            yield $error['message'];
        }
    }

    public function getFilePath():string {
        return $this->filePath;
    }
}