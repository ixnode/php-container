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

use Composer\Autoload\ClassLoader;
use Ixnode\PhpContainer\Constant\MimeTypeIcons;
use Ixnode\PhpContainer\Constant\MimeTypes;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use LogicException;
use ReflectionClass;
use Stringable;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Abstract class BaseFile (for File, Directory and Symlink)
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2024-12-17)
 * @since 0.1.0 (2024-12-17) First version.
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
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

    public const FILE_ATIME = 'atime';

    public const FILE_CTIME = 'ctime';

    public const FILE_MTIME = 'mtime';

    private const FORMAT_DATE_DEFAULT = 'l, F d, Y - H:i:s';

    private ?string $directoryRoot = null;

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
     * Returns the path of this container.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->path;
    }

    /**
     * Returns the path of this container.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Sets the path of this container.
     *
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
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
     * Returns the type name of this file.
     *
     * @return string
     */
    public function getTypeName(): string
    {
        $type = $this->getType();

        return match ($type) {
            BaseFile::TYPE_FILE => 'FILE',
            BaseFile::TYPE_DIRECTORY => 'DIR',
            BaseFile::TYPE_SYMLINK => 'LINK',
            BaseFile::TYPE_UNKNOWN => 'UNKNOWN',
            default => throw new LogicException(sprintf('Unknown file type: %s', $type)),
        };
    }

    /**
     * Returns the mtime time according to given path (modification time).
     *
     * @param string $format
     * @param 'atime'|'ctime'|'mtime' $type
     * @return string
     * @throws FileNotFoundException
     */
    public function getDate(string $format = self::FORMAT_DATE_DEFAULT, string $type = self::FILE_MTIME): string
    {
        $path = $this->getPathReal();

        $time = match ($type) {
            self::FILE_ATIME => fileatime($path),
            self::FILE_CTIME => filectime($path),
            self::FILE_MTIME => filemtime($path),
        };

        if ($time === false) {
            throw new FileNotFoundException($this->getPath());
        }

        return date($format, $time);
    }

    /**
     * Return the permissions of the path.
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function getPermission(): string
    {
        $path = $this->getPathReal();

        $filePermissions = fileperms($path);

        if ($filePermissions === false) {
            throw new FileNotFoundException($this->getPath());
        }

        return decoct($filePermissions & 0777);
    }

    /**
     * Returns the owner of the path.
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function getOwner(): string
    {
        $path = $this->getPathReal();

        $ownerId = fileowner($path);

        if ($ownerId === false) {
            throw new FileNotFoundException($this->getPath());
        }

        $ownerInfo = posix_getpwuid($ownerId);

        if ($ownerInfo === false) {
            throw new FileNotFoundException($this->getPath());
        }

        return $ownerInfo['name'];
    }

    /**
     * Returns the group of the path.
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function getGroup(): string
    {
        $path = $this->getPathReal();

        $groupId = filegroup($path);

        if ($groupId === false) {
            throw new FileNotFoundException($this->getPath());
        }

        $groupInfo = posix_getgrgid($groupId);

        if ($groupInfo === false) {
            throw new FileNotFoundException($this->getPath());
        }

        return $groupInfo['name'];
    }

    /**
     * Returns the owner and group of the path.
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function getOwnerGroup(): string
    {
        return sprintf('%s:%s', $this->getOwner(), $this->getGroup());
    }

    /**
     * Returns the real path of this container.
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function getPathReal(): string
    {
        $realPath = realpath($this->getPath());

        if ($realPath !== false) {
            return $realPath;
        }

        $realPath = realpath(sprintf('%s/%s', $this->getDirectoryRoot(), $this->getPath()));

        if ($realPath !== false) {
            return $realPath;
        }

        throw new FileNotFoundException($this->getPath());
    }

    /**
     * Returns the root directory.
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function getDirectoryRoot(): string
    {
        if (!is_null($this->directoryRoot)) {
            return $this->directoryRoot;
        }

        $reflection = new ReflectionClass(ClassLoader::class);

        $fileName = $reflection->getFileName();

        if ($fileName === false) {
            throw new FileNotFoundException('Composer ClassLoader');
        }

        return dirname($fileName, 3);
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
    abstract public function getIcon(): string;

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
