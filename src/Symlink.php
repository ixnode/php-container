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

use Ixnode\PhpContainer\Base\BaseFile;
use Ixnode\PhpContainer\Constant\MimeTypeIcons;
use LogicException;

/**
 * Class Symlink
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2024-12-18)
 * @since 0.1.0 (2024-12-18) First version.
 */
class Symlink extends BaseFile
{
    /**
     */
    public function __construct(string $path, ?string $rootDir = null)
    {
        parent::__construct($path, $rootDir);

        if (!$this->isSymlink()) {
            throw new LogicException('Given path is not a symlink.');
        }
    }

    /**
     * @return string
     */
    public function getContentAsText(): string
    {
        return 'Symlink: '.$this->path;
    }

    /**
     * Returns the icon of the file.
     *
     * @inheritdoc
     */
    public function getIcon(): string
    {
        return MimeTypeIcons::SYMLINK;
    }
}
