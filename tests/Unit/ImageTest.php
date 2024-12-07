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

use Ixnode\PhpContainer\Base\BaseImage;
use Ixnode\PhpContainer\File;
use Ixnode\PhpContainer\Image;
use Ixnode\PhpCoordinate\Coordinate;
use Ixnode\PhpException\Case\CaseUnsupportedException;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Ixnode\PhpException\Parser\ParserException;
use PHPUnit\Framework\TestCase;

/**
 * Class ImageTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2024-12-07)
 * @since 0.1.0 (2024-12-07) First version.
 * @link Image
 */
final class ImageTest extends TestCase
{
    /**
     * Test wrapper for Image.
     *
     * @dataProvider dataProviderExif
     *
     * @test
     * @testdox $number) Test Image $path
     * @param int $number
     * @param string $path
     * @param int $width
     * @param int $height
     * @param string $type
     * @param int $bits
     * @param int $channels
     * @param string $mimeType
     * @param int|null $orientation
     * @param string $timezoneSource
     * @param string|null $taken
     * @param float|null $latitude
     * @param float|null $longitude
     * @param Coordinate|null $coordinate
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws \DateInvalidTimeZoneException
     * @throws \DateMalformedStringException
     * @throws CaseUnsupportedException
     * @throws ParserException
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function wrapperExif(
        int $number,
        string $path,
        int $width,
        int $height,
        string $type,
        int $bits,
        int $channels,
        string $mimeType,
        int|null $orientation,
        string $timezoneSource,
        string|null $taken,
        float|null $latitude,
        float|null $longitude,
        Coordinate|null $coordinate
    ): void
    {
        /* Arrange */
        $image = new Image(
            image: new File($path),
            timezoneSource: $timezoneSource,
        );

        /* Act */

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertTrue($image->isImage());
        $this->assertEquals($width, $image->getWidth());
        $this->assertEquals($height, $image->getHeight());
        $this->assertEquals($type, $image->getType());
        $this->assertEquals($bits, $image->getBits());
        $this->assertEquals($channels, $image->getChannels());
        $this->assertEquals($mimeType, $image->getMimeType());
        $this->assertEquals($orientation, $image->getOrientation());
        $this->assertEquals($taken, $image->getTaken()?->format('Y-m-d H:i:s T'));
        $this->assertEquals($latitude, $image->getLatitude());
        $this->assertEquals($longitude, $image->getLongitude());
        $this->assertEquals($coordinate, $image->getCoordinate());
    }

    /**
     * Data provider for File::getPathReal.
     *
     * @return array<int, array<int, mixed>>
     * @throws CaseUnsupportedException
     * @throws ParserException
     */
    public function dataProviderExif(): array
    {
        $number = 0;

        return [
            [
                ++$number,
                'data/image/example-basic.jpg',
                720, /* width */
                480, /* height */
                BaseImage::FORMAT_JPG, /* type */
                8, /* bits */
                3, /* channels */
                'image/jpeg', /* mime type */
                BaseImage::ORIENTATION_NORMAL, /* orientation */
                'Europe/Berlin', /* source timezone */
                '2024-05-05 11:04:17 UTC', /* taken */
                null, /* latitude */
                null, /* longitude */
                null, /* coordinate */
            ],
            [
                ++$number,
                'data/image/example-with-gps.jpg',
                640, /* width */
                480, /* height */
                BaseImage::FORMAT_JPG, /* type */
                8, /* bits */
                3, /* channels */
                'image/jpeg', /* mime type */
                BaseImage::ORIENTATION_ROTATE_90_CW, /* orientation */
                'America/Chicago', /* source timezone */
                '2023-03-10 16:04:52 UTC', /* taken */
                30.268064, /* latitude */
                -97.743242, /* longitude */
                new Coordinate(30.268064, -97.743242), /* coordinate */
            ],
        ];
    }
}
