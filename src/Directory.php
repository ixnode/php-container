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

namespace Ixnode\PhpContainer;

use Ixnode\PhpContainer\Base\BaseFile;
use Ixnode\PhpContainer\Constant\MimeTypeIcons;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use LogicException;

/**
 * Class Directory
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2024-12-18)
 * @since 0.1.0 (2024-12-18) First version.
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Directory extends BaseFile
{
    private const TEMPLATE_DIRECTORY_STANDARD = '%%s %%%ss   [%%%ss]   %%%ss   // %%%ss; %%%ss';

    /**
     */
    public function __construct(string $path, ?string $rootDir = null)
    {
        parent::__construct($path, $rootDir);

        if (!$this->isDirectory()) {
            throw new LogicException('Given path is not a directory.');
        }
    }

    /**
     * @return string
     */
    public function getContentAsText(): string
    {
        return 'Folder: '.$this->path;
    }

    /**
     * Returns the icon of the file.
     *
     * @inheritdoc
     */
    public function getIcon(): string
    {
        return MimeTypeIcons::FOLDER;
    }

    /**
     * Returns the files of current directory.
     *
     * @return string[]
     */
    public function getFiles(): array
    {
        if (!is_dir($this->path)) {
            throw new LogicException(sprintf('The provided path is not a directory: %s', $this->path));
        }

        $contents = scandir($this->path);

        if ($contents === false) {
            throw new LogicException('Unable to read directory contents.');
        }

        $files = [];
        foreach ($contents as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = sprintf('%s%s%s', $this->path, DIRECTORY_SEPARATOR, $item);

            if (is_file($path)) {
                $files[] = basename($path);
            }
        }

        return $files;
    }

    /**
     * Returns the number of files.
     *
     * @return int
     */
    public function getNumberOfFiles(): int
    {
        return count($this->getFiles());
    }

    /**
     * Returns the directories of the current directory.
     *
     * @return string[]
     */
    public function getDirectories(): array
    {
        if (!is_dir($this->path)) {
            throw new LogicException(sprintf('The provided path is not a directory: %s', $this->path));
        }

        $contents = scandir($this->path);

        if ($contents === false) {
            throw new LogicException('Unable to read directory contents.');
        }

        $directories = [];
        foreach ($contents as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = sprintf('%s%s%s', $this->path, DIRECTORY_SEPARATOR, $item);

            if (is_dir($path)) {
                $directories[] = basename($path);
            }
        }

        return $directories;
    }

    /**
     * Returns the number of directories.
     *
     * @return int
     */
    public function getNumberOfDirectories(): int
    {
        return count($this->getDirectories());
    }

    /**
     * Returns the number of files (human-readable).
     *
     * @return string
     */
    public function getNumberOfFilesHuman(): string
    {
        return sprintf('%d files', $this->getNumberOfFiles());
    }

    /**
     * Returns the number of directories (human-readable).
     *
     * @return string
     */
    public function getNumberOfDirectoriesHuman(): string
    {
        return sprintf('%d directories', $this->getNumberOfDirectories());
    }

    /**
     * Returns information about this folder (one-liner).
     *
     * @param (callable(Directory, array<string, int|null>): string)|null $callback A callback that receives the current File instance and returns a string.
     * @param array<string, int|null> $distance
     * @return string
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    public function getDirectoryInformation(
        callable $callback = null,
        array $distance = [
            'directory' => null,
            'type' => null,
            'date' => null,
            'files' => null,
            'directories' => null,
        ]
    ): string
    {
        if (!$this->exist()) {
            throw new FileNotFoundException($this->path);
        }

        /* Add default callback. */
        if ($callback === null) {
            return $this->baseGetInformation($distance);
        }

        return $callback($this, $distance);
    }

    /**
     * Returns information about this file (table output).
     *
     * @param array<string, array<int, string>> $default
     * @param array<string, string> $additional
     * @return string
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function getDirectoryInformationTable(
        array $default = [
            'general' => [
                'name',
                'type',
                'files',
                'directories',
                'permission',
                'owner',
            ]
        ],
        array $additional = null,
    ): string
    {
        /* Get name of the file. */
        $nameFull = match (true) {
            array_key_exists('general', $default) && in_array('name', $default['general'], true) => sprintf('%s %s', $this->getIcon(), $this->getBaseName()),
            default => null,
        };

        $outputArray = [];

        /* Add default values. */
        if (array_key_exists('general', $default)) {
            $generalConfiguration = $default['general'];
            $outputArrayGeneral = [];

            foreach ($generalConfiguration as $key) {
                if ($key === 'name') {
                    continue;
                }

                $value = match ($key) {
                    'type' => sprintf('%s', $this->getTypeName()),
                    'files' => $this->getNumberOfFilesHuman(),
                    'directories' => $this->getNumberOfDirectoriesHuman(),
                    'permission' => $this->getPermission(),
                    'owner' => $this->getOwnerGroup(),
                    default => throw new LogicException('Unknown key: ' . $key),
                };

                $name = match ($key) {
                    'type' => 'Type',
                    'files' => 'Number of files',
                    'directories' => 'Number of directories',
                    'permission' => 'Permission',
                    'owner' => 'Owner:Group',
                    default => throw new LogicException('Unknown key: ' . $key),
                };

                $outputArrayGeneral[$name] = $value;
            }
            if (count($outputArrayGeneral) > 0) {
                $outputArray[] = $outputArrayGeneral;
            }
        }

        /* Add files. */
        $files = $this->getFiles();
        if (count($files) > 0) {
            $outputArrayFiles = [];

            foreach ($files as $number => $file) {
                $value = $file;
                $name = sprintf('File %s', $number + 1);

                $outputArrayFiles[$name] = $value;
            }

            $outputArray[] = $outputArrayFiles;
        }

        /* Add directories. */
        $directories = $this->getDirectories();
        if (count($directories) > 0) {
            $outputArrayDirectories = [];

            foreach ($directories as $number => $directory) {
                $value = $directory;
                $name = sprintf('Directory %s', $number + 1);

                $outputArrayDirectories[$name] = $value;
            }

            $outputArray[] = $outputArrayDirectories;
        }

        /* Add custom values. */
        $outputArrayCustom = [];
        if (!is_null($additional)) {
            foreach ($additional as $name => $value) {
                $outputArrayCustom[$name] = $value;
            }
        }
        if (count($outputArrayCustom) > 0) {
            $outputArray[] = $outputArrayCustom;
        }

        /* Print information. */
        return $this->getDirectoryInformation(function () use (
            $nameFull,
            $outputArray
        ): string {
            $output = '';
            $nameFullLength = !is_null($nameFull) ? mb_strlen($nameFull) + 1 : 0;
            $widthCol1 = max(array_map('mb_strlen', array_merge(...array_map('array_keys', $outputArray))));;
            $widthCol2 = max(array_map('mb_strlen', array_merge(...array_map('array_values', $outputArray))));

            /* Build name header. */
            switch (true) {
                case !is_null($nameFull):
                    $output .= sprintf(
                            '┌─%s─┐',
                            str_repeat('─', $nameFullLength)
                        ).PHP_EOL;
                    $output .= sprintf(
                            '│ %s │',
                            $nameFull
                        ).PHP_EOL;

                    $output .= match (true) {
                        $nameFullLength === $widthCol1 => sprintf(
                                '├─%s─┼─%s─┐',
                                str_repeat('─', $widthCol1),
                                str_repeat('─', $widthCol2)
                            ).PHP_EOL,
                        $nameFullLength < $widthCol1 => sprintf(
                                '├─%s─┴%s┬─%s─┐',
                                str_repeat('─', $nameFullLength),
                                str_repeat('─', $widthCol1 - $nameFullLength - 1),
                                str_repeat('─', $widthCol2)
                            ).PHP_EOL,
                        default => sprintf(
                                '├─%s─┬%s┴─%s─┐',
                                str_repeat('─', $widthCol1),
                                str_repeat('─', $nameFullLength - $widthCol1 - 1),
                                str_repeat('─', $widthCol1 + $widthCol2 - $nameFullLength)
                            ).PHP_EOL,
                    };
                    break;

                default:
                    $output .= sprintf(
                            '┌─%s─┬─%s─┐',
                            str_repeat('─', $widthCol1),
                            str_repeat('─', $widthCol2)
                        ).PHP_EOL;
                    break;
            }

            /* No detailed information given. */
            if (count($outputArray) <= 0) {
                $output .= sprintf(
                        '└─%s─┘',
                        str_repeat('─', $nameFullLength)
                    ).PHP_EOL;
                return $output;
            }

            /* Build detailed information. */
            foreach ($outputArray as $index => $outputArraySingle) {
                foreach ($outputArraySingle as $name => $value) {
                    $nameUtf8Diff = strlen($name) - mb_strlen($name);
                    $valueUtf8Diff = strlen((string) $value) - mb_strlen((string) $value);

                    $output .= sprintf(
                            '│ %s │ %s │',
                            sprintf(sprintf('%%-%ds', $widthCol1 + $nameUtf8Diff), $name),
                            sprintf(sprintf('%%-%ds', $widthCol2 + $valueUtf8Diff), $value)
                        ).PHP_EOL;
                }

                if ($index + 1 < count($outputArray)) {
                    $output .= sprintf(
                            '├─%s─┼─%s─┤',
                            str_repeat('─', $widthCol1),
                            str_repeat('─', $widthCol2)
                        ).PHP_EOL;
                }
            }
            $output .= sprintf(
                    '└─%s─┴─%s─┘',
                    str_repeat('─', $widthCol1),
                    str_repeat('─', $widthCol2)
                ).PHP_EOL;
            return $output;
        });
    }

    /**
     * The base callback function for method getInformation.
     *
     * @param array<string, int|null> $distance
     * @return string
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    private function baseGetInformation(array $distance): string
    {
        $template = sprintf(
            self::TEMPLATE_DIRECTORY_STANDARD,
            !empty($distance['directory']) ? -$distance['directory'] : '',
            !empty($distance['type']) ? -$distance['type'] : '',
            !empty($distance['date']) ? -$distance['date'] : '',
            !empty($distance['files']) ? -$distance['files'] : '',
            !empty($distance['directories']) ? -$distance['directories'] : ''
        );

        return sprintf(
            $template,
            $this->getIcon(),
            $this->getBaseName(),
            $this->getTypeName(),
            $this->getDate('Y-m-d H:i:s'),
            $this->getNumberOfFilesHuman(),
            $this->getNumberOfDirectoriesHuman(),
        );
    }
}
