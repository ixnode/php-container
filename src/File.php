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

use Composer\Autoload\ClassLoader;
use Exception;
use Ixnode\PhpContainer\Base\BaseContainer;
use Ixnode\PhpContainer\Constant\Encoding;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Ixnode\PhpException\Function\FunctionJsonEncodeException;
use Ixnode\PhpException\Type\TypeInvalidException;
use Ixnode\PhpSizeByte\SizeByte;
use JsonException;
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
    private const PATH_NUMBERED = '%s.%05d.%s';

    private const PATH_WITH_TEMP = '%s/%s/%s';

    public const PATH_TEMP = 'tmp';

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
     * Returns the numbered path of this container. Useful if you plan to split that file.
     *
     * @param int $number
     * @return string
     * @throws TypeInvalidException
     */
    public function getPathNumbered(int $number): string
    {
        $position = strrpos($this->path, '.');

        if ($position === false) {
            throw new TypeInvalidException('int', 'bool');
        }

        $pathWithoutExtension = substr($this->path, 0, $position);

        $extension = substr($this->path, $position + 1);

        return sprintf(self::PATH_NUMBERED, $pathWithoutExtension, $number, $extension);
    }

    /**
     * Returns the numbered path of this container. Useful if you plan to split that file.
     *
     * @param int $number
     * @param string $directoryTmp
     * @return string
     * @throws TypeInvalidException
     */
    public function getPathNumberedWithTmp(int $number, string $directoryTmp = self::PATH_TEMP): string
    {
        $pathNumbered = $this->getPathNumbered($number);

        $position = strrpos($pathNumbered, '/');

        if ($position === false) {
            throw new TypeInvalidException('int', 'bool');
        }

        $pathBefore = substr($pathNumbered, 0, $position);

        $pathAfter = substr($pathNumbered, $position + 1);

        return sprintf(self::PATH_WITH_TEMP, $pathBefore, $directoryTmp, $pathAfter);
    }

    /**
     * Returns the line numbers of given file.
     *
     * @return int
     * @throws FileNotFoundException
     * @throws TypeInvalidException
     */
    public function getLineNumbers(): int
    {
        $file = file($this->getPathReal());

        if ($file === false) {
            throw new TypeInvalidException('array', 'bool');
        }

        return count($file);
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
     * Returns the filesize as human-readable string.
     *
     * @return string
     * @throws FileNotFoundException
     * @throws Exception
     */
    public function getFileSizeHuman(): string
    {
        $fileSize = $this->getFileSize();

        return (new SizeByte($fileSize))->getHumanReadable();
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
     * Creates a file with given the content, if file does not exist.
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

    /**
     * Returns the file content as JSON object.
     *
     * @return Json
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws TypeInvalidException
     * @throws JsonException
     */
    public function getJson(): Json
    {
        $contentAsText = $this->getContentAsText();

        return new Json($contentAsText);
    }

    /**
     * Returns the encoding of a file.
     *
     * @return string|false
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    public function getEncoding(): string|false
    {
        $content = $this->getContentAsText();

        $bom = substr($content, 0, 3);

        /* BOM UTF-8 encoding detected. */
        if ($bom == "\xEF\xBB\xBF") {
            return 'UTF-8';
        }

        #$encoding = mb_detect_encoding($content, [Encoding::ASCII, Encoding::UTF_8, Encoding::UTF_16_BE, Encoding::UTF_16_LE, Encoding::UTF_32_BE, Encoding::UTF_32_LE], true);
        $encoding = mb_detect_encoding($content, [Encoding::ASCII, Encoding::UTF_8, Encoding::ISO_8859_1], true);

        if (is_string($encoding) && !empty($encoding)) {
            return $encoding;
        }

        return false;
    }
}
