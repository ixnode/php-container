<?php

declare(strict_types=1);

/*
 * This file is part of the ixno/php-container project.
 *
 * (c) Björn Hempel <https://www.hempel.li/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Ixnode\PhpContainer;

use Ixnode\PhpChecker\CheckerArray;
use Ixnode\PhpException\ArrayType\ArrayCountException;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Ixnode\PhpException\Function\FunctionJsonEncodeException;
use Ixnode\PhpException\Type\TypeInvalidException;
use JsonException;
use Stringable;

/**
 * Class Csv
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2023-01-10)
 * @since 0.1.0 (2023-01-10) First version.
 */
final class Csv implements Stringable
{
    /** @var array<int, array<int|string, bool|float|int|string|null>>|null $csv */
    private ?array $csv = null;

    /** @var array<int, string>|null $header */
    private ?array $header = null;

    private string $separator = ";";

    private string $enclosure = '"';

    private string $escape  = "\\";

    /**
     * File constructor.
     *
     * @param string|object|array<int, array<string, bool|float|int|string|null>> $csv
     * @param array<int, string>|null $header
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws ArrayCountException
     */
    public function __construct(string|object|array $csv, ?array $header = null)
    {
        $this->setCsv($csv, $header);
    }

    /**
     * Returns the path of this container.
     *
     * @return string
     * @throws TypeInvalidException
     */
    public function __toString(): string
    {
        return $this->getCsv();
    }

    /**
     * Returns the csv data of this container (as formatted string).
     *
     * @return string
     * @throws TypeInvalidException
     */
    public function getCsv(): string
    {
        if (is_null($this->csv)) {
            throw new TypeInvalidException('array', 'null');
        }

        return $this->convertArrayToCsv($this->csv);
    }

    /**
     * Returns the csv data of this container (as object).
     *
     * @return object
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     */
    public function getObject(): object
    {
        if (is_null($this->csv)) {
            throw new TypeInvalidException('array', 'null');
        }

        return $this->convertArrayToObject($this->csv);
    }

    /**
     * Returns the csv data of this container (as array<int, array<string, bool|float|int|string|null>>).
     *
     * @return array<int, array<int|string, bool|float|int|string|null>>
     * @throws TypeInvalidException
     */
    public function getArray(): array
    {
        if (is_null($this->csv)) {
            throw new TypeInvalidException('array', 'null');
        }

        return $this->csv;
    }

    /**
     * Converts the given string csv into an array.
     *
     * @param string $csv
     * @return array<int, array<string, bool|float|int|string|null>>
     * @throws ArrayCountException
     * @throws TypeInvalidException
     */
    private function convertCsvToArray(string $csv): array
    {
        $lines = explode("\n", $csv);

        $csvArray = [];

        foreach ($lines as $line) {
            $array = str_getcsv($line, $this->separator, $this->enclosure, $this->escape);

            if (is_null($this->header)) {
                $this->header = array_values((new CheckerArray($array))->checkString());
                continue;
            }

            if (count($this->header) !== count($array)) {
                throw new ArrayCountException();
            }

            $csvArray[] = array_combine($this->header, $array);
        }

        return $csvArray;
    }

    /**
     * Converts a given array into an object.
     *
     * @param array<int, array<int|string, bool|float|int|string|null>> $csv
     * @return object
     * @throws TypeInvalidException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     */
    private function convertArrayToObject(array $csv): object
    {
        return (new Json($csv))->getObject();
    }

    /**
     * Converts given array to csv string.
     *
     * @param array<int, array<int|string, bool|float|int|string|null>> $csv
     * @return string
     * @throws TypeInvalidException
     */
    private function convertArrayToCsv(array $csv): string
    {
        if (is_null($this->header)) {
            throw new TypeInvalidException('array', 'null');
        }

        $csvString = $this->strPutCsv($this->header);

        foreach ($csv as $line) {
            $csvString .= PHP_EOL.$this->strPutCsv(array_values($line));
        }

        return $csvString;
    }

    /**
     * Converts a given object into an array.
     *
     * @param object $json
     * @return array<int, array<int|string, bool|float|int|string|null>>
     * @throws FunctionJsonEncodeException
     * @throws FunctionJsonEncodeException
     * @throws TypeInvalidException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     */
    private function convertObjectToArray(object $json): array
    {
        $array = [];

        foreach ((new Json($json))->getArray() as $value) {
            $array[] = (new CheckerArray($value))->checkFlat();
        }

        return $array;
    }

    /**
     * Sets the csv of this container.
     *
     * @param string|object|array<int, array<string, bool|float|int|string|null>> $csv
     * @param array<int, string>|null $header
     * @return void
     * @throws ArrayCountException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     */
    private function setCsv(string|object|array $csv, ?array $header): void
    {
        $this->header = $header;

        $this->csv = match (true) {
            $csv instanceof $this => $csv->getArray(),
            $csv instanceof File => $this->convertCsvToArray($csv->getContentAsText()),
            is_string($csv) => $this->convertCsvToArray($csv),
            is_array($csv) => $csv,
            is_object($csv) => $this->convertObjectToArray($csv),
        };
    }

    /**
     * Converts given array line to csv line.
     *
     * @param array<int, bool|float|int|string|null> $input
     * @return string
     * @throws TypeInvalidException
     */
    private function strPutCsv(array $input): string
    {
        $stream = fopen('php://temp', 'r+');

        if ($stream === false) {
            throw new TypeInvalidException('object', 'bool');
        }

        fputcsv($stream, $input, $this->separator, $this->enclosure);
        rewind($stream);

        $data = fread($stream, 1_048_576);

        if ($data === false) {
            throw new TypeInvalidException('string', 'boolean');
        }

        fclose($stream);

        return rtrim($data, "\n");
    }
}