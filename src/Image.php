<?php

/*
 * This file is part of the ixnode/php-container project.
 *
 * (c) Björn Hempel <https://www.hempel.li/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Ixnode\PhpContainer;

use DateTimeImmutable;
use Ixnode\PhpContainer\Base\BaseImage;
use Ixnode\PhpContainer\Tests\Unit\ImageTest;
use Ixnode\PhpCoordinate\Coordinate;
use Ixnode\PhpException\Case\CaseUnsupportedException;
use Ixnode\PhpException\Parser\ParserException;
use LogicException;

/**
 * Class Image
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2023-12-14)
 * @since 0.1.0 (2023-12-14) First version.
 * @link ImageTest
 */
class Image extends BaseImage
{
    /**
     * @return string
     */
    public function __toString(): string
    {
        $imageString = $this->getImageString();

        if (is_null($imageString)) {
            throw new LogicException('Unabele to get image string from class Image.');
        }

        return $imageString;
    }

    /**
     * Returns the image string.
     *
     * @param int|null $width
     * @param string $format
     * @param int|null $quality
     * @return string|null
     */
    public function getImageString(
        int $width = null,
        string $format = self::FORMAT_JPG,
        int $quality = null,
    ): string|null
    {
        return match (true) {
            is_null($width) => $this->getImageStringUnresized($format, $quality),
            default => $this->getImageStringResized($width, $format, $quality),
        };
    }

    /**
     * Returns if the given file path is an image.
     *
     * @return bool
     */
    public function isImage(): bool
    {
        return !is_null($this->gdImage);
    }

    /**
     * Returns the image width of the given file path.
     *
     * @return int
     */
    public function getWidth(): int
    {
        if (is_null($this->gdImage)) {
            throw new LogicException('Unable to get image width. Image is not loaded.');
        }

        return imagesx($this->gdImage);
    }

    /**
     * Returns the image height of the given file path.
     *
     * @return int
     */
    public function getHeight(): int
    {
        if (is_null($this->gdImage)) {
            throw new LogicException('Unable to get image width. Image is not loaded.');
        }

        return imagesy($this->gdImage);
    }

    /**
     * Returns the image type of the given file path.
     *
     * @return string
     */
    public function getType(): string
    {
        $imageInformation = getimagesizefromstring($this->imageString);

        if ($imageInformation === false) {
            throw new LogicException('Could not read image string.');
        }

        $type = $imageInformation[2];

        if (!is_int($type)) {
            throw new LogicException('The type must be an integer.');
        }

        return match ($type) {
            IMG_BMP => self::FORMAT_BMP,
            IMG_GIF => self::FORMAT_GIF,
            IMG_JPG => self::FORMAT_JPG,
            IMG_PNG => self::FORMAT_PNG,
            IMG_WBMP => self::FORMAT_WBMP,
            IMG_WEBP => self::FORMAT_WEBP,
            IMG_XPM => self::FORMAT_XPM,
            default => throw new LogicException(sprintf('Image type "%s" is not supported.', $type)),
        };
    }

    /**
     * Returns the number of the bits per color.
     *
     * @return int
     */
    public function getBits(): int
    {
        $imageInformation = getimagesizefromstring($this->imageString);

        if ($imageInformation === false) {
            throw new LogicException('Could not read image string.');
        }

        return $imageInformation['bits'];
    }

    /**
     * Returns the channel number. Has value 3 for RGB graphics and value 4 for CMYK.
     *
     * @return int
     */
    public function getChannels(): int
    {
        $imageInformation = getimagesizefromstring($this->imageString);

        if ($imageInformation === false) {
            throw new LogicException('Could not read image string.');
        }

        return $imageInformation['channels'];
    }

    /**
     * Returns the image mime type of the given file path.
     *
     * @return string
     */
    public function getMimeType(): string
    {
        $imageInformation = getimagesizefromstring($this->imageString);

        if ($imageInformation === false) {
            throw new LogicException('Could not read image string.');
        }

        return $imageInformation['mime'];
    }

    /**
     * Returns the orientation of the image.
     */
    public function getOrientation(): int|null
    {
        return $this->orientation;
    }

    /**
     * Returns the date on which the photo was taken.
     */
    public function getTaken(): DateTimeImmutable|null
    {
        return $this->taken;
    }

    /**
     * Returns the latitude of the picture.
     */
    public function getLatitude(): float|null
    {
        return $this->latitude;
    }

    /**
     * Returns the longitude of the picture.
     */
    public function getLongitude(): float|null
    {
        return $this->longitude;
    }

    /**
     * Returns the coordinate of the picture.
     *
     * @throws CaseUnsupportedException
     * @throws ParserException
     */
    public function getCoordinate(): Coordinate|null
    {
        if (is_null($this->latitude) || is_null($this->longitude)) {
            return null;
        }

        return new Coordinate($this->latitude, $this->longitude);
    }
}
