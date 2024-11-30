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
use Ixnode\PhpContainer\File;
use Ixnode\PhpException\File\FileNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Class FileTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
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
        $this->assertEquals($expected, $realPath);
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
        $this->assertEquals($sizeExpected, $fileSize);
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
        $this->assertEquals($sizeExpected, $fileSize);
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
}
