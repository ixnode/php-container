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

use CurlHandle;
use Ixnode\PhpContainer\Base\BaseContainer;
use Ixnode\PhpException\Function\FunctionCurlExecException;
use Stringable;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

/**
 * Class Curl
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2022-12-30)
 * @since 0.1.0 (2022-12-30) First version.
 */
class Curl extends BaseContainer implements Stringable
{
    /**
     * Curl constructor.
     *
     * @param string $url
     */
    public function __construct(protected string $url)
    {
    }

    /**
     * Returns the url of this container.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->url;
    }

    /**
     * Returns the url of this container.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Sets the url of this container.
     *
     * @param string $url
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Returns the file content as text.
     *
     * @return string
     * @throws ClassNotFoundException
     * @throws FunctionCurlExecException
     */
    public function getContentAsText(): string
    {
        $curlHandle = curl_init($this->url);

        if (!$curlHandle instanceof CurlHandle) {
            throw new ClassNotFoundException(CurlHandle::class);
        }

        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);

        $data = curl_exec($curlHandle);

        if (!is_string($data)) {
            throw new FunctionCurlExecException(curl_error($curlHandle), $this->url);
        }

        curl_close($curlHandle);

        return $data;
    }
}
