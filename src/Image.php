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

use GdImage;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use LogicException;
use Stringable;

/**
 * Class Image
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2023-12-14)
 * @since 0.1.0 (2023-12-14) First version.
 */
class Image implements Stringable
{
    public const QUALITY_DEFAULT = 85;

    public const FORMAT_BMP = 'bmp';

    public const FORMAT_GIF = 'gif';

    public const FORMAT_JPG = 'jpg';

    public const FORMAT_PNG = 'png';

    public const FORMAT_WBMP = 'wbmp';

    public const FORMAT_WEBP = 'webp';

    public const FORMAT_XPM = 'xpm';

    private string $imageString;

    private GdImage|null $gdImage = null;

    /**
     * @param string|File $image
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    public function __construct(string|File $image)
    {
        $this->readImage($image);
    }

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
     * Returns the GdImage object.
     *
     * @return GdImage|null
     */
    private function getGdImage(): GdImage|null
    {
        $gdImage = imagecreatefromstring($this->imageString);

        if (!$gdImage instanceof GdImage) {
            return null;
        }

        return $gdImage;
    }

    /**
     * Read and create the GdImage object from file.
     *
     * @param string|File $image
     * @return void
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    private function readImage(string|File $image): void
    {
        $this->imageString = match (true) {
            $image instanceof File => $image->getContentAsText(),
            default => $image,
        };

        $this->gdImage = $this->getGdImage();
    }

    /**
     * Returns the image string.
     *
     * @param int|null $quality
     * @param string $format
     * @return string|null
     */
    private function getImageStringUnresized(
        string $format = self::FORMAT_JPG,
        int $quality = null
    ): string|null
    {
        $gdImage = $this->getGdImage();

        if (is_null($gdImage)) {
            return null;
        }

        ob_start();
        match (true) {
            $format === self::FORMAT_JPG => imagejpeg($gdImage, null, $quality ?? self::QUALITY_DEFAULT),
            $format === self::FORMAT_PNG => imagepng($gdImage),
            default => throw new LogicException('Unsupported image format.'),
        };
        $imageStringUnresized = ob_get_clean();

        if ($imageStringUnresized === false) {
            throw new LogicException('Unable to create image content.');
        }

        imagedestroy($gdImage);

        return $imageStringUnresized;
    }

    /**
     * Returns the (resized) image string.
     *
     * @param int $width
     * @param string $format
     * @param int|null $quality
     * @return string|null
     */
    private function getImageStringResized(
        int $width,
        string $format = self::FORMAT_JPG,
        int $quality = null,
    ): string|null
    {

        $gdImage = $this->getGdImage();

        if (is_null($gdImage)) {
            return null;
        }

        $quality ??= self::QUALITY_DEFAULT;

        /* Get the current dimensions. */
        $widthCurrent = imagesx($gdImage);
        $heightCurrent = imagesy($gdImage);

        /* Calculate the height according to the current aspect ratio */
        $height = intval(round(($width / $widthCurrent) * $heightCurrent));

        $image = imagecreatetruecolor($width, $height);

        if (!$image instanceof GdImage) {
            throw new LogicException('Unable to create image.');
        }

        imagecopyresampled($image, $gdImage, 0, 0, 0, 0, $width, $height, $widthCurrent, $heightCurrent);
        imagedestroy($gdImage);

        ob_start();
        match (true) {
            $format === self::FORMAT_JPG => imagejpeg($image, null, $quality),
            $format === self::FORMAT_PNG => imagepng($image),
            default => throw new LogicException('Unsupported image format.'),
        };
        $imageStringResized = ob_get_clean();

        if ($imageStringResized === false) {
            throw new LogicException('Unable to create image content.');
        }

        imagedestroy($image);

        return $imageStringResized;
    }
}
