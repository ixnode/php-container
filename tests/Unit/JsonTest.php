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
use Ixnode\PhpContainer\Json;
use Ixnode\PhpException\ArrayType\ArrayKeyNotFoundException;
use Ixnode\PhpException\Case\CaseInvalidException;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Ixnode\PhpException\Function\FunctionJsonEncodeException;
use Ixnode\PhpException\Type\TypeInvalidException;
use JsonException;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class JsonTest extends TestCase
{
    /**
     * Test wrapper (Json::getArray).
     *
     * @dataProvider dataProviderGetArray
     *
     * @test
     * @testdox $number) Test Json::getArray
     * @param int $number
     * @param string|object|array<int|string, mixed> $data
     * @param class-string<TypeInvalidException>|array<int|string, mixed> $expected
     * @throws Exception
     */
    public function wrapperGetArray(int $number, string|object|array $data, array|string $expected): void
    {
        /* Arrange */
        if (is_string($expected)) {
            $this->expectException($expected);
        }

        /* Act */
        $json = new Json($data);

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertEquals($expected, $json->getArray());
    }

    /**
     * Data provider (Json::getArray).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderGetArray(): array
    {
        $number = 0;

        return [
            /* Valid values */
            [++$number, '[]', [], ],
            [++$number, '[1, 2, 3]', [1, 2, 3, ], ],
            [++$number, '{}', [], ],
            [++$number, '{"1": 1, "2": 2}', ["1" => 1, "2" => 2, ], ],
            [++$number, [], [], ],
            [++$number, [1, 2, 3, ], [1, 2, 3, ], ],
            [++$number, ["1" => 1, "2" => 2, ], ["1" => 1, "2" => 2, ], ],
            [++$number, (object)[], [], ],
            [++$number, (object)[1, 2, 3, ], [1, 2, 3, ], ],
            [++$number, (object)["1" => 1, "2" => 2, ], ["1" => 1, "2" => 2, ], ],
            [++$number, new Json('[]'), [], ],
            [++$number, new Json('[1, 2, 3]'), [1, 2, 3, ], ],
            [++$number, new Json('{}'), [], ],
            [++$number, new Json('{"1": 1, "2": 2}'), ["1" => 1, "2" => 2, ], ],

            /* Invalid values */
            [++$number, '', TypeInvalidException::class, ],
            [++$number, '{', TypeInvalidException::class, ],
            [++$number, '{123:123}', TypeInvalidException::class, ],
            [++$number, '{"abc": "123"]', TypeInvalidException::class, ],
        ];
    }



    /**
     * Test wrapper (Json::addJson).
     *
     * @dataProvider dataProviderAddJson
     *
     * @test
     * @testdox $number) Test Json::addJson
     * @param int $number
     * @param string|object|array<int|string, mixed> $data
     * @param string|object|array<int|string, mixed> $dataAdd
     * @param string|array<int, string>|null $path
     * @param class-string<TypeInvalidException>|array<int|string, mixed> $expected
     * @throws Exception
     */
    public function wrapperAddJson(int $number, string|object|array $data, string|object|array $dataAdd, string|array|null $path, array|string $expected): void
    {
        /* Arrange */
        if (is_string($expected)) {
            $this->expectException($expected);
        }

        /* Act */
        $json = new Json($data);
        $json->addJson($dataAdd, $path);

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertEquals($expected, $json->getArray());
    }

    /**
     * Data provider (Json::addJson).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderAddJson(): array
    {
        $number = 0;

        return [
            [++$number, '[]', [], null, [], ],
            [++$number, '[]', (object)[], null, [], ],
            [++$number, '[]', '[]', null, [], ],
            [++$number, '[]', new Json('[]'), null, [], ],

            [++$number, '[1, 2, 3]', [], null, [1, 2, 3, ], ],
            [++$number, '[1, 2, 3]', (object)[], null, [1, 2, 3, ], ],
            [++$number, '[1, 2, 3]', '[]', null, [1, 2, 3, ], ],
            [++$number, '[1, 2, 3]', new Json('[]'), null, [1, 2, 3, ], ],

            [++$number, '[1, 2, 3]', [1, 2, 3, ], null, [1, 2, 3, 1, 2, 3, ], ],
            [++$number, '[1, 2, 3]', (object)[1, 2, 3, ], null, [1, 2, 3, 1, 2, 3, ], ],
            [++$number, '[1, 2, 3]', '[1, 2, 3]', null, [1, 2, 3, 1, 2, 3, ], ],
            [++$number, '[1, 2, 3]', new Json('[1, 2, 3]'), null, [1, 2, 3, 1, 2, 3, ], ],

            [++$number, '[1, 2, 3]', ["first" => 1, "second" => 2, "third" => 3, ], null, [1, 2, 3, "first" => 1, "second" => 2, "third" => 3, ], ],
            [++$number, '[1, 2, 3]', (object)["first" => 1, "second" => 2, "third" => 3, ], null, [1, 2, 3, "first" => 1, "second" => 2, "third" => 3, ], ],
            [++$number, '[1, 2, 3]', '{"first": 1, "second": 2, "third": 3}', null, [1, 2, 3, "first" => 1, "second" => 2, "third" => 3, ], ],
            [++$number, '[1, 2, 3]', new Json('{"first": 1, "second": 2, "third": 3}'), null, [1, 2, 3, "first" => 1, "second" => 2, "third" => 3, ], ],

            [++$number, '{"version": "1.0.0", "data": []}', ["field1" => "1", "field2" => 2, ], null, ["version" => "1.0.0", "data" => [], "field1" => "1", "field2" => 2, ], ],
            [++$number, '{"version": "1.0.0", "data": []}', ["field1" => "1", "field2" => 2, ], '', ["version" => "1.0.0", "data" => [], "field1" => "1", "field2" => 2, ], ],
            [++$number, '{"version": "1.0.0", "data": []}', ["field1" => "1", "field2" => 2, ], 'data', ["version" => "1.0.0", "data" => ["field1" => "1", "field2" => 2, ], ], ],
            [++$number, '{"version": "1.0.0", "data": []}', ["field1" => "1", "field2" => 2, ], 'data.test', ["version" => "1.0.0", "data" => ["test" => ["field1" => "1", "field2" => 2, ], ], ], ],
            [++$number, '{"version": "1.0.0", "data": []}', ["field1" => "1", "field2" => 2, ], ['data', ], ["version" => "1.0.0", "data" => ["field1" => "1", "field2" => 2, ], ], ],
            [++$number, '{"version": "1.0.0", "data": []}', ["field1" => "1", "field2" => 2, ], ['data', 'test', ], ["version" => "1.0.0", "data" => ["test" => ["field1" => "1", "field2" => 2, ], ], ], ],

            [++$number, '{"version": "1.0.0", "data": []}', '{"field1": "1", "field2": 2}', null, ["version" => "1.0.0", "data" => [], "field1" => "1", "field2" => 2, ], ],
            [++$number, '{"version": "1.0.0", "data": []}', '{"field1": "1", "field2": 2}', '', ["version" => "1.0.0", "data" => [], "field1" => "1", "field2" => 2, ], ],
            [++$number, '{"version": "1.0.0", "data": []}', '{"field1": "1", "field2": 2}', 'data', ["version" => "1.0.0", "data" => ["field1" => "1", "field2" => 2, ], ], ],
            [++$number, '{"version": "1.0.0", "data": []}', '{"field1": "1", "field2": 2}', 'data.test', ["version" => "1.0.0", "data" => ["test" => ["field1" => "1", "field2" => 2, ], ], ], ],
            [++$number, '{"version": "1.0.0", "data": []}', '{"field1": "1", "field2": 2}', ['data', ], ["version" => "1.0.0", "data" => ["field1" => "1", "field2" => 2, ], ], ],
            [++$number, '{"version": "1.0.0", "data": []}', '{"field1": "1", "field2": 2}', ['data', 'test', ], ["version" => "1.0.0", "data" => ["test" => ["field1" => "1", "field2" => 2, ], ], ], ],

            [++$number, '{"version": "1.0.0", "data": []}', ["field1" => "1", "field2" => [1, 2, [3, 4, 5, ], ] ], ['data', 'test', ], ["version" => "1.0.0", "data" => ["test" => ["field1" => "1", "field2" => [1, 2, [3, 4, 5, ], ], ], ], ], ],
            [++$number, '{"version": "1.0.0", "data": []}', '{"field1": "1", "field2": [1, 2, [3, 4, 5]]}', ['data', 'test', ], ["version" => "1.0.0", "data" => ["test" => ["field1" => "1", "field2" => [1, 2, [3, 4, 5, ], ], ], ], ], ],

            [++$number, '{"version": "1.0.0", "data": []}', '{"version": "1.0.0", "data": []}', null, ["version" => "1.0.0", "data" => [], ], ],
        ];
    }



    /**
     * Test wrapper (Json::getKey).
     *
     * @dataProvider dataProviderGetKey
     *
     * @test
     * @testdox $number) Test Json::getKey
     * @param int $number
     * @param string|object|array<int|string, mixed> $data
     * @param string|array<int, string|array<int, string>> $path
     * @param mixed $expected
     * @param class-string<TypeInvalidException>|null $exception
     * @throws Exception
     */
    public function wrapperGetKey(int $number, string|object|array $data, string|array $path, mixed $expected, ?string $exception = null): void
    {
        /* Arrange */
        if (is_string($exception)) {
            $this->expectException($exception);
        }

        /* Act */
        $json = new Json($data);

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertEquals($expected, $json->getKey($path));
    }

    /**
     * Data provider (Json::getKey).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderGetKey(): array
    {
        $number = 0;

        return [
            [++$number, '{"test": "123"}', 'test', '123', ],
            [++$number, '{"test": "123"}', ['test'], '123', ],
            [++$number, '[{"test": "123"}]', [0], ['test' => '123'], ],
            [++$number, '[{"test": "123"}]', [[]], [['test' => '123']], ],
            [++$number, '[{"test": "123"},{"test": "456"}]', [[]], [['test' => '123'], ['test' => '456']], ],
            [++$number, '[{"test": "123"},{"test": "456"}]', [['test']], ['123', '456'], ],
            [++$number, '{"foo": [{"test": "123"},{"test": "456"}]}', ['foo', ['test']], ['123', '456'], ],
        ];
    }



    /**
     * Test wrapper (Json::getKeyX).
     *
     * @dataProvider dataProviderGetKeyType
     *
     * @test
     * @testdox $number) Test Json::getKeyX
     * @param int $number
     * @param string $method
     * @param string|object|array<int|string, mixed> $data
     * @param string|array<int, string|array<int, string>> $path
     * @param mixed $expected
     * @param class-string<TypeInvalidException>|null $exception
     * @throws TypeInvalidException
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     */
    public function wrapperGetKeyType(int $number, string $method, string|object|array $data, string|array $path, mixed $expected, ?string $exception = null): void
    {
        /* Arrange */
        if (is_string($exception)) {
            $this->expectException($exception);
        }

        /* Act */
        $json = new Json($data);
        $callback = [$json, $method];

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertContains($method, get_class_methods(Json::class));
        $this->assertIsCallable($callback);
        $this->assertEquals($expected, $json->{$method}($path));
    }

    /**
     * Data provider (Json::getKeyFloat).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderGetKeyType(): array
    {
        $number = 0;

        return [
            /* @link Json::getKeyString() */
            [++$number, 'getKeyString', '{"test": "0.12"}', 'test', '0.12', ],

            /* @link Json::getKeyInteger() */
            [++$number, 'getKeyInteger', '{"test": 12}', 'test', 12, ],

            /* @link Json::getKeyFloat() */
            [++$number, 'getKeyFloat', '{"test": 0.12}', 'test', .12, ],
        ];
    }



    /**
     * Test wrapper (Json::buildArray).
     *
     * @dataProvider dataProviderBuildArray
     *
     * @test
     * @testdox $number) Test Json::buildArray
     * @param int $number
     * @param string|object|array<int|string, mixed> $data
     * @param array<string, string|array<int, string|array<int, string|array<int, mixed>>>> $configuration
     * @param array<int|string, mixed> $expected
     * @param class-string<TypeInvalidException>|null $exception
     * @throws Exception
     */
    public function wrapperBuildArray(int $number, string|object|array $data, array $configuration, array|string $expected, ?string $exception = null): void
    {
        /* Arrange */
        if (is_string($exception)) {
            $this->expectException($exception);
        }

        /* Act */
        $json = new Json($data);

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertSame($expected, $json->buildArray($configuration));
    }

    /**
     * Data provider (Json::buildArray).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderBuildArray(): array
    {
        $number = 0;

        return [
            [++$number, '{}', [], [], ],
            [++$number, '{"test": "123"}', [], [], ],
            [++$number, '{"test": "123"}', ['test' => 'test'], ['test' => '123'], ],
            [++$number, '{"test1": "123", "test2": "456"}', ['test' => 'test1'], ['test' => '123'], ],
            [++$number, '{"test1": "123", "test2": "456"}', ['testNew1' => 'test1', 'testNew2' => 'test2'], ['testNew1' => '123', 'testNew2' => '456'], ],
            [++$number, '{"test": ["123"]}', ['test' => 'test'], ['test' => ['123', ]], ],
            [++$number, '{"test": ["123"]}', ['test' => ['test']], ['test' => ['123', ]], ],
            [++$number, '[{"test": ["123"]}]', ['test' => [0]], ['test' => ['test' => ['123', ]]], ],
            [
                ++$number,
                '[{"test": ["123"]}]',
                ['area' => [0, 'test']],
                ['area' => ['123', ]],
            ],
            [
                ++$number,
                '[{"test": "123"},{"test": "456"}]',
                ['area' => [['test']]],
                ['area' => ['123', '456']],
            ],
            [
                ++$number,
                '[{"key1": "111", "key2": "222"},{"key1": "333", "key2": "444"}]',
                ['area' => [['key2']]],
                ['area' => ['222', '444']],
            ],
            [
                ++$number,
                '[{"key1": "111", "key2": "222"},{"key1": "333", "key2": "444"}]',
                [
                    /* path [0] as area */
                    'area' => 0,
                ],
                [
                    'area' => ['key1' => '111', 'key2' => '222'],
                ],
            ],
            [
                ++$number,
                '[{"key1": "111", "key2": "222"},{"key1": "333", "key2": "444"}]',
                [
                    /* path [][0] as area */
                    'area' => [[], 0],
                ],
                [
                    'area' => ['key1' => '111', 'key2' => '222'],
                ],
            ],
            [
                ++$number,
                '[{"key1": "111", "key2": "222"},{"key1": "333", "key2": "444"}]',
                [
                    /* path []['key1'] as area1 */
                    'area1' => [['key1']],
                    /* path []['key2'] as area2 */
                    'area2' => [['key2']],
                ],
                [
                    'area1' => ['111', '333'],
                    'area2' => ['222', '444'],
                ],
            ],
            [
                ++$number,
                '[{"key1": 111, "key2": "222"},{"key1": 333, "key2": "444"}]',
                [
                    /* path []['key1'] as area1 */
                    'area1' => [['key1']],
                    /* path []['key2'] as area2 */
                    'area2' => [['key2']],
                ],
                [
                    'area1' => [111, 333],
                    'area2' => ['222', '444'],
                ],
            ],
        ];
    }



    /**
     * Test wrapper (Json::buildArrayCombined).
     *
     * @dataProvider dataProviderBuildArrayCombined
     *
     * @test
     * @testdox $number) Test Json::buildArrayCombined
     * @param int $number
     * @param string|object|array<int|string, mixed> $data
     * @param array<string, string|array<int, string|array<int, string|array<int, mixed>>>> $configuration
     * @param array<int|string, mixed> $expected
     * @param class-string<TypeInvalidException>|null $exception
     * @throws Exception
     */
    public function wrapperBuildArrayCombined(int $number, string|object|array $data, array $configuration, array|string $expected, ?string $exception = null): void
    {
        /* Arrange */
        if (is_string($exception)) {
            $this->expectException($exception);
        }

        /* Act */
        $json = new Json($data);

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertSame($expected, $json->buildArrayCombined($configuration));
    }

    /**
     * Data provider (Json::buildArrayCombined).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderBuildArrayCombined(): array
    {
        $number = 0;

        return [
            [
                ++$number,
                '[{"key1": 111, "key2": "222"},{"key1": 333, "key2": "444"}]',
                [
                    /* path []['key1'] as area1 */
                    'area1' => [['key1']],
                    /* path []['key2'] as area2 */
                    'area2' => [['key2']],
                ],
                [
                    [
                        'area1' => 111,
                        'area2' => '222'
                    ],
                    [
                        'area1' => 333,
                        'area2' => '444'
                    ],
                ],
            ],
        ];
    }
}
