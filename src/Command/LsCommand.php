<?php

/*
 * This file is part of the ixnode/php-cli-image project.
 *
 * (c) Björn Hempel <https://www.hempel.li/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Ixnode\PhpContainer\Command;

use Ahc\Cli\Input\Command;
use Ahc\Cli\Output\Color;
use Ahc\Cli\Output\Writer;
use Exception;
use Ixnode\PhpContainer\Base\BaseFile;
use Ixnode\PhpContainer\Directory;
use Ixnode\PhpContainer\File;
use Ixnode\PhpException\Case\CaseUnsupportedException;
use Ixnode\PhpException\File\FileNotFoundException;
use Ixnode\PhpException\File\FileNotReadableException;
use Ixnode\PhpException\Parser\ParserException;
use LogicException;

/**
 * Class FileCommand
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2024-12-17)
 * @since 0.1.0 (2024-12-17) First version.
 * @property string|null $path
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class LsCommand extends Command
{
    private const SUCCESS = 0;

    private const INVALID = 2;

    private Writer $writer;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct('ls', 'Prints information about the given path.');

        $this
            ->argument('path', 'The path where the information should be displayed.')
        ;
    }

    /**
     * Executes the CliImageCommand.
     *
     * @return int
     * @throws Exception
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function execute(): int
    {
        $this->writer = $this->writer();

        $path = $this->path;

        if (is_null($path)) {
            $this->printError('No path given.');
            return self::INVALID;
        }

        return match (true) {
            is_file($path) => $this->printFile($path),
            is_dir($path) => $this->printDirectory($path),
            default => throw new LogicException(sprintf('Path "%s" is not a file or directory.', $path)),
        };
    }

    /**
     * Prints information about the given file.
     *
     * @param string $path
     * @return int
     * @throws CaseUnsupportedException
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws ParserException
     * @throws \DateInvalidTimeZoneException
     * @throws \DateMalformedStringException
     * @throws Exception
     */
    private function printFile(string $path): int
    {
        $file = new File($path);

        if (!$file->exist()) {
            $this->printError(sprintf('Unable to find given file "%s".', $path));
            return self::INVALID;
        }

        $this->printFileDefault($file);
        $this->printFileCustom1($file);
        $this->printFileCustom2($file);

        return self::SUCCESS;
    }

    /**
     * Prints information about the given directory.
     *
     * @param string $path
     * @return int
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws Exception
     */
    private function printDirectory(string $path): int
    {
        $directory = new Directory($path);

        if (!$directory->exist()) {
            $this->printError(sprintf('Directory "%s" does not exist.', $path));
            return self::INVALID;
        }

        $this->printDirectoryDefault($directory);
        $this->printDirectoryCustom1($directory);
        $this->printDirectoryCustom2($directory);

        $this->writer->write(PHP_EOL);

        return self::SUCCESS;
    }

    /**
     * Prints error message.
     *
     * @param string $message
     * @return void
     * @throws Exception
     */
    private function printError(string $message): void
    {
        $color = new Color();

        $this->writer->write(sprintf('%s%s', $color->error($message), PHP_EOL));
    }

    /**
     * Prints the default output from File.
     *
     * @param File $file
     * @return void
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    private function printFileDefault(File $file): void
    {
        $this->writer->write(PHP_EOL);
        $this->writer->write('1) Default output (@see \Ixnode\PhpContainer\File::getFileInformation)'.PHP_EOL);
        $this->writer->write($file->getFileInformation(), true);
    }

    /**
     * Prints the default output from Directory.
     *
     * @param Directory $directory
     * @return void
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    private function printDirectoryDefault(Directory $directory): void
    {
        $this->writer->write(PHP_EOL);
        $this->writer->write('1) Default output (@see \Ixnode\PhpContainer\Directory::getDirectoryInformation)'.PHP_EOL);
        $this->writer->write($directory->getDirectoryInformation(), true);
    }

    /**
     * Prints a custom output from File.
     *
     * @param File $file
     * @return void
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    private function printFileCustom1(File $file): void
    {
        $distance = [
            'file' => null,
            'type' => null,
        ];

        $this->writer->write(PHP_EOL);
        $this->writer->write('2) Callback output 1 (@see \Ixnode\PhpContainer\Command\LsCommand::printFileCustom1)'.PHP_EOL);
        $this->writer->write($file->getFileInformation(function ($file, $distance): string {
            $template = '%%s %%%ss   [%%%ss]';

            $template = sprintf(
                $template,
                !empty($distance['file']) ? -$distance['file'] : '',
                !empty($distance['type']) ? -$distance['type'] : '',
            );

            $type = $file->getType();

            $typeName = match ($type) {
                BaseFile::TYPE_FILE => 'FILE',
                BaseFile::TYPE_DIRECTORY => 'DIR',
                BaseFile::TYPE_SYMLINK => 'LINK',
                BaseFile::TYPE_UNKNOWN => 'UNKNOWN',
                default => throw new LogicException(sprintf('Unknown file type: %s', $type)),
            };

            return sprintf(
                $template,
                $file->getIcon(),
                $file->getBaseName(),
                $typeName,
            );
        }, $distance), true);
    }

    /**
     * Prints a custom output from Directory.
     *
     * @param Directory $directory
     * @return void
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    private function printDirectoryCustom1(Directory $directory): void
    {
        $distance = [
            'directory' => null,
            'type' => null,
        ];

        $this->writer->write(PHP_EOL);
        $this->writer->write('2) Callback output 1 (@see \Ixnode\PhpContainer\Command\LsCommand::printDirectoryCustom1)'.PHP_EOL);
        $this->writer->write($directory->getDirectoryInformation(function ($directory, $distance): string {
            $template = '%%s %%%ss   [%%%ss]';

            $template = sprintf(
                $template,
                !empty($distance['directory']) ? -$distance['directory'] : '',
                !empty($distance['directory']) ? -$distance['directory'] : '',
            );

            $type = $directory->getType();

            $typeName = match ($type) {
                BaseFile::TYPE_FILE => 'FILE',
                BaseFile::TYPE_DIRECTORY => 'DIR',
                BaseFile::TYPE_SYMLINK => 'LINK',
                BaseFile::TYPE_UNKNOWN => 'UNKNOWN',
                default => throw new LogicException(sprintf('Unknown file type: %s', $type)),
            };

            return sprintf(
                $template,
                $directory->getIcon(),
                $directory->getBaseName(),
                $typeName,
            );
        }, $distance), true);
    }

    /**
     * Prints a custom output from File.
     *
     * @param File $file
     * @return void
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws \DateInvalidTimeZoneException
     * @throws \DateMalformedStringException
     * @throws CaseUnsupportedException
     * @throws ParserException
     */
    private function printFileCustom2(File $file): void
    {
        $this->writer->write(PHP_EOL);
        $this->writer->write('3) Callback output 2 (@see \Ixnode\PhpContainer\Command\LsCommand::printFileCustom2)'.PHP_EOL);
        $this->writer->write(PHP_EOL);

        $this->writer->write($file->getFileInformationTable(additional: [
            'Description' => 'Some more information about this file.',
        ]), true);
    }

    /**
     * Prints a custom output from Directory.
     *
     * @param Directory $directory
     * @return void
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     */
    private function printDirectoryCustom2(Directory $directory): void
    {
        $this->writer->write(PHP_EOL);
        $this->writer->write('3) Callback output 2 (@see \Ixnode\PhpContainer\Command\LsCommand::printDirectoryCustom2)'.PHP_EOL);
        $this->writer->write(PHP_EOL);

        $this->writer->write($directory->getDirectoryInformationTable(additional: [
            'Description' => 'Some more information about this directory.',
        ]), true);
    }
}
