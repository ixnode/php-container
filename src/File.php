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

use Exception;
use Ixnode\PhpContainer\Base\BaseFile;
use Ixnode\PhpContainer\Constant\Encoding;
use Ixnode\PhpContainer\Constant\MimeTypeIcons;
use Ixnode\PhpContainer\Constant\MimeTypes;
use Ixnode\PhpException\ArrayType\ArrayCountException;
use Ixnode\PhpException\Case\CaseUnsupportedException;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Ixnode\PhpException\Function\FunctionJsonEncodeException;
use Ixnode\PhpException\Parser\ParserException;
use Ixnode\PhpException\Type\TypeInvalidException;
use Ixnode\PhpNamingConventions\Exception\FunctionReplaceException;
use Ixnode\PhpSizeByte\SizeByte;
use JsonException;
use LogicException;

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

    private const TEMPLATE_FILE_STANDARD = '%%s %%%ss   [%%%ss]   %%%ss   // %%%ss; %%%ss; %%%ss';

    /**
     */
    public function __construct(string $path, ?string $rootDir = null)
    {
        parent::__construct($path, $rootDir);

        if (!$this->isFile()) {
            throw new LogicException('Given path is not a file.');
        }
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
    public function getMimeType(): string
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
     * @inheritdoc
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
     * Returns base information about the file.
     *
     * @return string
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    public function getFileInformation(): string
    {
        $template = '%s // %s';

        $parts = [];

        $encoding = $this->getEncoding();
        $fileSize = $this->getFileSizeHuman();
        $mimeType = $this->getMimeType();

        if ($encoding) {
            $parts[] = $encoding;
        }

        $parts[] = $fileSize;
        $parts[] = $mimeType;

        return sprintf(
            $template,
            $this->getDate('Y-m-d H:i:s'),
            implode(', ', $parts)
        );
    }

    /**
     * Returns information about this file (one-liner).
     *
     * @param (callable(File, array<string, int|null>): string)|null $callback A callback that receives the current File instance and returns a string.
     * @param array<string, int|null> $distance
     * @return string
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    public function getFileInformationOneLiner(
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
     * Returns information about this file (table output).
     *
     * @param array<string, array<int, string>> $default
     * @param array<string, string> $additional
     * @return string
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws \DateInvalidTimeZoneException
     * @throws \DateMalformedStringException
     * @throws CaseUnsupportedException
     * @throws ParserException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function getFileInformationTable(
        array $default = [
            'general' => [
                'name',
                'type',
                'size',
                'mtime',
                'ctime',
                'atime',
                'permission',
                'owner',
                'encoding'
            ],
            'image' => [
                'size',
                'coordinate',
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
            $encoding = $this->getEncoding();

            foreach ($generalConfiguration as $key) {
                if ($key === 'name') {
                    continue;
                }

                $value = match ($key) {
                    'type' => sprintf('%s (%s)', $this->getTypeName(), $this->getMimeType()),
                    'size' => $this->getFileSizeHuman(),
                    'mtime' => $this->getDate('Y-m-d H:i:s'),
                    'ctime' => $this->getDate('Y-m-d H:i:s', BaseFile::FILE_CTIME),
                    'atime' => $this->getDate('Y-m-d H:i:s', BaseFile::FILE_ATIME),
                    'permission' => $this->getPermission(),
                    'owner' => $this->getOwnerGroup(),
                    'encoding' => is_string($encoding) ? $encoding : null,
                    default => throw new LogicException('Unknown key: ' . $key),
                };

                if (is_null($value)) {
                    continue;
                }

                $name = match ($key) {
                    'type' => 'Type',
                    'size' => 'Size',
                    'mtime' => 'Date (last modification time)',
                    'ctime' => 'Date (last access time)',
                    'atime' => 'Date (last inode change time)',
                    'permission' => 'Permission',
                    'owner' => 'Owner:Group',
                    'encoding' => 'Encoding',
                    default => throw new LogicException('Unknown key: ' . $key),
                };

                $outputArrayGeneral[$name] = $value;
            }
            if (count($outputArrayGeneral) > 0) {
                $outputArray[] = $outputArrayGeneral;
            }
        }

        /* Add image values. */
        if ($this->isImage() && array_key_exists('image', $default)) {
            $imageConfiguration = $default['image'];
            $outputArrayGeneral = [];
            $image = new Image($this);

            foreach ($imageConfiguration as $key) {
                $value = match ($key) {
                    'size' => sprintf('%dx%d', $image->getWidth(), $image->getHeight()),
                    'coordinate' => $image->getCoordinate()?->getStringDMS(),
                    default => throw new LogicException('Unknown key: ' . $key),
                };

                if (is_null($value)) {
                    continue;
                }

                $name = match ($key) {
                    'size' => 'Size',
                    'coordinate' => 'Coordinate',
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

        /* Print information. */
        return $this->getFileInformationOneLiner(fn(File $file): string => $file->buildTable($nameFull, $outputArray));
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

        $encoding = $this->getEncoding();
        $mimeType = $this->getMimeType();
        $typeName = $this->getTypeName();

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
     * Returns directory path of file.
     *
     * @return string
     */
    public function getDirectoryPath(): string
    {
        return dirname($this->getPath());
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
