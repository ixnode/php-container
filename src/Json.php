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

namespace Ixnode\PhpContainer;

use DateTimeImmutable;
use Exception;
use Ixnode\PhpChecker\Checker;
use Ixnode\PhpChecker\CheckerClass;
use Ixnode\PhpChecker\CheckerJson;
use Ixnode\PhpException\ArrayType\ArrayKeyNotFoundException;
use Ixnode\PhpException\Case\CaseInvalidException;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Ixnode\PhpException\Function\FunctionJsonEncodeException;
use Ixnode\PhpException\Type\TypeInvalidException;
use Ixnode\PhpNamingConventions\Exception\FunctionReplaceException;
use Ixnode\PhpNamingConventions\NamingConventions;
use JsonException;
use LogicException;
use Stringable;

/**
 * Class Json
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class Json implements Stringable
{
    /** @var array<int|string, mixed> $json */
    protected array $json;

    /** @var array<int|string, mixed> $jsonTranslated */
    protected array $jsonTranslated;

    public const KEY_MODE_DIRECT = 1;

    public const KEY_MODE_UNDERLINE = 2;

    public const KEY_MODE_CONFIGURABLE = 4;

    private const KEY_FIELD_NAME = 'key';

    private const SIGN_EQUAL = '=';

    private const SIGN_UNDERLINE = '_';

    private int $keyMode = self::KEY_MODE_CONFIGURABLE;

    private bool $ignoreMissingKey = false;

    /**
     * File constructor.
     *
     * @param string|object|array<int|string, mixed> $json
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
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
     * Sets the default key mode.
     *
     * @param int $keyMode
     * @return self
     * @throws FunctionReplaceException
     */
    public function setKeyMode(int $keyMode): self
    {
        $this->keyMode = $keyMode;

        $this->translateJson();

        return $this;
    }

    /**
     * @return self
     */
    public function setIgnoreMissingKey(): self
    {
        $this->ignoreMissingKey = true;

        return $this;
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
        $json = $this->convertArrayToJson($this->jsonTranslated);

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
        return $this->convertArrayToObject($this->jsonTranslated);
    }

    /**
     * Returns the json data of this container (as array<int|string, mixed>).
     *
     * @return array<int|string, mixed>
     */
    public function getArray(): array
    {
        return $this->jsonTranslated;
    }

    /**
     * Returns the json data of this container (as array<string, string>).
     *
     * @return array<string, string>
     */
    public function getArrayStringString(): array
    {
        $json = [];

        foreach ($this->jsonTranslated as $index => $value) {
            if (!is_bool($value) && !is_float($value) && !is_int($value) && !is_string($value) && !is_null($value)) {
                throw new LogicException('Value must be bool, float, int, string or null');
            }

            $json[(string) $index] = (string) $value;
        }

        return $json;
    }

    /**
     * Return if the given key exists.
     *
     * @param int|string|array<int, mixed> $keys
     * @param int|null $keyMode
     * @return bool
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     */
    public function hasKey(int|string|array $keys, ?int $keyMode = null): bool
    {
        $keyMode = $keyMode ?: $this->keyMode;

        return match (true) {
            ($keyMode & (self::KEY_MODE_CONFIGURABLE + self::KEY_MODE_DIRECT + self::KEY_MODE_UNDERLINE)) > 0 =>
                $this->hasKeyConfigurable($keys),
            ($keyMode & (self::KEY_MODE_DIRECT + self::KEY_MODE_UNDERLINE)) > 0 =>
                $this->hasKeyDirect($keys),
            default => throw new CaseInvalidException((string) $keyMode, [
                (string) self::KEY_MODE_CONFIGURABLE,
                (string) self::KEY_MODE_DIRECT,
                (string) self::KEY_MODE_UNDERLINE,
            ]),
        };
    }

    /**
     * Return if the given key exists (direct, without array key syntax).
     *
     * @param int|string|array<int, mixed> $keys
     * @param int|null $keyMode
     * @return bool
     */
    private function hasKeyDirect(int|string|array $keys, ?int $keyMode = null): bool
    {
        $keyMode = $keyMode ?: $this->keyMode;

        if (is_int($keys) || is_string($keys)) {
            $keys = [$keys];
        }

        $data = match (true) {
            ($keyMode & self::KEY_MODE_UNDERLINE) > 0 => $this->jsonTranslated,
            default => $this->json,
        };

        foreach ($keys as $key) {
            if (!is_array($data)) {
                return false;
            }

            if (!is_int($key) && !is_string($key)) {
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
     * Returns if the given key exists (with array key syntax).
     *
     * This method is not so fast like the hasKeyDirect method, but it is more configurable in its outputs.
     *
     * @param int|string|array<int, mixed> $keys
     * @param int|null $keyMode
     * @return bool
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws FunctionReplaceException
     * @throws JsonException
     * @throws TypeInvalidException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    private function hasKeyConfigurable(int|string|array $keys, ?int $keyMode = null): bool
    {
        $keyMode = $keyMode ?: $this->keyMode;

        if (is_int($keys) || is_string($keys)) {
            $keys = [$keys];
        }

        $data = match (true) {
            ($keyMode & self::KEY_MODE_UNDERLINE) > 0 => $this->jsonTranslated,
            default => $this->json,
        };

        /* No path given -> always true. */
        if (count($keys) === 0) {
            return true;
        }

        /* Get first key and remove first key from keys. */
        $key = array_shift($keys);

        /* Array in path given (Transfer data as an array). */
        if (is_array($key)) {
            foreach ($data as $value) {
                if (!is_array($value)) {
                    return true;
                }

                $hasKey = (new Json($value))->setIgnoreMissingKey()->hasKey($key);

                if ($hasKey) {
                    return true;
                }
            }

            return false;
        }

        /* Invalid key type given. */
        if (!is_int($key) && !is_string($key)) {
            throw new TypeInvalidException('string', gettype($key));
        }

        /* Invalid path given. */
        if (!array_key_exists($key, $data)) {
            return false;
        }

        /* Transfer data directly. */
        $data = $data[$key];

        /* The end of the given path is reached -> The key path does not exist. */
        if (!is_array($data) && count($keys) > 0) {
            return false;
        }

        /* The end of the given path is reached -> Return true (the key path was found). */
        if (!is_array($data) && count($keys) <= 0) {
            return true;
        }

        /* The input of Json object must be an array. */
        if (!is_array($data)) {
            throw new TypeInvalidException('array');
        }

        return (new Json($data))->hasKey($keys);
    }

    /**
     * Returns the given key as mixed representation (direct - with array key syntax).
     *
     * This method is faster than the getKeyConfigurable method, but not so configurable in its outputs.
     *
     * @param int|string|array<int, mixed> $keys
     * @param int|null $keyMode
     * @return mixed
     * @throws ArrayKeyNotFoundException
     * @throws TypeInvalidException
     */
    private function getKeyDirect(int|string|array $keys, ?int $keyMode = null): mixed
    {
        $keyMode = $keyMode ?: $this->keyMode;

        if (is_int($keys) || is_string($keys)) {
            $keys = [$keys];
        }

        $data = match (true) {
            ($keyMode & self::KEY_MODE_UNDERLINE) > 0 => $this->jsonTranslated,
            default => $this->json,
        };

        foreach ($keys as $key) {
            if (!is_array($data)) {
                throw new TypeInvalidException('array', gettype($data));
            }

            if (!is_int($key) && !is_string($key)) {
                throw new TypeInvalidException('string', 'array');
            }

            if (!array_key_exists($key, $data)) {
                throw new ArrayKeyNotFoundException(strval($key));
            }

            $data = $data[$key];
        }

        return $data;
    }

    /**
     * Deletes the given key as mixed representation (direct - with array key syntax).
     *
     * This method is faster than the deleteKeyConfigurable method, but not so configurable in its outputs.
     *
     * @param int|string|array<int, mixed> $keys
     * @return void
     * @throws ArrayKeyNotFoundException
     * @throws FunctionReplaceException
     * @throws TypeInvalidException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    private function deleteKeyDirect(int|string|array $keys): void
    {
        if (is_int($keys) || is_string($keys)) {
            $keys = [$keys];
        }

        $data = &$this->json;

        $lastKey = null;
        $lastData = null;
        foreach ($keys as $key) {
            if (!is_array($data)) {
                throw new TypeInvalidException('array', gettype($data));
            }

            if (!is_int($key) && !is_string($key)) {
                throw new TypeInvalidException('string', 'array');
            }

            if (!array_key_exists($key, $data)) {
                throw new ArrayKeyNotFoundException(strval($key));
            }

            $lastKey = $key;
            $lastData = &$data;
            $data = &$data[$key];
        }

        if (is_null($lastKey) || is_null($lastData)) {
            return;
        }

        $isIndexedArray = $this->isIndexedArray($lastData);
        unset($lastData[$lastKey]);

        if ($isIndexedArray) {
            $lastData = array_values($lastData);
        }

        $this->jsonTranslated = $this->doTranslateData($this->json);
    }

    /**
     * Read config from the given key path.
     *
     * @param array<int, mixed> $keys
     * @return string|null
     */
    private function readKeyField(array &$keys): string|null
    {
        if (count($keys) <= 0) {
            return null;
        }

        $configKey = $keys[0];

        if (!is_string($configKey)) {
            return null;
        }

        if (!str_contains($configKey, self::SIGN_EQUAL)) {
            return null;
        }

        $split = explode(self::SIGN_EQUAL, $configKey);

        if ($split[0] !== self::KEY_FIELD_NAME) {
            return null;
        }

        array_shift($keys);

        return $split[1];
    }

    /**
     * Returns the given key as mixed representation (with array key syntax).
     *
     * This method is not so fast like the getKeyDirect method, but it is more configurable in its outputs.
     *
     * @param int|string|array<int, mixed> $keys
     * @param int|null $keyMode
     * @return mixed
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    private function getKeyConfigurable(int|string|array $keys, ?int $keyMode = null): mixed
    {
        $keyMode = $keyMode ?: $this->keyMode;

        if (is_int($keys) || is_string($keys)) {
            $keys = [$keys];
        }

        $data = match (true) {
            ($keyMode & self::KEY_MODE_UNDERLINE) > 0 => $this->jsonTranslated,
            default => $this->json,
        };

        /* No path given -> return data from root. */
        if (count($keys) === 0) {
            return $data;
        }

        /* Get first key and remove first key from keys. */
        $key = array_shift($keys);

        /* Array in path given (Transfer data as an array). */
        if (is_array($key)) {
            $collectedData = [];

            $keyField = $this->readKeyField($key);

            foreach ($data as $value) {
                if (!is_array($value)) {
                    $collectedData[] = $value;
                    continue;
                }

                $keyData = (new Json($value))->setIgnoreMissingKey()->getKey($key);

                if (is_null($keyData)) {
                    continue;
                }

                $idValue = match (true) {
                    is_null($keyField) || !array_key_exists($keyField, $value) => null,
                    default => $value[$keyField],
                };

                match (true) {
                    is_null($idValue) => $collectedData[] = $keyData,
                    default => $collectedData[$idValue] = $keyData,
                };
            }

            if (count($keys) <= 0) {
                return $collectedData;
            }

            return (new Json($collectedData))->setIgnoreMissingKey()->getKey($keys);
        }

        /* Invalid key type given. */
        if (!is_int($key) && !is_string($key)) {
            throw new TypeInvalidException('string', gettype($key));
        }

        /* Invalid path given. */
        if (!array_key_exists($key, $data)) {
            if ($this->ignoreMissingKey) {
                return null;
            }

            throw new ArrayKeyNotFoundException(strval($key));
        }

        /* Transfer data directly. */
        $data = $data[$key];

        /* The end of the given path is reached -> The key path does not exist. */
        if (!is_array($data) && count($keys) > 0) {
            throw new CaseInvalidException('Invalid path given (Key does not exist).', ['Valid path']);
        }

        /* The end of the given path is reached -> Return raw value */
        if (!is_array($data) && count($keys) <= 0) {
            return $data;
        }

        /* The input of Json object must be an array. */
        if (!is_array($data)) {
            throw new TypeInvalidException('array');
        }

        $json = (new Json($data));

        if ($this->ignoreMissingKey) {
            $json->setIgnoreMissingKey();
        }

        return $json->getKey($keys);
    }

    /**
     * Returns the given key as mixed representation.
     *
     * @param int|string|array<int, mixed> $keys
     * @param int|null $keyMode
     * @return mixed
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     */
    public function getKey(int|string|array $keys, ?int $keyMode = null): mixed
    {
        $keyMode = $keyMode ?: $this->keyMode;

        return match (true) {
            ($keyMode & (self::KEY_MODE_CONFIGURABLE + self::KEY_MODE_DIRECT  + self::KEY_MODE_UNDERLINE)) > 0 =>
                $this->getKeyConfigurable($keys),
            ($keyMode & (self::KEY_MODE_DIRECT + self::KEY_MODE_UNDERLINE)) > 0 =>
                $this->getKeyDirect($keys),
            default => throw new CaseInvalidException((string) $keyMode, [
                (string) self::KEY_MODE_CONFIGURABLE,
                (string) self::KEY_MODE_DIRECT,
                (string) self::KEY_MODE_UNDERLINE,
            ]),
        };
    }

    /**
     * Removes the given key from this Json object.
     *
     * @param int|string|array<int, mixed> $keys
     * @return void
     * @throws ArrayKeyNotFoundException
     * @throws FunctionReplaceException
     * @throws TypeInvalidException
     */
    public function deleteKey(int|string|array $keys): void
    {
        /* TODO: Implement deleteKeyConfigurable() method according to key mode. */
        $this->deleteKeyDirect($keys);
    }

    /**
     * Returns the given key as boolean representation.
     *
     * @param string|string[] $keys
     * @return bool
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     */
    public function isKeyBoolean(string|array $keys): bool
    {
        $value = $this->getKey($keys);

        if (is_string($value)) {
            match (true) {
                in_array($value, ["false", "0"]) => $value = false,
                in_array($value, ["true", "1"]) => $value = true,
                default => null,
            };
        }

        if (is_int($value)) {
            match ($value) {
                0 => $value = false,
                1 => $value = true,
                default => null,
            };
        }

        if (!is_bool($value)) {
            throw new TypeInvalidException('string', gettype($value));
        }

        return $value;
    }

    /**
     * Alias of isKeyBoolean().
     *
     * @param string|string[] $keys
     * @return bool
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getKeyBoolean(string|array $keys): bool
    {
        return $this->isKeyBoolean($keys);
    }

    /**
     * Returns the given key as string representation.
     *
     * @param string|string[] $keys
     * @return string
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     */
    public function getKeyString(string|array $keys): string
    {
        $value = $this->getKey($keys);

        if (is_int($value)) {
            $value = (string) $value;
        }

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
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
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
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
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
     * @param int|string|array<int, mixed> $keys
     * @return int
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     */
    public function getKeyInteger(int|string|array $keys): int
    {
        $value = $this->getKey($keys);

        if (!is_int($value)) {
            throw new TypeInvalidException('string', gettype($value));
        }

        return $value;
    }

    /**
     * Returns the given key as float representation.
     *
     * @param int|string|array<int, mixed> $keys
     * @return float
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     */
    public function getKeyFloat(int|string|array $keys): float
    {
        $value = $this->getKey($keys);

        if (!is_float($value)) {
            throw new TypeInvalidException('float', gettype($value));
        }

        return $value;
    }

    /**
     * Returns the given key as array representation.
     *
     * @param int|string|array<int, mixed> $keys
     * @return array<int|string, mixed>
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     */
    public function getKeyArray(int|string|array $keys): array
    {
        $value = $this->getKey($keys);

        if (!is_array($value)) {
            throw new TypeInvalidException('array', gettype($value));
        }

        return $value;
    }

    /**
     * Returns the given key as array Json representation.
     *
     * @param int|string|array<int, mixed> $keys
     * @return array<int|string, Json>
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     */
    public function getKeyArrayJson(int|string|array $keys): array
    {
        $values = $this->getKeyArray($keys);

        $data = [];

        foreach ($values as $key => $value) {
            if (!is_array($value)) {
                throw new TypeInvalidException('array', gettype($value));
            }

            $data[$key] = new Json($value);
        }

        return $data;
    }

    /**
     * Returns the given key as array<int, string> representation.
     *
     * @param int|string|array<int, mixed> $keys
     * @return array<int, string>
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     */
    public function getKeyArrayString(int|string|array $keys): array
    {
        $array = [];

        foreach ($this->getKeyArray($keys) as $item) {
            if (!is_bool($item) && !is_float($item) && !is_int($item) && !is_string($item) && !is_null($item)) {
                throw new LogicException('Value must be bool, float, int, string or null');
            }

            $array[] = (string) $item;
        }

        return $array;
    }

    /**
     * Returns the given key as json representation.
     *
     * @param int|string|array<int, mixed> $keys
     * @return Json
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     */
    public function getKeyJson(int|string|array $keys): Json
    {
        $array = $this->getKeyArray($keys);

        return new Json($array);
    }

    /**
     * Translates the given data.
     *
     * @param array<int|string, mixed> $data
     * @return array<int|string, mixed>
     * @throws FunctionReplaceException
     */
    private function doTranslateData(array $data): array
    {
        if (($this->keyMode & self::KEY_MODE_UNDERLINE) <= 0) {
            return $data;
        }

        $dataTranslated = [];

        foreach ($data as $key => $value) {
            $keyName = match (true) {
                /* String value */
                is_string($key) => (new NamingConventions($key))->getSeparated(self::SIGN_UNDERLINE),

                /* Integer value */
                default => $key,
            };

            $dataTranslated[$keyName] = match (true) {
                is_array($value) => $this->doTranslateData($value),
                default => $value,
            };
        }

        return $dataTranslated;
    }

    /**
     * Translates the Json object to the given key mode.
     *
     * @return void
     * @throws FunctionReplaceException
     */
    private function translateJson(): void
    {
        $this->jsonTranslated = $this->doTranslateData($this->json);
    }

    /**
     * Sets the path of this container.
     *
     * @param string|object|array<int|string, mixed> $json
     * @return self
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
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

        $this->translateJson();

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
     * @throws FunctionReplaceException
     * @link JsonTest::wrapperAddJson()
     * @link JsonTest::dataProviderAddJson()
     */
    public function addJson(string|object|array $json, string|array|null $path = null): self
    {
        $addJson = $this->getArrayFromJson($json);
        $keys = $this->normalizePath($path);

        $jsonSource = $this->getArray();
        $jsonAnchor = &$jsonSource;

        foreach ($keys as $key) {
            if (!is_array($jsonAnchor)) {
                throw new TypeInvalidException('array');
            }

            if (!array_key_exists($key, $jsonAnchor)) {
                $jsonAnchor[$key] = [];
            }

            $jsonAnchor = &$jsonAnchor[$key];
        }

        $jsonAnchor = array_merge($jsonAnchor, $addJson);

        $this->json = $jsonSource;

        $this->translateJson();

        return $this;
    }

    /**
     * Adds a given value to this object.
     *
     * @param string|array<int, string> $path
     * @param bool|string|int|float|array<int|string, mixed>|null $value
     * @return self
     * @throws TypeInvalidException
     * @throws FunctionReplaceException
     * @link JsonTest::wrapperAddJson()
     * @link JsonTest::dataProviderAddJson()
     */
    public function addValue(string|array|null $path, bool|string|int|float|array|null $value): self
    {
        $keys = $this->normalizePath($path);

        $jsonSource = $this->getArray();
        $jsonAnchor = &$jsonSource;

        foreach ($keys as $key) {
            if (!is_array($jsonAnchor)) {
                throw new TypeInvalidException('array');
            }

            if (!array_key_exists($key, $jsonAnchor)) {
                $jsonAnchor[$key] = [];
            }

            $jsonAnchor = &$jsonAnchor[$key];
        }

        $jsonAnchor = $value;

        $this->json = $jsonSource;

        $this->translateJson();

        return $this;
    }

    /**
     * Translate and normalize the given path.
     *
     * @param string|array<int, string>|null $path
     * @return array<int, string>
     */
    private function normalizePath(string|array|null $path): array
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

    /**
     * Builds an array with given configuration.
     *
     * @param array<string, string|array<int, string|array<int, string|array<int, mixed>>>> $configuration
     * @return array<string, mixed>
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     */
    public function buildArray(array $configuration): array
    {
        $return = [];

        foreach ($configuration as $key => $path) {
            $return[$key] = $this->getKey($path);
        }

        return $return;
    }

    /**
     * Builds an array with given configuration as combined.
     *
     * @param array<string, string|array<int, string|array<int, string|array<int, mixed>>>> $configuration
     * @return array<int, array<string, mixed>>
     * @throws ArrayKeyNotFoundException
     * @throws CaseInvalidException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     */
    public function buildArrayCombined(array $configuration): array
    {
        $array = $this->buildArray($configuration);

        $count = null;
        foreach ($array as $value) {
            if (!is_array($value)) {
                throw new TypeInvalidException('array', gettype($value));
            }

            if (is_null($count)) {
                $count = count($value);
                continue;
            }

            if (count($value) !== $count) {
                throw new LogicException(sprintf('The count value does not match with the expected (%d -> %d)', count($value), $count));
            }
        }

        $arrayCombined = [];
        foreach ($array as $key => $values) {
            if (!is_array($values)) {
                throw new TypeInvalidException('array', gettype($values));
            }

            foreach ($values as $index => $value) {
                if (!array_key_exists($index, $arrayCombined)) {
                    $arrayCombined[$index] = null;
                }

                $arrayCombined[$index][$key] = $value;
            }
        }

        return $arrayCombined;
    }

    /**
     * Checks if the given array is indexed array.
     *
     * @param array<int|string, mixed> $array
     * @return bool
     */
    private function isIndexedArray(array $array): bool
    {
        return array_values($array) === $array;
    }
}