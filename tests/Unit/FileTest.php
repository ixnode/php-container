<?php

/*
 * This file is part of the ixno/php-container project.
 *
 * (c) Björn Hempel <https://www.hempel.li/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Ixnode\PhpContainer\Tests\Unit;

use Exception;
use Ixnode\PhpContainer\Constant\Encoding;
use Ixnode\PhpContainer\Constant\MimeTypeIcons;
use Ixnode\PhpContainer\Constant\MimeTypes;
use Ixnode\PhpContainer\File;
use Ixnode\PhpException\ArrayType\ArrayCountException;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Ixnode\PhpException\Function\FunctionJsonEncodeException;
use Ixnode\PhpException\Type\TypeInvalidException;
use Ixnode\PhpNamingConventions\Exception\FunctionReplaceException;
use JsonException;
use PHPUnit\Framework\TestCase;

/**
 * Class FileTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @link File
 */
final class FileTest extends TestCase
{
    /**
     * Returns the root path of this project.
     *
     * @return string
     */
    private function getRootPath(): string
    {
        return dirname(__FILE__, 3);
    }

    /**
     * Test wrapper for File::getPathReal.
     *
     * @dataProvider dataProviderPathReal
     *
     * @test
     * @testdox $number) Test File::getRealPath
     * @param int $number
     * @param string $path
     * @param bool $valid
     * @throws Exception
     */
    public function wrapperPathReal(int $number, string $path, bool $valid): void
    {
        /* Assert */
        if (!$valid) {
            $this->expectException(Exception::class);
        }

        /* Arrange */
        $expected = sprintf('%s/%s', $this->getRootPath(), $path);

        /* Act */
        $realPath = (new File($path))->getPathReal();

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertSame($expected, $realPath);
    }

    /**
     * Data provider for File::getPathReal.
     *
     * @return array<int, array{int, string, bool}>
     */
    public function dataProviderPathReal(): array
    {
        $number = 0;

        return [
            [++$number, 'data/json/simple.json', true, ],
            [++$number, 'data/json/does-not-exist.json', false, ],
        ];
    }

    /**
     * Test wrapper for File::getFileSize.
     *
     * @dataProvider dataProviderFileSize
     *
     * @test
     * @testdox $number) Test File::getFileSize
     * @param int $number
     * @param string $path
     * @param int $sizeExpected
     * @param bool $valid
     * @throws FileNotFoundException
     */
    public function wrapperFileSize(int $number, string $path, int $sizeExpected, bool $valid): void
    {
        /* Assert */
        if (!$valid) {
            $this->expectException(Exception::class);
        }

        /* Arrange */

        /* Act */
        $fileSize = (new File($path))->getFileSize();

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertSame($sizeExpected, $fileSize);
    }

    /**
     * Data provider for File::getFileSize.
     *
     * @return array<int, array{int, string, int, bool}>
     */
    public function dataProviderFileSize(): array
    {
        $number = 0;

        return [
            [++$number, 'data/json/simple.json', 27, true, ],
        ];
    }

    /**
     * Test wrapper for File::getFileSizeHuman.
     *
     * @dataProvider dataProviderFileSizeHuman
     *
     * @test
     * @testdox $number) Test File::getFileSizeHuman
     * @param int $number
     * @param string $path
     * @param string $sizeExpected
     * @param bool $valid
     * @throws FileNotFoundException
     */
    public function wrapperFileSizeHuman(int $number, string $path, string $sizeExpected, bool $valid): void
    {
        /* Assert */
        if (!$valid) {
            $this->expectException(Exception::class);
        }

        /* Arrange */

        /* Act */
        $fileSize = (new File($path))->getFileSizeHuman();

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertSame($sizeExpected, $fileSize);
    }

    /**
     * Data provider for File::getFileSizeHuman.
     *
     * @return array<int, array{int, string, string, bool}>
     */
    public function dataProviderFileSizeHuman(): array
    {
        $number = 0;

        return [
            [++$number, 'data/json/simple.json', '27 Bytes', true, ],
        ];
    }

    /**
     * Test wrapper for File::getMimeType.
     *
     * @dataProvider dataProviderMimeType
     *
     * @test
     * @testdox $number) Test File::getMimeType
     * @param int $number
     * @param string $path
     * @param string $mimeTypeExpected
     * @param string $iconExpected
     * @param bool $valid
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    public function wrapperMimeType(int $number, string $path, string $mimeTypeExpected, string $iconExpected, bool $valid): void
    {
        /* Assert */
        if (!$valid) {
            $this->expectException(Exception::class);
        }

        /* Arrange */
        $file = new File($path);

