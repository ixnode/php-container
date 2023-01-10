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
use Ixnode\PhpContainer\Csv;
use Ixnode\PhpContainer\File;
use Ixnode\PhpException\Type\TypeInvalidException;
use PHPUnit\Framework\TestCase;

/**
 * Class CsvTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2023-01-10)
 * @since 0.1.0 (2023-01-10) First version.
 */
final class CsvTest extends TestCase
{
    /**
     * Test wrapper (Csv::getArray).
     *
     * @dataProvider dataProviderGetArray
     *
     * @test
     * @testdox $number) Test Csv::getArray
     * @param int $number
     * @param string|object|array<int, array<string, bool|float|int|string|null>> $data
     * @param array<int, string>|null $header
     * @param class-string<TypeInvalidException>|array<int|string, mixed> $expected
     * @throws Exception
     */
    public function wrapperGetArray(int $number, string|object|array $data, ?array $header, array|string $expected): void
    {
        /* Arrange */
        if (is_string($expected)) {
            $this->expectException($expected);
        }

        /* Act */
        $csv = new Csv($data, $header);

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertEquals($expected, $csv->getArray());
    }

    /**
     * Data provider (Csv::getArray).
     *
     * @return array<int, mixed>
     */
    public function dataProviderGetArray(): array
    {
        $number = 0;

        return [
            /* Valid values */
            [++$number, "Test1;Test2\n1;2\n3;4", null, [['Test1' => '1', 'Test2' => '2', ], ['Test1' => '3', 'Test2' => '4', ], ], ],
            [++$number, "\"Test 1\";Test2\n1;2\n3;4", null, [['Test 1' => '1', 'Test2' => '2', ], ['Test 1' => '3', 'Test2' => '4', ], ], ],
            [++$number, "1;2\n3;4", ['Test1', 'Test2', ], [['Test1' => '1', 'Test2' => '2', ], ['Test1' => '3', 'Test2' => '4', ], ], ],
            [++$number, "1;2\n3;4", ['Test 1', 'Test 2', ], [['Test 1' => '1', 'Test 2' => '2', ], ['Test 1' => '3', 'Test 2' => '4', ], ], ],
            [++$number, new File('data/csv/simple.csv'), null, [['Test1' => '1', 'Test2' => '2', ], ['Test1' => '3', 'Test2' => '4', ], ], ],
            [++$number, new File('data/csv/simple2.csv'), null, [['Test 1' => 'Number 1', 'Test 2' => 'Number 2', ], ['Test 1' => 'Number 3', 'Test 2' => 'Number 4', ], ], ],
            [++$number, new File('data/csv/real.csv'), null, [
                ['State' => 'BW', 'Name' => 'Neujahrstag', 'Date' => '1970-01-01', ],
                ['State' => 'BW', 'Name' => 'Heilige Drei Könige', 'Date' => '1970-01-06', ],
            ], ],
        ];
    }


    /**
     * Test wrapper (Csv::getCsv).
     *
     * @dataProvider dataProviderGetCsv
     *
     * @test
     * @testdox $number) Test Csv::getArray
     * @param int $number
     * @param string|object|array<int, array<string, bool|float|int|string|null>> $data
     * @param array<int, string>|null $header
     * @param string $expected
     * @throws Exception
     */
    public function wrapperGetCsv(int $number, string|object|array $data, ?array $header, string $expected): void
    {
        /* Arrange */

        /* Act */
        $csv = new Csv($data, $header);

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertEquals($expected, $csv->getCsv());
    }

    /**
     * Data provider (Csv::getCsv).
     *
     * @return array<int, mixed>
     */
    public function dataProviderGetCsv(): array
    {
        $number = 0;

        return [
            /* Valid values */
            [++$number, "Test1;Test2\n1;2\n3;4", null, "Test1;Test2\n1;2\n3;4", ],
            [++$number, "\"Test 1\";Test2\n1;2\n3;4", null, "\"Test 1\";Test2\n1;2\n3;4", ],
            [++$number, "\"Test 1\";Test2\n\"1 1\";\"2 2\"\n3;4", null, "\"Test 1\";Test2\n\"1 1\";\"2 2\"\n3;4", ],
            [++$number, "1;2\n3;4", ['Test1', 'Test2', ], "Test1;Test2\n1;2\n3;4", ],
            [++$number, new File('data/csv/simple.csv'), null, "Test1;Test2\n1;2\n3;4", ],
            [++$number, new File('data/csv/real.csv'), null, "State;Name;Date\nBW;Neujahrstag;1970-01-01\nBW;\"Heilige Drei Könige\";1970-01-06", ],
        ];
    }
}
