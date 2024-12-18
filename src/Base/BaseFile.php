<?php

/*
 * This file is part of the ixnode/php-container project.
 *
 * (c) Björn Hempel <https://www.hempel.li/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Ixnode\PhpContainer\Base;

use Ixnode\PhpContainer\Constant\MimeTypeIcons;
use Ixnode\PhpContainer\Constant\MimeTypes;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Stringable;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Abstract class BaseFile
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2024-12-17)
 * @since 0.1.0 (2024-12-17) First version.
 */
abstract class BaseFile extends BaseContainer implements Stringable
{
    private const CSV_DELIMITERS = [';', ',', "\t"];

    private const CSV_ENCLOSURES = ['"', "'"];

    public const KEY_SEPARATOR = 'separator';

    public const KEY_ENCLOSURE = 'enclosure';

    public const TYPE_FILE = 'file';

    public const TYPE_DIRECTORY = 'directory';

    public const TYPE_SYMLINK = 'symlink';

    public const TYPE_UNKNOWN = 'unknown';

    /**
     * @param string $path
     * @param string|null $rootDir
     */
    public function __construct(protected string $path, ?string $rootDir = null)
    {
        if (!is_null($rootDir)) {
            $this->path = sprintf('%s/%s', $rootDir, $path);
        }
    }

    /**
     * Returns whether this file is a csv file.
     *
     * @return bool
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    public function isImage(): bool
    {
        $mimeType = $this->getMimeType();

        return str_starts_with($mimeType, 'image/');
    }

    /**
     * Returns whether this file is a csv file.
     *
     * @return bool
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    public function isCsv(): bool
    {
        $mimeType = $this->getMimeType();

        return $mimeType === MimeTypes::TEXT_CSV_TYPE;
    }

    /**
     * Returns if this file is a file.
     *
     * @return bool
     */
    public function isFile(): bool
    {
        return is_file($this->path);
    }

    /**
     * Returns if this file is a directory.
     *
     * @return bool
     */
    public function isDirectory(): bool
    {
        return is_dir($this->path);
    }

    /**
     * Returns if this file is a symlink.
     *
     * @return bool
     */
    public function isSymlink(): bool
    {
        return is_link($this->path);
    }

    /**
     * Returns the type of this file.
     *
     * @return string
     */
    public function getType(): string
    {
        return match (true) {
            $this->isFile() => self::TYPE_FILE,
            $this->isDirectory() => self::TYPE_DIRECTORY,
            $this->isSymlink() => self::TYPE_SYMLINK,
            default => self::TYPE_UNKNOWN,
        };
    }

    /**
     * Checks if file exists.
     *
     * @return bool
     */
    public function exist(): bool
    {
        if (realpath($this->path) === false) {
            return false;
        }

        return true;
    }

    /**
     * Returns the mime type of the file.
     *
     * @return string
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    protected function getMimeTypeRaw(): string
    {
        if (!file_exists($this->path)) {
            throw new FileNotFoundException($this->path);
        }

        $mimeType = mime_content_type($this->path);

        if ($mimeType === false) {
            throw new FileNotReadableException($this->path);
        }

        return $mimeType;
    }

    /**
     * Returns the mime type of the file.
     *
     * @return string
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    protected function getMimeType(): string
    {
        $mimeType = $this->getMimeTypeRaw();

        /* text/plain -> text/yml */
        if ($mimeType === MimeTypes::TEXT_PLAIN_TYPE || $mimeType === MimeTypes::TEXT_X_CPP_TYPE) {

//            $detectedYmlFormat = $this->detectYmlFormat();
//
//            if ($detectedYmlFormat) {
//                return MimeTypes::TEXT_YML_TYPE;
//            }

            $extension = $this->getExtension();

            if ($extension === 'yaml' || $extension === 'yml') {
                return MimeTypes::APPLICATION_YAML_TYPE;
            }
        }

        /* text/plain -> text/csv */
        if ($mimeType === MimeTypes::TEXT_PLAIN_TYPE) {
            $detectedCsvFormat = $this->detectCsvFormat();

            if (!is_null($detectedCsvFormat)) {
                return MimeTypes::TEXT_CSV_TYPE;
            }
        }