        /* Act */
        $mimeType = $file->getMimeType();
        $icon = $file->getIcon();

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertSame($mimeTypeExpected, $mimeType);
        $this->assertSame($iconExpected, $icon);
    }

    /**
     * Data provider for File::getMimeType.
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderMimeType(): array
    {
        $number = 0;

        return [
            /* Check configuration files. */
            [++$number, 'data/json/simple.json', MimeTypes::APPLICATION_JSON_TYPE, MimeTypeIcons::CONFIGURATION_FILES, true, ],
            [++$number, 'data/csv/real.csv', MimeTypes::TEXT_CSV_TYPE, MimeTypeIcons::OTHER, true, ],
            [++$number, 'data/csv/real2.csv', MimeTypes::TEXT_CSV_TYPE, MimeTypeIcons::OTHER, true, ],

            /* Check images. */
            [++$number, 'data/image/example-basic.jpg', MimeTypes::IMAGE_JPEG_TYPE, MimeTypeIcons::IMAGES, true, ],
            [++$number, 'data/image/example-basic.png', MimeTypes::IMAGE_PNG_TYPE, MimeTypeIcons::IMAGES, true, ],

            /* Check text files. */
            [++$number, 'data/text/hello-world.txt', MimeTypes::TEXT_PLAIN_TYPE, MimeTypeIcons::TEXTS_AND_MARKDOWNS, true, ],
        ];
    }

    /**
     * Test wrapper for File::getJson.
     *
     * @dataProvider dataProviderJson
     *
     * @test
     * @testdox $number) Test File::getJson
     * @param int $number
     * @param string $path
     * @param array<string|int, mixed> $arrayExpected
     * @param bool $valid
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     */
    public function wrapperJson(int $number, string $path, array|null $arrayExpected, bool $valid): void
    {
        /* Assert */
        if (!$valid) {
            $this->expectException(Exception::class);
        }

        /* Arrange */
        $file = new File($path);

        /* Act */
        $array = $file->getJson()?->getArray();

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertSame($arrayExpected, $array);
    }

    /**
     * Data provider for File::getJson.
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderJson(): array
    {
        $number = 0;

        return [
            /* Check configuration files. */
            [++$number, 'data/json/simple.json', [
                'data' => 'Testdata.'
            ], true, ],
            [++$number, 'data/csv/real.csv', null, true, ],
            [++$number, 'data/csv/real2.csv', null, true, ],

            /* Check images. */
            [++$number, 'data/image/example-basic.jpg', null, true, ],
            [++$number, 'data/image/example-basic.png', null, true, ],

            /* Check text files. */
            [++$number, 'data/text/hello-world.txt', null, true, ],
        ];
    }

    /**
     * Test wrapper for File::getCsv.
     *
     * @dataProvider dataProviderCsv
     *
     * @test
     * @testdox $number) Test File::getCsv
     * @param int $number
     * @param string $path
     * @param array<string|int, mixed> $arrayExpected
     * @param bool $valid
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws ArrayCountException
     */
    public function wrapperCsv(int $number, string $path, array|null $arrayExpected, bool $valid): void
    {
        /* Assert */
        if (!$valid) {
            $this->expectException(Exception::class);
        }

        /* Arrange */
        $file = new File($path);

        /* Act */
        $array = $file->getCsv()?->getArray();

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertSame($arrayExpected, $array);
    }

    /**
     * Data provider for File::getCsv.
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderCsv(): array
    {
        $number = 0;

        return [
            /* Check configuration files. */
            [++$number, 'data/json/simple.json', null, true, ],
            [++$number, 'data/csv/real.csv', [
                [
                    'State' => 'BW',
                    'Name' => 'Neujahrstag',
                    'Date' => '1970-01-01',
                ],
                [
                    'State' => 'BW',
                    'Name' => 'Heilige Drei Könige',
                    'Date' => '1970-01-06',
                ]
            ], true, ],
            [++$number, 'data/csv/real2.csv', [
                [
                    'State' => 'BW',
                    'Name' => 'Neujahrstag',
                    'Date' => '1970-01-01',
                ],
                [
                    'State' => 'BW',
                    'Name' => 'Heilige Drei Könige',
                    'Date' => '1970-01-06',
                ]
            ], true, ],
            [++$number, 'data/csv/real3.csv', [
                [
                    'State' => 'BW',
                    'Name' => 'Neujahrstag',
                    'Date' => '1970-01-01',
                ],
                [
                    'State' => 'BW',
                    'Name' => 'Heilige Drei Könige',
                    'Date' => '1970-01-06',
                ]
            ], true, ],

            /* Check images. */
            [++$number, 'data/image/example-basic.jpg', null, true, ],
            [++$number, 'data/image/example-basic.png', null, true, ],

            /* Check text files. */
            [++$number, 'data/text/hello-world.txt', null, true, ],
        ];
    }

    /**
     * Test wrapper for File::getEncoding.
     *
     * @dataProvider dataProviderEncoding
     *
     * @test
     * @testdox $number) Test File::getEncoding
     * @param int $number
     * @param string $path
     * @param string|false $encodingExpected
     * @param bool $valid
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    public function wrapperEncoding(int $number, string $path, string|false $encodingExpected, bool $valid): void
    {
        /* Assert */
        if (!$valid) {
            $this->expectException(Exception::class);
        }

        /* Arrange */
        $file = new File($path);

        /* Act */
        $encoding = $file->getEncoding();

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertSame($encodingExpected, $encoding);
    }

    /**
     * Data provider for File::getEncoding.
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderEncoding(): array
    {
        $number = 0;

        return [
            /* Check configuration files. */
            [++$number, 'data/json/simple.json', Encoding::ASCII, true, ],
            [++$number, 'data/csv/real.csv', Encoding::UTF_8, true, ],
            [++$number, 'data/csv/real2.csv', Encoding::UTF_8, true, ],
            [++$number, 'data/csv/real3.csv', Encoding::UTF_8, true, ],

            /* Check images. */
            [++$number, 'data/image/example-basic.jpg', false, true, ],
            [++$number, 'data/image/example-basic.png', false, true, ],

            /* Check text files. */
            [++$number, 'data/text/hello-world.txt', Encoding::ASCII, true, ],
        ];
    }
}
