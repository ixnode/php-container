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
use Ixnode\PhpContainer\Json;
use Ixnode\PhpException\ArrayType\ArrayKeyNotFoundException;
use Ixnode\PhpException\Case\CaseInvalidException;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Ixnode\PhpException\Function\FunctionJsonEncodeException;
use Ixnode\PhpException\Type\TypeInvalidException;
use Ixnode\PhpNamingConventions\Exception\FunctionReplaceException;
use JsonException;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
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
            /* Valid values (json data) */
            [++$number, '[]', [], ],
            [++$number, '[1, 2, 3]', [1, 2, 3, ], ],
            [++$number, '{}', [], ],
            [++$number, '{"1": 1, "2": 2}', ["1" => 1, "2" => 2, ], ],
            [++$number, [], [], ],
            [++$number, [1, 2, 3, ], [1, 2, 3, ], ],
            [++$number, ["1" => 1, "2" => 2, ], ["1" => 1, "2" => 2, ], ],

            /* Valid values (object data) */
            [++$number, (object)[], [], ],
            [++$number, (object)[1, 2, 3, ], [1, 2, 3, ], ],
            [++$number, (object)["1" => 1, "2" => 2, ], ["1" => 1, "2" => 2, ], ],

            /* Valid values (Json object) */
            [++$number, new Json('[]'), [], ],
            [++$number, new Json('[1, 2, 3]'), [1, 2, 3, ], ],
            [++$number, new Json('{}'), [], ],
            [++$number, new Json('{"1": 1, "2": 2}'), ["1" => 1, "2" => 2, ], ],

            /* Valid values (File object) */
            [++$number, new File('data/json/simple.json'), ["data" => "Testdata."], ],

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
     * Test wrapper (Json::addJson).
     *
     * @dataProvider dataProviderDeleteKey
     *
     * @test
     * @testdox $number) Test Json::addJson
     * @param int $number
     * @param string|object|array<int|string, mixed> $data
     * @param string|array<int, string>|int $path
     * @param class-string<TypeInvalidException>|array<int|string, mixed> $expected
     * @throws Exception
     */
    public function wrapperDeleteKey(int $number, string|object|array $data, string|array|int $path, array|string $expected): void
    {
        /* Arrange */
        if (is_string($expected)) {
            $this->expectException($expected);
        }

        /* Act */
        $json = new Json($data);
        $json->deleteKey($path);

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertEquals($expected, $json->getArray());
    }

    /**
     * Data provider (Json::addJson).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderDeleteKey(): array
    {
        $number = 0;

        return [
            [++$number, '[]', [], [], ],
            [++$number, '[1, 2, 3]', [], [1, 2, 3], ],
            [++$number, '[1, 2, 3]', [0], [2, 3], ],
            [++$number, '[1, 2, 3]', [4], ArrayKeyNotFoundException::class],

            [++$number, '{"version": "1.0.0", "data": []}', [], ["version" => "1.0.0", "data" => [], ], ],
            [++$number, '{"version": "1.0.0", "data": []}', ['version'], ["data" => [], ], ],

            [++$number, '{"version": "1.0.0", "data": [1, 2, 3]}', [], ["version" => "1.0.0", "data" => [1, 2, 3], ], ],
            [++$number, '{"version": "1.0.0", "data": {"test-1": 1, "test-2": 2}}', [], ["version" => "1.0.0", "data" => ["test-1" => 1, "test-2" => 2], ], ],

            [++$number, '{"version": "1.0.0", "data": [1, 2, 3]}', ["data"], ["version" => "1.0.0", ], ],
            [++$number, '{"version": "1.0.0", "data": [1, 2, 3]}', ["data", 0], ["version" => "1.0.0", "data" => [2, 3], ], ],
            [++$number, '{"version": "1.0.0", "data": {"test-1": 1, "test-2": 2}}', ["data"], ["version" => "1.0.0", ], ],
            [++$number, '{"version": "1.0.0", "data": {"test-1": 1, "test-2": 2}}', ["data", "test-1"], ["version" => "1.0.0", "data" => ["test-2" => 2], ], ],
        ];
    }



    /**
     * Test wrapper (Json::hasKey).
     *
     * @dataProvider dataProviderHasKey
     *
     * @test
     * @testdox $number) Test Json::hasKey
     * @param int $number
     * @param string|object|array<int|string, mixed> $data
     * @param string|array<int, string|array<int, string>> $path
     * @param bool $expected
     * @param class-string<TypeInvalidException>|null $exception
     * @throws Exception
     */
    public function wrapperHasKey(int $number, string|object|array $data, string|array $path, bool $expected, ?string $exception = null): void
    {
        /* Arrange */
        if (is_string($exception)) {
            $this->expectException($exception);
        }

        /* Act */
        $json = new Json($data);

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertEquals($expected, $json->hasKey($path));
    }

    /**
     * Data provider (Json::hasKey).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderHasKey(): array
    {
        $number = 0;

        return [
            /* Available keys. */
            [++$number, '{"test": "123"}', 'test', true, ],
            [++$number, '{"test": "123"}', ['test'], true, ],
            [++$number, '{"foo": {"test": "123"}}', ['foo'], true, ],
            [++$number, '{"foo": {"test": "123"}}', ['foo', 'test'], true, ],

            /* Missing keys. */
            [++$number, '{"test2": "123"}', 'test', false, ],
            [++$number, '{"test2": "123"}', ['test'], false, ],
            [++$number, '{"foo": {"test2": "123"}}', ['foo', 'test'], false, ],

            /* Available keys with array syntax. */
            [++$number, '[]', [], true, ],
            [++$number, '[{"test": "123"}]', [], true, ],
            [++$number, '[{"test": "123"}]', [[]], true, ],
            [++$number, '[{"test": "123"}]', [['test']], true, ],
            [++$number, '[{"test": "123"}, {"test": "123"}]', [['test']], true, ],
            /* At least one exists. */
            [++$number, '[{"test": "123"}, {"test2": "123"}]', [['test']], true, ],
            [++$number, '[{"test2": "123"}, {"test": "123"}]', [['test']], true, ],
            /* Multiple */
            [++$number, '{"foo": [{"test": {"deeper": 123}}, {"test2": "123"}]}', ['foo', ['test', 'deeper']], true, ],

            /* Missing keys with array syntax. */
            [++$number, '[{"test2": "123"}]', [['test']], false, ],
            [++$number, '[{"test2": "123"}, {"test2": "123"}]', [['test']], false, ],
            [++$number, '{"foo": [{"test": {"deeper2": 123}}, {"test2": "123"}]}', ['foo', ['test', 'deeper']], false, ],
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
            [
                ++$number,
                '{"foo": [{"test": {"deeper": "1"}},{"test": {"deeper": "2"}}]}',
                ['foo', ['test']],
                [['deeper' => 1], ['deeper' => 2]],
            ],
            [
                ++$number,
                '{"foo": [{"test": {"deeper": "1"}},{"test": {"deeper": "2"}}]}',
                ['foo', ['test', 'deeper']],
                [1, 2],
            ],
            [
                ++$number,
                '{"foo": [{"test": {"deeper": {"bla": 4}}},{"test": {"deeper": {"bla": 5}}}]}',
                ['foo', ['test', 'deeper']],
                [['bla' => 4], ['bla' => 5]],
            ],
            [
                ++$number,
                '{"foo": [{"test": {"deeper": {"bla": 4}}},{"test": {"deeper": {"bla": 5}}}]}',
                ['foo', ['test', 'deeper', 'bla']],
                [4, 5],
            ],
            /* With id values. */
            [
                ++$number,
                '{"foo": [{"id": "89", "value": "value-89", "test": {"deeper": {"bla": 4}}},{"id": "90", "value": "value-90", "test": {"deeper": {"bla": 5}}}]}',
                ['foo', ['test', 'deeper', 'bla']],
                [4, 5],
            ],
            [
                ++$number,
                '{"foo": [{"id": "89", "value": "value-89", "test": {"deeper": {"bla": 4}}},{"id": "90", "value": "value-90", "test": {"deeper": {"bla": 5}}}]}',
                ['foo', ['key=id', 'test', 'deeper', 'bla']],
                ['89' => 4, '90' => 5],
            ],
            [
                ++$number,
                '{"foo": [{"id": "89", "value": "value-89", "test": {"deeper": {"bla": 4}}},{"id": "90", "value": "value-90", "test": {"deeper": {"bla": 5}}}]}',
                ['foo', ['key=value', 'test', 'deeper', 'bla']],
                ['value-89' => 4, 'value-90' => 5],
            ],

            /* Missing keys. */
            [++$number, '{"foo": [{"test": "123"},{"test2": "456"}]}', ['foo', ['test']], ['123'], ],
            [
                ++$number,
                '{"foo": [{"test": {"deeper": "1"}},{"test2": {"deeper": "2"}}]}',
                ['foo', ['test']],
                [['deeper' => 1]],
            ],
            [
                ++$number,
                '{"foo": [{"test": {"deeper": "1"}},{"test": {"deeper2": "2"}}]}',
                ['foo', ['test', 'deeper']],
                [1],
            ],
            [
                ++$number,
                '{"foo": [{"test": {"deeper2": "1"}},{"test": {"deeper": "2"}}]}',
                ['foo', ['test', 'deeper']],
                [2],
            ],
            [
                ++$number,
                '{"foo": [{"test": {"deeper": {"bla": 4}}},{"test": {"deeper": {"bla2": 5}}}]}',
                ['foo', ['test', 'deeper', 'bla']],
                [4],
            ],
            [
                ++$number,
                '{"foo": [{"test": {"deeper": {"bla2": 4}}},{"test": {"deeper": {"bla": 5}}}]}',
                ['foo', ['test', 'deeper', 'bla']],
                [5],
            ],
            [
                ++$number,
                '{"foo": [{"test": {"deeper": {"bla1": 4}}},{"test": {"deeper": {"bla2": 5}}}]}',
                ['foo', ['test', 'deeper', 'bla']],
                [],
            ],
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
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws FunctionReplaceException
     * @throws JsonException
     * @throws TypeInvalidException
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


    /**
     * Test wrapper for key modes.
     *
     * @dataProvider dataProviderKeyModes
     *
     * @test
     * @testdox $number) Test Json::setKeyMode, Json::hasKey, Json::getKey
     * @param int $number
     * @param int $keyMode
     * @param string|object|array<int|string, mixed> $data
     * @param int|string|array<int, mixed> $keys
     * @param bool $hasExpected
     * @param mixed $dataExpected
     * @param class-string<TypeInvalidException>|null $exception
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     */
    public function wrapperKeyModes(
        int $number,
        int $keyMode,
        string|object|array $data,
        int|string|array $keys,
        bool $hasExpected,
        mixed $dataExpected,
        ?string $exception = null
    ): void
    {
        /* Arrange */
        if (is_string($exception)) {
            $this->expectException($exception);
        }

        /* Act */
        $json = (new Json($data))->setKeyMode($keyMode);

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertSame($hasExpected, $json->hasKey($keys));

        /* Assert */
        if ($json->hasKey($keys)) {
            $this->assertSame($dataExpected, $json->getKey($keys));
        }
    }

    /**
     * Data provider for key modes.
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderKeyModes(): array
    {
        $number = 0;

        return [
            /* direct mode */
            [
                ++$number,
                Json::KEY_MODE_DIRECT,
                '{"key-one": 111, "key-two": "222"}',
                'key-one',
                true,
                111
            ],
            [
                ++$number,
                Json::KEY_MODE_DIRECT,
                '{"key-one": {"foo-xyz": "bar-1"}, "key-two": {"foo-abc": "bar-2"}}',
                'key-one',
                true,
                ["foo-xyz" => "bar-1"]
            ],
            [
                ++$number,
                Json::KEY_MODE_DIRECT,
                '{"key-one": 111, "key-two": "222"}',
                'key-three',
                false,
                null
            ],

            /* underline mode */
            [
                ++$number,
                Json::KEY_MODE_UNDERLINE,
                '{"key-one": 111, "key-two": "222"}',
                'key_one',
                true,
                111
            ],
            [
                ++$number,
                Json::KEY_MODE_UNDERLINE,
                '{"key-one": {"foo": "bar1"}, "key-two": {"foo": "bar2"}}',
                'key_one',
                true,
                ["foo" => "bar1"]
            ],
            [
                ++$number,
                Json::KEY_MODE_UNDERLINE,
                '{"key-one": {"foo-xyz": "bar-1"}, "key-two": {"foo-abc": "bar-2"}}',
                'key_one',
                true,
                ["foo_xyz" => "bar-1"]
            ],

            /* configurable key mode */
            [
                ++$number,
                Json::KEY_MODE_CONFIGURABLE,
                '{"data": [{"key-one": 111, "key-two": "222"}, {"key-one": 111, "key-two": "222"}]}',
                ['data', ['key-one']],
                true,
                [111, 111]
            ],

            /* mixed key mode */
            [
                ++$number,
                Json::KEY_MODE_CONFIGURABLE + Json::KEY_MODE_UNDERLINE,
                '{"data-abc": [{"key-one": 111, "key-two": "222"}, {"key-one": 111, "key-two": "222"}]}',
                ['data_abc', ['key_one']],
                true,
                [111, 111]
            ],
            [
                ++$number,
                Json::KEY_MODE_CONFIGURABLE + Json::KEY_MODE_UNDERLINE,
                '{"data-abc": [{"key-one": {"foo-xyz": "bar-1"}, "key-two": "222"}, {"key-one": {"foo-abc": "bar-1"}, "key-two": "222"}]}',
                ['data_abc', ['key_one']],
                true,
                [['foo_xyz' => 'bar-1'], ['foo_abc' => 'bar-1']]
            ],
        ];
    }
}
