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

use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Ixnode\PhpException\Function\FunctionJsonEncodeException;
use Ixnode\PhpException\Type\TypeInvalidException;
use JsonException;

/**
 * Class FileSerializedJson
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 */
class FileSerializedJson extends FileSerialized
{
    /**
     * FileSerializedJson constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        parent::__construct($path);
    }

    /**
     * Checks the serialized json file.
     *
     * @return bool
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws TypeInvalidException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     */
    protected function checkSerializedJson(): bool
    {
        $fileSerialized = new File($this->pathSerialized);

        if (!$fileSerialized->exist()) {
            $this->saveSerializedJson($fileSerialized);
        }

        return true;
    }

    /**
     * Writes serialized json to file.
     *
     * @param File $fileSerialized
     * @return bool
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws TypeInvalidException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     */
    protected function saveSerializedJson(File $fileSerialized): bool
    {
        $content = $this->getContentAsText();

        $json = new Json($content);

        $fileSerialized->write(serialize($json));

        return true;
    }

    /**
     * Returns the Json representation of this file.
     *
     * @return Json
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws TypeInvalidException
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     */
    public function getJson(): Json
    {
        $json = null;

        if ($this->checkSerializedJson()) {
            $json = $this->getUnserialized();
        }

        if (!$json instanceof Json) {
            throw new TypeInvalidException('json', gettype($json));
        }

        return $json;
    }
}