        return $mimeType;
    }

    /**
     * Returns the icon of the file.
     *
     * @return string
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    public function getIcon(): string
    {
        $mimeType = $this->getMimeType();

        return match (true) {

            /* Configuration and log files. */
            $mimeType === MimeTypes::APPLICATION_JSON_TYPE,
            $mimeType === MimeTypes::APPLICATION_YAML_TYPE => MimeTypeIcons::CONFIGURATION_FILES, // .yml, .yaml, .json, etc.

            /* Documents. */
            $mimeType === MimeTypes::TEXT_PLAIN_TYPE => MimeTypeIcons::TEXTS_AND_MARKDOWNS, // .txt, .md, etc.


            /* image/svg+xml */
            $mimeType === MimeTypes::IMAGE_SVG_XML_TYPE => MimeTypeIcons::VECTOR_GRAPHICS, // .svg, etc.

            /* image/ */
            str_starts_with($mimeType, MimeTypes::GROUP_IMAGE) => MimeTypeIcons::IMAGES, // .png, .jpg, .jpeg, .gif, etc.

            /* other and unknown mime types. */
            default => MimeTypeIcons::OTHER,
        };
    }

    /**
     * Returns the base name of this file.
     *
     * @return string
     */
    public function getBaseName(): string
    {
        return basename($this->path);
    }

    /**
     * Returns the base name of this file.
     *
     * @return string
     */
    public function getExtension(): string
    {
        return strtolower(pathinfo($this->path, PATHINFO_EXTENSION));
    }

    /**
     * Read lines from file.
     *
     * @param int $numberLines
     * @return string[]|null
     */
    protected function getLines(int $numberLines = 5): array|null
    {
        $lines = [];

        $handle = fopen($this->path, 'r');

        /* Unable to load file. */
        if ($handle === false) {
            return null;
        }

        /* Read lines. */
        while (($line = fgets($handle)) !== false) {

            /* Trim whitespace and line breaks. */
            $line = trim($line);

            /* Skip empty lines. */
            if ($line === '') {
                continue;
            }

            /* Add current line. */
            $lines[] = $line;

            /* Stop after $numberLines. */
            if (count($lines) >= $numberLines) {
                break;
            }
        }

        fclose($handle);

        if (count($lines) <= 0) {
            return null;
        }

        return $lines;
    }

    /**
     * Detects the yaml format.
     *
     * @return bool
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function detectYmlFormat(): bool
    {
        /* File not readable. */
        if (!is_readable($this->path)) {
            return false;
        }

        try {
            Yaml::parseFile($this->path);
            return true;
        } catch (ParseException) {
            return false;
        }
    }

    /**
     * Detects the CSV format (separator & enclosure).
     *
     * @param string[] $delimiters
     * @param string[] $enclosures
     * @return array{separator: string, enclosure: string}|null
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function detectCsvFormat(
        array $delimiters = self::CSV_DELIMITERS,
        array $enclosures = self::CSV_ENCLOSURES
    ): ?array
    {
        /* File not readable. */
        if (!is_readable($this->path)) {
            return null;
        }

        $lines = $this->getLines();

        /* No line found. */
        if (is_null($lines)) {
            return null;
        }

        $enclosureBest = null;
        $separatorBest = null;
        $fieldsNumberMax = PHP_INT_MIN;
        $enclosureNumberMax = PHP_INT_MAX;

        /* Iterate through all delimiters. */
        foreach ($delimiters as $delimiter) {

            /* Merge lines to one line with delimiter. */
            $line = implode($delimiter, $lines);

            foreach ($enclosures as $enclosure) {

                /* Parse the line. */
                $lineParsed = str_getcsv(trim($line), $delimiter, $enclosure);
                $lineMerged = implode('', $lineParsed);
                $fieldsNumber = count($lineParsed);

                /* Parsed line should have more fields than merged lines. */
                if ($fieldsNumber <= count($lines)) {
                    continue;
                }

                /* Use the one with most detected fields. */
                if ($fieldsNumber < $fieldsNumberMax) {
                    continue;
                }

                /* Delimiters without current one (without parsed enclosure). */
                $enclosuresFiltered = array_values(array_diff($enclosures, [$enclosure]));

                /* Number of detected enclosures (not parsed). */
                $enclosureNumber = $this->countEnclosures($lineMerged, $enclosuresFiltered);

                /* Use the one with the lowest detected (none-parsed) enclosures (after parsing with removed enclosures). */
                if ($enclosureNumber > $enclosureNumberMax) {
                    continue;
                }

                /* Save used version. */
                $fieldsNumberMax = $fieldsNumber;
                $enclosureNumberMax = $enclosureNumber;
                $separatorBest = $delimiter;
                $enclosureBest = $enclosure;
            }
        }

        return ($separatorBest && $enclosureBest) ? [
            self::KEY_SEPARATOR => $separatorBest,
            self::KEY_ENCLOSURE => $enclosureBest,
        ] : null;
    }

    /**
     * Counts the enclosures within given string.
     *
     * @param string $string
     * @param string[] $enclosures
     * @return int
     */
    private function countEnclosures(
        string $string,
        array $enclosures,
    ): int
    {
        $count = 0;

        foreach ($enclosures as $enclosure) {
            /* Number of detected enclosures. */
            $count += substr_count($string, $enclosure);
        }

        return $count;
    }
}
