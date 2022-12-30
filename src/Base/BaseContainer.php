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

namespace Ixnode\PhpContainer\Base;

use Ixnode\PhpContainer\Json;
use Ixnode\PhpException\Function\FunctionJsonEncodeException;
use Ixnode\PhpException\Type\TypeInvalidException;
use JsonException;

/**
 * Class BaseContainer
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 */
abstract class BaseContainer
{
    /**
     * Returns the file content as text.
     *
     * @return string
     */
    abstract public function getContentAsText(): string;

    /**
     * Returns the file content as text (trimmed).
     *
     * @return string
     */
    public function getContentAsTextTrim(): string
    {
        return trim($this->getContentAsText());
    }

    /**
     * Returns the file content as json.
     *
     * @return Json
     * @throws FunctionJsonEncodeException
     * @throws JsonException
     * @throws TypeInvalidException
     */
    public function getContentAsJson(): Json
    {
        return new Json($this->getContentAsText());
    }
}
