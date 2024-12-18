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
use Ixnode\PhpContainer\Base\BaseFile;
use Ixnode\PhpContainer\Constant\Encoding;
use Ixnode\PhpContainer\Constant\MimeTypes;
use Ixnode\PhpException\ArrayType\ArrayCountException;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Ixnode\PhpException\Function\FunctionJsonEncodeException;
use Ixnode\PhpException\Type\TypeInvalidException;
use Ixnode\PhpNamingConventions\Exception\FunctionReplaceException;
use Ixnode\PhpSizeByte\SizeByte;
use JsonException;
use LogicException;
use ReflectionClass;

/**
 * Class File
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class File extends BaseFile
{
    private const PATH_NUMBERED = '%s.%05d.%s';

    private const PATH_WITH_TEMP = '%s/%s/%s';

    public const PATH_TEMP = 'tmp';

    private const FORMAT_DATE_DEFAULT = 'l, F d, Y - H:i:s';

    private const TEMPLATE_FILE_STANDARD = '%%s %%%ss   [%%%ss]   %%%ss   // %%%ss; %%%ss; %%%ss';

    private ?string $directoryRoot = null;

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
     * Returns the mime type of the file.
     *
     * @inheritdoc
     */
    public function getMimeType(): string
    {
        return parent::getMimeType();
    }

    /**
     * Returns the icon of the file.
     *
     * @inheritdoc
     */
    public function getIcon(): string
    {
        return parent::getIcon();
    }

    /**
     * Returns information about this file.
     *
     * @param (callable(BaseFile, array<string, int|null>): string)|null $callback A callback that receives the current File instance and returns a string.
     * @param array<string, int|null> $distance
     * @return string
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    public function getInformation(
        callable $callback = null,
        array $distance = [
            'file' => null,
            'type' => null,
            'date' => null,
            'encoding' => null,
            'size' => null,
            'mime' => null,
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
            self::TEMPLATE_FILE_STANDARD,
            !empty($distance['file']) ? -$distance['file'] : '',
            !empty($distance['type']) ? -$distance['type'] : '',
            !empty($distance['date']) ? -$distance['date'] : '',
            !empty($distance['encoding']) ? -$distance['encoding'] : '',
            !empty($distance['size']) ? -$distance['size'] : '',
            !empty($distance['mime']) ? -$distance['mime'] : '',
        );

        $type = $this->getType();
        $encoding = $this->getEncoding();
        $mimeType = $this->getMimeType();

        $typeName = match ($type) {
            BaseFile::TYPE_FILE => 'FILE',
            BaseFile::TYPE_DIRECTORY => 'DIR',
            BaseFile::TYPE_SYMLINK => 'LINK',
            BaseFile::TYPE_UNKNOWN => 'UNKNOWN',
            default => throw new LogicException(sprintf('Unknown file type: %s', $type)),
        };

        return sprintf(
            $template,
            $this->getIcon(),
            $this->getBaseName(),
            $typeName,
            $this->getDate('Y-m-d H:i:s'),
            $encoding,
            $this->getFileSizeHuman(),
            $mimeType
        );
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
     * Returns the file content (json) as JSON object.
     *
     * @return Json|null
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     */
    public function getJson(): Json|null
    {
        $mimeType = $this->getMimeType();

        if ($mimeType !== MimeTypes::APPLICATION_JSON_TYPE) {
            return null;
        }

        $contentAsText = $this->getContentAsText();

        return new Json($contentAsText);
    }

    /**
     * Returns the file content (csv) as CSV object.
     *
     * @return Csv|null
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws ArrayCountException
     */
    public function getCsv(): Csv|null
    {
        $mimeType = $this->getMimeType();

        if ($mimeType !== MimeTypes::TEXT_CSV_TYPE) {
            return null;
        }

        $detectedCsvFormat = $this->detectCsvFormat();

        if (is_null($detectedCsvFormat)) {
            return null;
        }

        $separator = $detectedCsvFormat[BaseFile::KEY_SEPARATOR];
        $enclosure = $detectedCsvFormat[BaseFile::KEY_ENCLOSURE];

        $contentAsText = $this->getContentAsText();

        return new Csv(
            csv: $contentAsText,
            separator: $separator,
            enclosure: $enclosure
        );
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
        if ($this->isImage()) {
            return false;
        }

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
