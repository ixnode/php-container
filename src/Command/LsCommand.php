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
use Ixnode\PhpCliImage\CliImage;
use Ixnode\PhpContainer\Base\BaseFile;
use Ixnode\PhpContainer\File;
use LogicException;

/**
 * Class FileCommand
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2024-12-17)
 * @since 0.1.0 (2024-12-17) First version.
 * @property string|null $path
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

        $file = new File($path);

        if (!$file->exist()) {
            $this->printError(sprintf('Unable to find given file "%s".', $path));
            return self::INVALID;
        }

        $this->writer->write(PHP_EOL);
        $this->writer->write('Default output (@see \Ixnode\PhpContainer\File::getInformation)'.PHP_EOL);
        $this->writer->write($file->getInformation(), true);

        $distance = [
            'file' => null,
            'type' => null,
        ];

        $this->writer->write(PHP_EOL);
        $this->writer->write('Callback output (@see \Ixnode\PhpContainer\Command\LsCommand::execute)'.PHP_EOL);
        $this->writer->write($file->getInformation(function ($file, $distance): string {
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

        $this->writer->write(PHP_EOL);

        return self::SUCCESS;
    }
}
