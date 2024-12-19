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
        return MimeTypeIcons::DIRECTORY;
    }

    /**
     * Returns the files of current directory.
     *
     * @return ($asObject is true ? File[] : string[])
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getFiles(bool $asObject = false): array
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
                $files[] = $asObject ? new File($path) : basename($path);
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
     * @return ($asObject is true ? Directory[] : string[])
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getDirectories(bool $asObject = false): array
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
                $directories[] = $asObject ? new Directory($path) : basename($path);
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
     * Returns base information about the file.
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function getDirectoryInformation(): string
    {
        $template = '%s // %s';

        $parts = [];

        $parts[] = $this->getNumberOfFilesHuman();
        $parts[] = $this->getNumberOfDirectoriesHuman();

        return sprintf(
            $template,
            $this->getDate('Y-m-d H:i:s'),
            implode(', ', $parts)
        );
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
    public function getDirectoryInformationOneLiner(
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
     * @param (callable(File[]): array<string, string>)|null $callbackFiles
     * @param (callable(Directory[]): array<string, string>)|null $callbackDirectories
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
        callable $callbackFiles = null,
        callable $callbackDirectories = null,
    ): string
    {
        /* Get name of the file. */
        $nameFull = match (true) {
            array_key_exists('general', $default) && in_array('name', $default['general'], true) => sprintf('%s %s', $this->getIcon(), $this->getBaseName()),
            default => null,
        };

        /* Add files callback. */
        if (is_null($callbackFiles)) {
            $callbackFiles = function (array $files): array
            {
                $outputArrayFiles = [];
                foreach ($files as $file) {
                    $outputArrayFiles[$file->getBaseName()] = $file->getFileInformation();
                }
                return $outputArrayFiles;
            };
        }
        if (is_null($callbackDirectories)) {
            $callbackDirectories = function (array $directories): array
            {
                $outputArrayDirectories = [];
                foreach ($directories as $directory) {
                    $outputArrayDirectories[$directory->getBaseName()] = $directory->getDirectoryInformation();
                }
                return $outputArrayDirectories;
            };
        }

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



        /* Add files. */
        $files = $this->getFiles(true);
        $outputArrayFiles = [];
        if (count($files) > 0) {
            $outputArrayFiles[] = $callbackFiles($files);
        }

        /* Add directories. */
        $directories = $this->getDirectories(true);
        $outputArrayDirectories = [];
        if (count($directories) > 0) {
            $outputArrayDirectories[] = $callbackDirectories($directories);
        }

        /* Print information. */
        return $this->getDirectoryInformationOneLiner(function (Directory $directory) use (
            $nameFull,
            $outputArray,
            $outputArrayFiles,
            $outputArrayDirectories
        ): string {
            $output = $directory->buildTable($nameFull, $outputArray);
            $output .= $directory->buildTable(MimeTypeIcons::FILE.' files', $outputArrayFiles);
            $output .= $directory->buildTable(MimeTypeIcons::DIRECTORY.' folders', $outputArrayDirectories);
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
