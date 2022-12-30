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

use Composer\Autoload\ClassLoader;
use Ixnode\PhpContainer\Base\BaseContainer;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Ixnode\PhpException\Function\FunctionJsonEncodeException;
use ReflectionClass;
use Stringable;

/**
 * Class File
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 */
class File extends BaseContainer implements Stringable
{
    private const FORMAT_DATE_DEFAULT = 'l, F d, Y - H:i:s';

    private ?string $directoryRoot = null;

    /**
     * File constructor.
     *
     * @param string $path
     * @param string|null $rootDir
     */
    public function __construct(protected string $path, ?string $rootDir = null)
    {
        if ($rootDir !== null) {
            $this->setPath(sprintf('%s/%s', $rootDir, $this->getPath()));
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
     * Returns the filesize in Bytes.
     *
     * @return int
     * @throws FileNotFoundException
     */
    public function getFileSize(): int
    {
        $fileSize = filesize($this->path);

        if ($fileSize === false) {
            throw new FileNotFoundException($this->getPath());
        }

        return $fileSize;
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
     * Writes content to file.
     *
     * @param string|Json|null $data
     * @return bool
     * @throws FunctionJsonEncodeException
     */
    public function write(string|Json|null $data = null): bool
    {
        match (true) {
            is_null($data) => touch($this->getPath()),
            $data instanceof Json => file_put_contents($this->getPath(), $data->getJsonStringFormatted()),
            default => file_put_contents($this->getPath(), $data),
        };

        return true;
    }

    /**
     * Writes content to file and check existing file.
     *
     * @param string|Json|null $data
     * @return bool
     * @throws FileNotFoundException
     * @throws FunctionJsonEncodeException
     */
    public function writeAndCheck(string|Json|null $data = null): bool
    {
        if (!$this->exist()) {
            throw new FileNotFoundException($this->getPath());
        }

        return $this->write($data);
    }

    /**
     * Creates a file with given content, if file does not exist.
     *
     * @param string|Json|null $data
     * @return bool
     * @throws FileNotFoundException
     * @throws FunctionJsonEncodeException
     */
    public function createIfNotExists(string|Json|null $data = null): bool
    {
        if (!$this->exist()) {
            $this->write($data);
        }

        if (!$this->exist()) {
            throw new FileNotFoundException($this->getPath());
        }

        return true;
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
     * Returns directory path of file.
     *
     * @return string
     */
    public function getDirectoryPath(): string
    {
        return dirname($this->getPath());
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
     * Returns real directory path of file.
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function getRealDirectoryPath(): string
    {
        return dirname($this->getPathReal());
    }

    /**
     * Returns the date according to given path.
     *
     * @param string $format
     * @return string
     * @throws FileNotFoundException
     */
    public function getDate(string $format = self::FORMAT_DATE_DEFAULT): string
    {
        $path = $this->getPathReal();

        $mtime = filemtime($path);

        if ($mtime === false) {
            throw new FileNotFoundException($this->getPath());
        }

        return date($format, $mtime);
    }

    /**
     * Returns the file content as text.
     *
     * @return string
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    public function getContentAsText(): string
    {
        $realPath = $this->getPathReal();

        $content = file_get_contents($realPath);

        if ($content === false) {
            throw new FileNotReadableException($this->path);
        }

        return $content;
    }
}
