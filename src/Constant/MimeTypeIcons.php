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

namespace Ixnode\PhpContainer\Constant;

/**
 * Class MimeTypeIcons
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2024-12-17)
 * @since 0.1.0 (2024-12-17) First version.
 */
class MimeTypeIcons
{
    /* Documents. */
    public const TEXTS_AND_MARKDOWNS = '📄'; // .txt, .md, etc.
    public const WORD_DOCUMENTS = '📝'; // .doc, .docx, etc.
    public const PDF_DOCUMENTS = '📑'; // .pdf, etc.
    public const EXCEL_DOCUMENTS = '📊'; // .xls, .xlsx, etc.
    public const POWERPOINT_DOCUMENTS = '📈'; //.ppt, .pptx, etc.
    public const RICHTEXT_DOCUMENTS = '📃'; // .rtf, etc.

    /* Images. */
    public const IMAGES = '🖼️'; // .png, .jpg, .jpeg, .gif, etc.
    public const VECTOR_GRAPHICS = '🎨'; // .svg, etc.
    public const ICONS_AND_BITMAPS = '🖌️'; // .ico, .bmp, etc.
    public const PHOTOSHOP_GIMP_FILES = '🖍️'; // .psd, .xcf, etc.

    /* Archives. */
    public const ARCHIVE_FILES = '📦'; // .zip, .rar, .tar, .gz, etc.
    public const COMPRESSED_ARCHIVES = '🗜️'; // .7z, .xz, etc.

    /* Audio files. */
    public const AUDIO_FILES = '🎵'; // .mp3, .wav, .flac, etc.
    public const AUDIO_FILES_OTHER = '🎶'; // .ogg, .m4a, etc.

    /* Video files. */
    public const VIDEO_FILES = '🎥'; // .mp4, .mkv, .avi, etc.
    public const VIDEO_FILES_OTHER = '📹'; // .mov, .wmv, etc.

    /* Script and code files. */
    public const SHELL_AND_BATCH_SCRIPTS = '⚙️'; // .sh, .bat, etc.
    public const PROGRAMMING_SCRIPTS = '🛠️'; // .php, .js, .ts, etc.
    public const PYTHON_RUBY_CODE = '🐍'; // .py, .rb, etc.
    public const WEB_FILES = '🌐'; // .html, .css, etc.
    public const COMPILED_OR_SOURCE_CODE = '📦'; // .java, .c, .cpp, etc.

    /* DB and SQL files. */
    public const DATABASE_FILES = '🗄️'; // .sql, .db, etc.
    public const SQLITE_AND_ACCESS_FILES = '💾'; // .sqlite, .mdb, etc.

    /* Configuration and log files. */
    public const CONFIGURATION_FILES = '⚙️'; // .yml, .yaml, .json, etc.
    public const CONFIGURATION_FILES_OTHER = '🛠️'; // .xml, .ini, etc.
    public const LOG_FILES = '📜'; // .log, etc.

    /* System and executable files. */
    public const EXECUTABLE_FILES = '🖥️'; // .exe, .app, .bin, etc.
    public const LIBRARIES = '🧩'; // .dll, .so, etc.
    public const SYSTEM_FILES = '⚙️'; // .sys, etc.

    /* Other files */
    public const OTHER = '❓'; // .*
    public const CALENDAR = '📅'; // Calendar
    public const FILE = '📄'; // File
    public const DIRECTORY = '📁'; // Directory
    public const SYMLINK = '🔗'; // Folder
}
