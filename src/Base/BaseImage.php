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

namespace Ixnode\PhpContainer\Base;

use DateTimeImmutable;
use DateTimeZone;
use GdImage;
use Ixnode\PhpContainer\File;
use Ixnode\PhpContainer\Tests\Unit\ImageTest;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use LogicException;
use Stringable;

/**
 * Class Image
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2024-12-07)
 * @since 0.1.0 (2024-12-07) Extend image class with some exif data.
 * @link ImageTest
 */
abstract class BaseImage implements Stringable
{

    public const QUALITY_DEFAULT = 85;

    public const FORMAT_BMP = 'bmp';

    public const FORMAT_GIF = 'gif';

    public const FORMAT_JPG = 'jpg';

    public const FORMAT_PNG = 'png';

    public const FORMAT_WBMP = 'wbmp';

    public const FORMAT_WEBP = 'webp';

    public const FORMAT_XPM = 'xpm';

    public const ORIENTATION_NORMAL = 1; /* Normal orientation. */

    public const ORIENTATION_FLIP_HORIZONTAL = 2; /* Horizontal flip orientation. */

    public const ORIENTATION_ROTATE_180 = 3; /* Upside down orientation. */

    public const ORIENTATION_FLIP_VERTICAL = 4; /* Vertical flip orientation. */

    public const ORIENTATION_ROTATE_90_CW = 6; /* 90° clockwise orientation. */

    public const ORIENTATION_ROTATE_90_CCW = 8; /* 90° counter-clockwise orientation. */

    public const TIMEZONE_INTERNAL = 'UTC';

    private const GPS_COORDINATE_DECIMALS = 6;

    private const GPS_PARTS = 2;

    private const GPS_INDEX_DEGREES = 0;

    private const GPS_INDEX_MINUTES = 1;

    private const GPS_INDEX_SECONDS = 2;

    protected string $imageString;

    protected GdImage|null $gdImage = null;

    /* Exif data. */
    protected int|null $orientation = null;
    protected DateTimeImmutable|null $taken = null;
    protected float|null $latitude = null;
    protected float|null $longitude = null;

    /**
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws \DateMalformedStringException
     * @throws \DateInvalidTimeZoneException
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function __construct(
        string|File $image,
        private bool $ignoreOrientation = false,
        private string $timezoneSource = self::TIMEZONE_INTERNAL
    )
    {
        $this->readImage($image);
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

        /* Fix orientation: GdImage use the exif orientation data to rotate the image automatically. */
        if ($this->ignoreOrientation && !is_null($this->orientation)) {

            $gdImageRotated = match ($this->orientation) {
                /* Upside down rotation. */
                self::ORIENTATION_ROTATE_180 => imagerotate($gdImage, 180, 0),

                /* Rotated 90° clockwise. */
                self::ORIENTATION_ROTATE_90_CW => imagerotate($gdImage, -90, 0),

                /* Rotated 90° counter-clockwise. */
                self::ORIENTATION_ROTATE_90_CCW => imagerotate($gdImage, 90, 0),

                /* Default. */
                default => $gdImage,
            };

            /* Use rotated GdImage object. */
            $gdImage = match (true) {
                $gdImageRotated instanceof GdImage => $gdImageRotated,
                default => $gdImage,
            };
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
     * @throws \DateMalformedStringException
     * @throws \DateInvalidTimeZoneException
     */
    private function readImage(string|File $image): void
    {
        $this->readExifData($image);

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
    protected function getImageStringUnresized(
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
    protected function getImageStringResized(
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

    /**
     * Extracts needed exif data.
     *
     * @param string|File $image
     * @return void
     * @SuppressWarnings(PHPMD.ErrorControlOperator)
     * @throws \DateMalformedStringException
     * @throws \DateInvalidTimeZoneException
     */
    protected function readExifData(string|File $image): void
    {
        if (is_string($image)) {
            return;
        }

        $exifData = @exif_read_data($image->getPath());

        if ($exifData === false) {
            return;
        }

        /* Reads orientation. */
        if (!empty($exifData['Orientation'])) {
            $this->orientation = (int) $exifData['Orientation'];
        }

        /* Reads when the picture was taken. */
        if (!empty($exifData['DateTimeOriginal'])) {
            $this->taken = (new DateTimeImmutable(
                datetime: (string) $exifData['DateTimeOriginal'],
                timezone: new DateTimeZone($this->timezoneSource))
            )->setTimezone(new DateTimeZone(self::TIMEZONE_INTERNAL));
        }

        if (!empty($exifData['GPSLatitude']) && !empty($exifData['GPSLatitudeRef'])) {
            $this->latitude = $this->convertGpsToDecimal(
                gps: $exifData['GPSLatitude'],
                gpsRef: $exifData['GPSLatitudeRef']
            );
        }

        if (!empty($exifData['GPSLongitude']) && !empty($exifData['GPSLongitudeRef'])) {
            $this->longitude = $this->convertGpsToDecimal(
                gps: $exifData['GPSLongitude'],
                gpsRef: $exifData['GPSLongitudeRef']
            );
        }
    }

    /**
     * Converts given gps coordinate to decimal.
     *
     * @param array<int, string> $gps
     */
    protected function convertGpsToDecimal(array $gps, string $gpsRef): float
    {
        $degrees = count($gps) > self::GPS_INDEX_DEGREES ? $this->convertGpsPartToFloat($gps[0]) : 0;
        $minutes = count($gps) > self::GPS_INDEX_MINUTES ? $this->convertGpsPartToFloat($gps[1]) : 0;
        $seconds = count($gps) > self::GPS_INDEX_SECONDS ? $this->convertGpsPartToFloat($gps[2]) : 0;

        $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);

        $decimal *= ($gpsRef === 'S' || $gpsRef === 'W') ? -1 : 1;

        return round($decimal, self::GPS_COORDINATE_DECIMALS);
    }

    /**
     * Converts single gps parts to float.
     */
    private function convertGpsPartToFloat(string $gpsPart): float
    {
        $parts = explode('/', $gpsPart);

        if (count($parts) === self::GPS_PARTS) {
            return (float)$parts[0] / (float)$parts[1];
        }

        return (float)$gpsPart;
    }
}
