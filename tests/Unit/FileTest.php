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

namespace Ixnode\PhpContainer\Tests\Unit;

use Exception;
use Ixnode\PhpContainer\File;
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
     * Test wrapper.
     *
     * @dataProvider dataProvider
     *
     * @test
     * @testdox $number) Test File::getRealPath
     * @param int $number
     * @param string $path
     * @param bool $valid
     * @throws Exception
     */
    public function wrapper(int $number, string $path, bool $valid): void
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
     * Data provider.
     *
     * @return array<int, array{int, string, bool}>
     */
    public function dataProvider(): array
    {
        $number = 0;

        return [
            [++$number, 'data/json/simple.json', true, ],
            [++$number, 'data/json/does-not-exist.json', false, ],
        ];
    }
}
