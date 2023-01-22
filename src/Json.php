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

use DateTimeImmutable;
use Exception;
use Ixnode\PhpChecker\Checker;
use Ixnode\PhpChecker\CheckerClass;
use Ixnode\PhpChecker\CheckerJson;
use Ixnode\PhpException\ArrayType\ArrayKeyNotFoundException;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Ixnode\PhpException\Function\FunctionJsonEncodeException;
use Ixnode\PhpException\Type\TypeInvalidException;
use JsonException;
use Stringable;

/**
 * Class Json
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Json implements Stringable
{
    /** @var array<int|string, mixed> $json */
    protected array $json;

    /**
     * File constructor.
     *
     * @param string|object|array<int|string, mixed> $json
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     */
    public function __construct(string|object|array $json)
    {
        $this->setJson($json);
    }

    /**
     * Returns the path of this container.
     *
     * @return string
     * @throws FunctionJsonEncodeException
     */
    public function __toString(): string
    {
        return $this->getJsonStringFormatted();
    }

    /**
     * Converts a given json string into an object.
     *
     * @param string $json
     * @return object
     * @throws TypeInvalidException
     * @throws JsonException
     */
    protected function convertJsonToObject(string $json): object
    {
        $json = (new CheckerJson($json))->check();

        $jsonObject = (object) json_decode($json, null, 512, JSON_THROW_ON_ERROR);

        return (new CheckerClass($jsonObject))->checkStdClass();
    }

    /**
     * Converts a given json string into an array.
     *
     * @param string $json
     * @return array<int|string, mixed>
     * @throws TypeInvalidException
     * @throws JsonException
     */
    protected function convertJsonToArray(string $json): array
    {
        $json = (new CheckerJson($json))->check();

        $jsonObject = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        return (new Checker($jsonObject))->checkArray();
    }

    /**
     * Converts a given json string into an object.
     *
     * @param array<int|string, mixed> $json
     * @return object
     * @throws JsonException
     * @throws TypeInvalidException
     */
    protected function convertArrayToObject(array $json): object
    {
        return $this->convertJsonToObject(json_encode($json, JSON_THROW_ON_ERROR));
    }

    /**
     * Converts a given object into a json string.
     *
     * @param object $json
     * @return string
     * @throws FunctionJsonEncodeException
     */
    protected function convertObjectToJson(object $json): string
    {
        $encoded = json_encode(
            $json,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );

        if ($encoded === false) {
            throw new FunctionJsonEncodeException();
        }

        return $encoded;
    }

    /**
     * Converts a given array into a json string.
     *
     * @param array<int|string, mixed> $json
     * @return string
     * @throws FunctionJsonEncodeException
     */
    protected function convertArrayToJson(array $json): string
    {
        $encoded = json_encode(
            $json,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );

        if ($encoded === false) {
            throw new FunctionJsonEncodeException();
        }

        return $encoded;
    }

    /**
     * Converts a given object into an array.
     *
     * @param object $json
     * @return array<int|string, mixed>
     * @throws FunctionJsonEncodeException
     * @throws FunctionJsonEncodeException
     * @throws TypeInvalidException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     */
    protected function convertObjectToArray(object $json): array
    {
        return $this->convertJsonToArray($this->convertObjectToJson($json));
    }

    /**
     * Returns the json data of this container (as formatted string).
     *
     * @return string
     * @throws FunctionJsonEncodeException
     */
    public function getJsonStringFormatted(): string
    {
        $json = $this->convertArrayToJson($this->json);

        if ($json === '[]') {
            $json = '{}';
        }

        return $json;
    }

    /**
     * Returns the json data of this container (as object).
     *
     * @return object
     * @throws TypeInvalidException
     * @throws JsonException
     */
    public function getObject(): object
    {
        return $this->convertArrayToObject($this->json);
    }

    /**
     * Returns the json data of this container (as array<int|string, mixed>).
     *
     * @return array<int|string, mixed>
     */
    public function getArray(): array
    {
        return $this->json;
    }

    /**
     * Returns the json data of this container (as array<string, string>).
     *
     * @return array<string, string>
     */
    public function getArrayStringString(): array
    {
        $json = [];

        foreach ($this->json as $index => $value) {
            $json[strval($index)] = strval($value);
        }

        return $json;
    }

    /**
     * @param string|string[] $keys
     * @return bool
     */
    public function hasKey(string|array $keys): bool
    {
        if (is_string($keys)) {
            $keys = [$keys];
        }

        $data = $this->json;

        foreach ($keys as $key) {
            if (!is_array($data)) {
                return false;
            }

            if (!array_key_exists($key, $data)) {
                return false;
            }

            $data = $data[$key];
        }

        return true;
    }

    /**
     * Returns the given key as mixed representation.
     *
     * @param string|string[] $keys
     * @return mixed
     * @throws ArrayKeyNotFoundException
     * @throws TypeInvalidException
     */
    public function getKey(string|array $keys): mixed
    {
        if (is_string($keys)) {
            $keys = [$keys];
        }

        $data = $this->json;

        foreach ($keys as $key) {
            if (!is_array($data)) {
                throw new TypeInvalidException('array', gettype($data));
            }

            if (!array_key_exists($key, $data)) {
                throw new ArrayKeyNotFoundException($key);
            }

            $data = $data[$key];
        }

        return $data;
    }

    /**
     * Returns the given key as boolean representation.
     *
     * @param string|string[] $keys
     * @return bool
     * @throws ArrayKeyNotFoundException
     * @throws TypeInvalidException
     */
    public function isKey(string|array $keys): bool
    {
        $value = $this->getKey($keys);

        if (!is_bool($value)) {
            throw new TypeInvalidException('boolean', gettype($value));
        }

        return $value;
    }

    /**
     * Returns the given key as string representation.
     *
     * @param string|string[] $keys
     * @return string
     * @throws ArrayKeyNotFoundException
     * @throws TypeInvalidException
     */
    public function getKeyString(string|array $keys): string
    {
        $value = $this->getKey($keys);

        if (!is_string($value)) {
            throw new TypeInvalidException('string', gettype($value));
        }

        return $value;
    }

    /**
     * Returns the given key as lower-cased string representation.
     *
     * @param string|string[] $keys
     * @return string
     * @throws ArrayKeyNotFoundException
     * @throws TypeInvalidException
     */
    public function getKeyStringToLower(string|array $keys): string
    {
        return strtolower($this->getKeyString($keys));
    }

    /**
     * Returns the given key as capitalized string representation.
     *
     * @param string|string[] $keys
     * @return string
     * @throws ArrayKeyNotFoundException
     * @throws TypeInvalidException
     */
    public function getKeyStringUcFirst(string|array $keys): string
    {
        return ucfirst($this->getKeyStringToLower($keys));
    }

    /**
     * Returns the given key as string representation.
     *
     * @param string|string[] $keys
     * @param string $format
     * @return string
     * @throws ArrayKeyNotFoundException
     * @throws TypeInvalidException
     * @throws Exception
     */
    public function getKeyStringDateFormatted(string|array $keys, string $format = 'Y-m-d'): string
    {
        return (new DateTimeImmutable($this->getKeyString($keys)))->format($format);
    }

    /**
     * Returns the given key as integer representation.
     *
     * @param string|string[] $keys
     * @return int
     * @throws ArrayKeyNotFoundException
     * @throws TypeInvalidException
     */
    public function getKeyInteger(string|array $keys): int
    {
        $value = $this->getKey($keys);

        if (!is_int($value)) {
            throw new TypeInvalidException('string', gettype($value));
        }

        return $value;
    }

    /**
     * Returns the given key as array representation.
     *
     * @param string|string[] $keys
     * @return array<int|string, mixed>
     * @throws ArrayKeyNotFoundException
     * @throws TypeInvalidException
     */
    public function getKeyArray(string|array $keys): array
    {
        $value = $this->getKey($keys);

        if (!is_array($value)) {
            throw new TypeInvalidException('array', gettype($value));
        }

        return $value;
    }

    /**
     * Returns the given key as array<int, string> representation.
     *
     * @param string|string[] $keys
     * @return array<int, string>
     * @throws ArrayKeyNotFoundException
     * @throws TypeInvalidException
     */
    public function getKeyArrayString(string|array $keys): array
    {
        $array = [];

        foreach ($this->getKeyArray($keys) as $item) {
            $array[] = strval($item);
        }

        return $array;
    }

    /**
     * Returns the given key as json representation.
     *
     * @param string|string[] $keys
     * @return Json
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws ArrayKeyNotFoundException
     * @throws TypeInvalidException
     */
    public function getKeyJson(string|array $keys): Json
    {
        $array = $this->getKeyArray($keys);

        return new Json($array);
    }

    /**
     * Sets the path of this container.
     *
     * @param string|object|array<int|string, mixed> $json
     * @return self
     * @throws TypeInvalidException
     * @throws JsonException
     * @throws FunctionJsonEncodeException
     */
    public function setJson(string|object|array $json): self
    {
        $this->json = match (true) {
            $json instanceof $this => $json->getArray(),
            $json instanceof File => $this->convertJsonToArray($json->getContentAsText()),
            is_string($json) => $this->convertJsonToArray($json),
            is_array($json) => $json,
            is_object($json) => $this->convertObjectToArray($json),
        };

        return $this;
    }

    /**
     * Adds (merge) json to this object.
     *
     * @param string|object|array<int|string, mixed> $json
     * @param string|array<int, string>|null $path
     * @return self
     * @throws TypeInvalidException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @link JsonTest::wrapperAddJson()
     * @link JsonTest::dataProviderAddJson()
     */
    public function addJson(string|object|array $json, string|array|null $path = null): self
    {
        $addJson = $this->getArrayFromJson($json);
        $customerTypes = $this->getCustomerTypesFromPath($path);

        $jsonSource = $this->getArray();
        $jsonAnchor = &$jsonSource;

        foreach ($customerTypes as $customerType) {
            if (!is_array($jsonAnchor)) {
                throw new TypeInvalidException('array');
            }

            if (!array_key_exists($customerType, $jsonAnchor)) {
                $jsonAnchor[$customerType] = [];
            }

            $jsonAnchor = &$jsonAnchor[$customerType];
        }

        $jsonAnchor = array_merge($jsonAnchor, $addJson);

        $this->json = $jsonSource;

        return $this;
    }

    /**
     * Adds a given value to this object.
     *
     * @param string|array<int, string> $path
     * @param string|int|array<int|string, mixed>|null $value
     * @return self
     * @throws TypeInvalidException
     * @link JsonTest::wrapperAddJson()
     * @link JsonTest::dataProviderAddJson()
     */
    public function addValue(string|array|null $path, string|int|array|null $value): self
    {
        $customerTypes = $this->getCustomerTypesFromPath($path);

        $jsonSource = $this->getArray();
        $jsonAnchor = &$jsonSource;

        foreach ($customerTypes as $customerType) {
            if (!is_array($jsonAnchor)) {
                throw new TypeInvalidException('array');
            }

            if (!array_key_exists($customerType, $jsonAnchor)) {
                $jsonAnchor[$customerType] = [];
            }

            $jsonAnchor = &$jsonAnchor[$customerType];
        }

        $jsonAnchor = $value;

        $this->json = $jsonSource;

        return $this;
    }

    /**
     * @param string|array<int, string>|null $path
     * @return array<int, string>
     */
    private function getCustomerTypesFromPath(string|array|null $path): array
    {
        return match (true) {
            is_null($path), $path === '' => [],
            is_string($path) => explode('.', $path),
            is_array($path) => $path
        };
    }

    /**
     * @param string|object|array<int|string, mixed> $json
     * @return array<int|string, mixed>
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     */
    private function getArrayFromJson(string|object|array $json): array
    {
        return match (true) {
            $json instanceof $this => $json->getArray(),
            is_string($json) => $this->convertJsonToArray($json),
            is_array($json) => $json,
            is_object($json) => $this->convertObjectToArray($json),
        };
    }
}