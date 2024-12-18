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
 * Class MimeTypes
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2024-12-17)
 * @since 0.1.0 (2024-12-17) First version.
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 * @see: https://wiki.selfhtml.org/wiki/MIME-Type/%C3%9Cbersicht
 */
class MimeTypes
{
    /* A - Application */

    /* application/acad */
    public const APPLICATION_ACAD_TYPE = 'application/acad';
    public const APPLICATION_ACAD_EXTENSIONS = ['.dwg'];
    public const APPLICATION_ACAD_MEANING = 'AutoCAD files (according to NCSA)';
    public const APPLICATION_ACAD = [
        'type' => self::APPLICATION_ACAD_TYPE,
        'extensions' => self::APPLICATION_ACAD_EXTENSIONS,
        'meaning' => self::APPLICATION_ACAD_MEANING,
    ];

    /* application/applefile */
    public const APPLICATION_APPLEFILE_TYPE = 'application/applefile';
    public const APPLICATION_APPLEFILE_EXTENSIONS = [];
    public const APPLICATION_APPLEFILE_MEANING = 'AppleFile files';
    public const APPLICATION_APPLEFILE = [
        'type' => self::APPLICATION_APPLEFILE_TYPE,
        'extensions' => self::APPLICATION_APPLEFILE_EXTENSIONS,
        'meaning' => self::APPLICATION_APPLEFILE_MEANING,
    ];

    /* application/astound */
    public const APPLICATION_ASTOUND_TYPE = 'application/astound';
    public const APPLICATION_ASTOUND_EXTENSIONS = ['.asd', '.asn'];
    public const APPLICATION_ASTOUND_MEANING = 'Astound files';
    public const APPLICATION_ASTOUND = [
        'type' => self::APPLICATION_ASTOUND_TYPE,
        'extensions' => self::APPLICATION_ASTOUND_EXTENSIONS,
        'meaning' => self::APPLICATION_ASTOUND_MEANING,
    ];

    /* application/dsptype */
    public const APPLICATION_DSPTYPE_TYPE = 'application/dsptype';
    public const APPLICATION_DSPTYPE_EXTENSIONS = ['.tsp'];
    public const APPLICATION_DSPTYPE_MEANING = 'TSP files';
    public const APPLICATION_DSPTYPE = [
        'type' => self::APPLICATION_DSPTYPE_TYPE,
        'extensions' => self::APPLICATION_DSPTYPE_EXTENSIONS,
        'meaning' => self::APPLICATION_DSPTYPE_MEANING,
    ];

    /* application/dxf */
    public const APPLICATION_DXF_TYPE = 'application/dxf';
    public const APPLICATION_DXF_EXTENSIONS = ['.dxf'];
    public const APPLICATION_DXF_MEANING = 'AutoCAD files (according to CERN)';
    public const APPLICATION_DXF = [
        'type' => self::APPLICATION_DXF_TYPE,
        'extensions' => self::APPLICATION_DXF_EXTENSIONS,
        'meaning' => self::APPLICATION_DXF_MEANING,
    ];

    /* application/force-download */
    public const APPLICATION_FORCE_DOWNLOAD_TYPE = 'application/force-download';
    public const APPLICATION_FORCE_DOWNLOAD_EXTENSIONS = ['.reg'];
    public const APPLICATION_FORCE_DOWNLOAD_MEANING = 'Registry files';
    public const APPLICATION_FORCE_DOWNLOAD = [
        'type' => self::APPLICATION_FORCE_DOWNLOAD_TYPE,
        'extensions' => self::APPLICATION_FORCE_DOWNLOAD_EXTENSIONS,
        'meaning' => self::APPLICATION_FORCE_DOWNLOAD_MEANING,
    ];

    /* application/futuresplash */
    public const APPLICATION_FUTURESPLASH_TYPE = 'application/futuresplash';
    public const APPLICATION_FUTURESPLASH_EXTENSIONS = ['.spl'];
    public const APPLICATION_FUTURESPLASH_MEANING = 'Flash Futuresplash files';
    public const APPLICATION_FUTURESPLASH = [
        'type' => self::APPLICATION_FUTURESPLASH_TYPE,
        'extensions' => self::APPLICATION_FUTURESPLASH_EXTENSIONS,
        'meaning' => self::APPLICATION_FUTURESPLASH_MEANING,
    ];

    /* application/gzip */
    public const APPLICATION_GZIP_TYPE = 'application/gzip';
    public const APPLICATION_GZIP_EXTENSIONS = ['.gz'];
    public const APPLICATION_GZIP_MEANING = 'GNU Zip files';
    public const APPLICATION_GZIP = [
        'type' => self::APPLICATION_GZIP_TYPE,
        'extensions' => self::APPLICATION_GZIP_EXTENSIONS,
        'meaning' => self::APPLICATION_GZIP_MEANING,
    ];

    /* application/javascript */
    public const APPLICATION_JAVASCRIPT_TYPE = 'application/javascript';
    public const APPLICATION_JAVASCRIPT_EXTENSIONS = ['.js'];
    public const APPLICATION_JAVASCRIPT_MEANING = 'Server-side JavaScript files';
    public const APPLICATION_JAVASCRIPT = [
        'type' => self::APPLICATION_JAVASCRIPT_TYPE,
        'extensions' => self::APPLICATION_JAVASCRIPT_EXTENSIONS,
        'meaning' => self::APPLICATION_JAVASCRIPT_MEANING,
    ];

    /* application/json */
    public const APPLICATION_JSON_TYPE = 'application/json';
    public const APPLICATION_JSON_EXTENSIONS = ['.json'];
    public const APPLICATION_JSON_MEANING = 'Contains a string in JavaScript Object Notation';
    public const APPLICATION_JSON = [
        'type' => self::APPLICATION_JSON_TYPE,
        'extensions' => self::APPLICATION_JSON_EXTENSIONS,
        'meaning' => self::APPLICATION_JSON_MEANING,
    ];

    /* application/listenup */
    public const APPLICATION_LISTENUP_TYPE = 'application/listenup';
    public const APPLICATION_LISTENUP_EXTENSIONS = ['.ptlk'];
    public const APPLICATION_LISTENUP_MEANING = 'Listenup files';
    public const APPLICATION_LISTENUP = [
        'type' => self::APPLICATION_LISTENUP_TYPE,
        'extensions' => self::APPLICATION_LISTENUP_EXTENSIONS,
        'meaning' => self::APPLICATION_LISTENUP_MEANING,
    ];

    /* application/mac-binhex40 */
    public const APPLICATION_MAC_BINHEX40_TYPE = 'application/mac-binhex40';
    public const APPLICATION_MAC_BINHEX40_EXTENSIONS = ['.hqx'];
    public const APPLICATION_MAC_BINHEX40_MEANING = 'Macintosh binary files';
    public const APPLICATION_MAC_BINHEX40 = [
        'type' => self::APPLICATION_MAC_BINHEX40_TYPE,
        'extensions' => self::APPLICATION_MAC_BINHEX40_EXTENSIONS,
        'meaning' => self::APPLICATION_MAC_BINHEX40_MEANING,
    ];

    /* application/msexcel */
    public const APPLICATION_MSEXCEL_TYPE = 'application/msexcel';
    public const APPLICATION_MSEXCEL_EXTENSIONS = ['.xls', '.xla'];
    public const APPLICATION_MSEXCEL_MEANING = 'Microsoft Excel files';
    public const APPLICATION_MSEXCEL = [
        'type' => self::APPLICATION_MSEXCEL_TYPE,
        'extensions' => self::APPLICATION_MSEXCEL_EXTENSIONS,
        'meaning' => self::APPLICATION_MSEXCEL_MEANING,
    ];

    /* application/mshelp */
    public const APPLICATION_MSHELP_TYPE = 'application/mshelp';
    public const APPLICATION_MSHELP_EXTENSIONS = ['.hlp', '.chm'];
    public const APPLICATION_MSHELP_MEANING = 'Microsoft Windows Help files';
    public const APPLICATION_MSHELP = [
        'type' => self::APPLICATION_MSHELP_TYPE,
        'extensions' => self::APPLICATION_MSHELP_EXTENSIONS,
        'meaning' => self::APPLICATION_MSHELP_MEANING,
    ];

    /* application/mspowerpoint */
    public const APPLICATION_MSPOWERPOINT_TYPE = 'application/mspowerpoint';
    public const APPLICATION_MSPOWERPOINT_EXTENSIONS = ['.ppt', '.ppz', '.pps', '.pot'];
    public const APPLICATION_MSPOWERPOINT_MEANING = 'Microsoft Word files';
    public const APPLICATION_MSPOWERPOINT = [
        'type' => self::APPLICATION_MSPOWERPOINT_TYPE,
        'extensions' => self::APPLICATION_MSPOWERPOINT_EXTENSIONS,
        'meaning' => self::APPLICATION_MSPOWERPOINT_MEANING,
    ];

    /* application/msword */
    public const APPLICATION_MSWORD_TYPE = 'application/msword';
    public const APPLICATION_MSWORD_EXTENSIONS = ['.doc', '.dot'];
    public const APPLICATION_MSWORD_MEANING = 'Microsoft Word files';
    public const APPLICATION_MSWORD = [
        'type' => self::APPLICATION_MSWORD_TYPE,
        'extensions' => self::APPLICATION_MSWORD_EXTENSIONS,
        'meaning' => self::APPLICATION_MSWORD_MEANING,
    ];

    /* application/octet-stream */
    public const APPLICATION_OCTET_STREAM_TYPE = 'application/octet-stream';
    public const APPLICATION_OCTET_STREAM_EXTENSIONS = ['.bin', '.file', '.com', '.class', '.ini'];
    public const APPLICATION_OCTET_STREAM_MEANING = 'Unspecified binary data, e.g., executable files';
    public const APPLICATION_OCTET_STREAM = [
        'type' => self::APPLICATION_OCTET_STREAM_TYPE,
        'extensions' => self::APPLICATION_OCTET_STREAM_EXTENSIONS,
        'meaning' => self::APPLICATION_OCTET_STREAM_MEANING,
    ];

    /* application/oda */
    public const APPLICATION_ODA_TYPE = 'application/oda';
    public const APPLICATION_ODA_EXTENSIONS = ['.oda'];
    public const APPLICATION_ODA_MEANING = 'ODA files';
    public const APPLICATION_ODA = [
        'type' => self::APPLICATION_ODA_TYPE,
        'extensions' => self::APPLICATION_ODA_EXTENSIONS,
        'meaning' => self::APPLICATION_ODA_MEANING,
    ];

    /* application/pdf */
    public const APPLICATION_PDF_TYPE = 'application/pdf';
    public const APPLICATION_PDF_EXTENSIONS = ['.pdf'];
    public const APPLICATION_PDF_MEANING = 'PDF files';
    public const APPLICATION_PDF = [
        'type' => self::APPLICATION_PDF_TYPE,
        'extensions' => self::APPLICATION_PDF_EXTENSIONS,
        'meaning' => self::APPLICATION_PDF_MEANING,
    ];

    /* application/postscript */
    public const APPLICATION_POSTSCRIPT_TYPE = 'application/postscript';
    public const APPLICATION_POSTSCRIPT_EXTENSIONS = ['.ai', '.eps', '.ps'];
    public const APPLICATION_POSTSCRIPT_MEANING = 'PostScript files';
    public const APPLICATION_POSTSCRIPT = [
        'type' => self::APPLICATION_POSTSCRIPT_TYPE,
        'extensions' => self::APPLICATION_POSTSCRIPT_EXTENSIONS,
        'meaning' => self::APPLICATION_POSTSCRIPT_MEANING,
    ];

    /* application/rtc */
    public const APPLICATION_RTC_TYPE = 'application/rtc';
    public const APPLICATION_RTC_EXTENSIONS = ['.rtc'];
    public const APPLICATION_RTC_MEANING = 'RTC files';
    public const APPLICATION_RTC = [
        'type' => self::APPLICATION_RTC_TYPE,
        'extensions' => self::APPLICATION_RTC_EXTENSIONS,
        'meaning' => self::APPLICATION_RTC_MEANING,
    ];

    /* application/rtf */
    public const APPLICATION_RTF_TYPE = 'application/rtf';
    public const APPLICATION_RTF_EXTENSIONS = ['.rtf'];
    public const APPLICATION_RTF_MEANING = 'RTF files';
    public const APPLICATION_RTF = [
        'type' => self::APPLICATION_RTF_TYPE,
        'extensions' => self::APPLICATION_RTF_EXTENSIONS,
        'meaning' => self::APPLICATION_RTF_MEANING,
    ];

    /* application/studiom */
    public const APPLICATION_STUDIOM_TYPE = 'application/studiom';
    public const APPLICATION_STUDIOM_EXTENSIONS = ['.smp'];
    public const APPLICATION_STUDIOM_MEANING = 'Studiom files';
    public const APPLICATION_STUDIOM = [
        'type' => self::APPLICATION_STUDIOM_TYPE,
        'extensions' => self::APPLICATION_STUDIOM_EXTENSIONS,
        'meaning' => self::APPLICATION_STUDIOM_MEANING,
    ];

    /* application/toolbook */
    public const APPLICATION_TOOLBOOK_TYPE = 'application/toolbook';
    public const APPLICATION_TOOLBOOK_EXTENSIONS = ['.tbk'];
    public const APPLICATION_TOOLBOOK_MEANING = 'Toolbook files';
    public const APPLICATION_TOOLBOOK = [
        'type' => self::APPLICATION_TOOLBOOK_TYPE,
        'extensions' => self::APPLICATION_TOOLBOOK_EXTENSIONS,
        'meaning' => self::APPLICATION_TOOLBOOK_MEANING,
    ];

    /* application/vnd.oasis.opendocument.chart */
    public const APPLICATION_ODC_TYPE = 'application/vnd.oasis.opendocument.chart';
    public const APPLICATION_ODC_EXTENSIONS = ['.odc'];
    public const APPLICATION_ODC_MEANING = 'OpenDocument Chart files';
    public const APPLICATION_ODC = [
        'type' => self::APPLICATION_ODC_TYPE,
        'extensions' => self::APPLICATION_ODC_EXTENSIONS,
        'meaning' => self::APPLICATION_ODC_MEANING,
    ];

    /* application/vnd.oasis.opendocument.formula */
    public const APPLICATION_ODF_TYPE = 'application/vnd.oasis.opendocument.formula';
    public const APPLICATION_ODF_EXTENSIONS = ['.odf'];
    public const APPLICATION_ODF_MEANING = 'OpenDocument Formula files';
    public const APPLICATION_ODF = [
        'type' => self::APPLICATION_ODF_TYPE,
        'extensions' => self::APPLICATION_ODF_EXTENSIONS,
        'meaning' => self::APPLICATION_ODF_MEANING,
    ];

    /* application/vnd.oasis.opendocument.graphics */
    public const APPLICATION_ODG_TYPE = 'application/vnd.oasis.opendocument.graphics';
    public const APPLICATION_ODG_EXTENSIONS = ['.odg'];
    public const APPLICATION_ODG_MEANING = 'OpenDocument Graphics files';
    public const APPLICATION_ODG = [
        'type' => self::APPLICATION_ODG_TYPE,
        'extensions' => self::APPLICATION_ODG_EXTENSIONS,
        'meaning' => self::APPLICATION_ODG_MEANING,
    ];

    /* application/vnd.oasis.opendocument.image */
    public const APPLICATION_ODI_TYPE = 'application/vnd.oasis.opendocument.image';
    public const APPLICATION_ODI_EXTENSIONS = ['.odi'];
    public const APPLICATION_ODI_MEANING = 'OpenDocument Image files';
    public const APPLICATION_ODI = [
        'type' => self::APPLICATION_ODI_TYPE,
        'extensions' => self::APPLICATION_ODI_EXTENSIONS,
        'meaning' => self::APPLICATION_ODI_MEANING,
    ];

    /* application/vnd.oasis.opendocument.presentation */
    public const APPLICATION_ODP_TYPE = 'application/vnd.oasis.opendocument.presentation';
    public const APPLICATION_ODP_EXTENSIONS = ['.odp'];
    public const APPLICATION_ODP_MEANING = 'OpenDocument Presentation files';
    public const APPLICATION_ODP = [
        'type' => self::APPLICATION_ODP_TYPE,
        'extensions' => self::APPLICATION_ODP_EXTENSIONS,
        'meaning' => self::APPLICATION_ODP_MEANING,
    ];

    /* application/vnd.oasis.opendocument.spreadsheet */
    public const APPLICATION_ODS_TYPE = 'application/vnd.oasis.opendocument.spreadsheet';
    public const APPLICATION_ODS_EXTENSIONS = ['.ods'];
    public const APPLICATION_ODS_MEANING = 'OpenDocument Spreadsheet files';
    public const APPLICATION_ODS = [
        'type' => self::APPLICATION_ODP_TYPE,
        'extensions' => self::APPLICATION_ODP_EXTENSIONS,
        'meaning' => self::APPLICATION_ODP_MEANING,
    ];

    /* application/vnd.oasis.opendocument.text */
    public const APPLICATION_ODT_TYPE = 'application/vnd.oasis.opendocument.text';
    public const APPLICATION_ODT_EXTENSIONS = ['.odt'];
    public const APPLICATION_ODT_MEANING = 'OpenDocument Text';
    public const APPLICATION_ODT = [
        'type' => self::APPLICATION_ODT_TYPE,
        'extensions' => self::APPLICATION_ODT_EXTENSIONS,
        'meaning' => self::APPLICATION_ODT_MEANING,
    ];

    /* application/vnd.oasis.opendocument.text-master */
    public const APPLICATION_ODM_TYPE = 'application/vnd.oasis.opendocument.text-master';
    public const APPLICATION_ODM_EXTENSIONS = ['.odm'];
    public const APPLICATION_ODM_MEANING = 'OpenDocument Global files';
    public const APPLICATION_ODM = [
        'type' => self::APPLICATION_ODM_TYPE,
        'extensions' => self::APPLICATION_ODM_EXTENSIONS,
        'meaning' => self::APPLICATION_ODM_MEANING,
    ];

    /* application/vocaltec-media-desc */
    public const APPLICATION_VMD_TYPE = 'application/vocaltec-media-desc';
    public const APPLICATION_VMD_EXTENSIONS = ['.vmd'];
    public const APPLICATION_VMD_MEANING = 'Vocaltec Mediadesc files';
    public const APPLICATION_VMD = [
        'type' => self::APPLICATION_VMD_TYPE,
        'extensions' => self::APPLICATION_VMD_EXTENSIONS,
        'meaning' => self::APPLICATION_VMD_MEANING,
    ];

    /* application/vocaltec-media-file */
    public const APPLICATION_VMF_TYPE = 'application/vocaltec-media-file';
    public const APPLICATION_VMF_EXTENSIONS = ['.vmf'];
    public const APPLICATION_VMF_MEANING = 'Vocaltec Media files';
    public const APPLICATION_VMF = [
        'type' => self::APPLICATION_VMF_TYPE,
        'extensions' => self::APPLICATION_VMF_EXTENSIONS,
        'meaning' => self::APPLICATION_VMF_MEANING,
    ];

    /* application/vnd.openxmlformats-officedocument.presentationml.presentation */
    public const APPLICATION_PPTX_TYPE = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
    public const APPLICATION_PPTX_EXTENSIONS = ['.pptx'];
    public const APPLICATION_PPTX_MEANING = 'Microsoft PowerPoint files';
    public const APPLICATION_PPTX = [
        'type' => self::APPLICATION_PPTX_TYPE,
        'extensions' => self::APPLICATION_PPTX_EXTENSIONS,
        'meaning' => self::APPLICATION_PPTX_MEANING,
    ];

    /* application/vnd.openxmlformats-officedocument.spreadsheetml.sheet */
    public const APPLICATION_XLSX_TYPE = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    public const APPLICATION_XLSX_EXTENSIONS = ['.xlsx'];
    public const APPLICATION_XLSX_MEANING = 'Microsoft Excel (OpenOffice Calc)';
    public const APPLICATION_XLSX = [
        'type' => self::APPLICATION_XLSX_TYPE,
        'extensions' => self::APPLICATION_XLSX_EXTENSIONS,
        'meaning' => self::APPLICATION_XLSX_MEANING,
    ];

    /* application/vnd.openxmlformats-officedocument.wordprocessingml.document */
    public const APPLICATION_DOCX_TYPE = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    public const APPLICATION_DOCX_EXTENSIONS = ['.docx'];
    public const APPLICATION_DOCX_MEANING = 'Microsoft Word (OpenOffice Writer)';
    public const APPLICATION_DOCX = [
        'type' => self::APPLICATION_DOCX_TYPE,
        'extensions' => self::APPLICATION_DOCX_EXTENSIONS,
        'meaning' => self::APPLICATION_DOCX_MEANING,
    ];

    /* application/xhtml+xml */
    public const APPLICATION_XHTML_TYPE = 'application/xhtml+xml';
    public const APPLICATION_XHTML_EXTENSIONS = ['.htm', '.html', '.shtml', '.xhtml'];
    public const APPLICATION_XHTML_MEANING = 'XHTML files';
    public const APPLICATION_XHTML = [
        'type' => self::APPLICATION_XHTML_TYPE,
        'extensions' => self::APPLICATION_XHTML_EXTENSIONS,
        'meaning' => self::APPLICATION_XHTML_MEANING,
    ];

    /* application/xml */
    public const APPLICATION_XML_TYPE = 'application/xml';
    public const APPLICATION_XML_EXTENSIONS = ['.xml'];
    public const APPLICATION_XML_MEANING = 'XML files';
    public const APPLICATION_XML = [
        'type' => self::APPLICATION_XML_TYPE,
        'extensions' => self::APPLICATION_XML_EXTENSIONS,
        'meaning' => self::APPLICATION_XML_MEANING,
    ];

    /* application/x-bcpio */
    public const APPLICATION_X_BCPIO_TYPE = 'application/x-bcpio';
    public const APPLICATION_X_BCPIO_EXTENSIONS = ['.bcpio'];
    public const APPLICATION_X_BCPIO_MEANING = 'BCPIO files';
    public const APPLICATION_X_BCPIO = [
        'type' => self::APPLICATION_X_BCPIO_TYPE,
        'extensions' => self::APPLICATION_X_BCPIO_EXTENSIONS,
        'meaning' => self::APPLICATION_X_BCPIO_MEANING,
    ];

    /* application/x-compress */
    public const APPLICATION_X_COMPRESS_TYPE = 'application/x-compress';
    public const APPLICATION_X_COMPRESS_EXTENSIONS = ['.z'];
    public const APPLICATION_X_COMPRESS_MEANING = 'Zlib-compressed files';
    public const APPLICATION_X_COMPRESS = [
        'type' => self::APPLICATION_X_COMPRESS_TYPE,
        'extensions' => self::APPLICATION_X_COMPRESS_EXTENSIONS,
        'meaning' => self::APPLICATION_X_COMPRESS_MEANING,
    ];

    /* application/x-cpio */
    public const APPLICATION_X_CPIO_TYPE = 'application/x-cpio';
    public const APPLICATION_X_CPIO_EXTENSIONS = ['.cpio'];
    public const APPLICATION_X_CPIO_MEANING = 'CPIO files';
    public const APPLICATION_X_CPIO = [
        'type' => self::APPLICATION_X_CPIO_TYPE,
        'extensions' => self::APPLICATION_X_CPIO_EXTENSIONS,
        'meaning' => self::APPLICATION_X_CPIO_MEANING,
    ];

    /* application/x-csh */
    public const APPLICATION_X_CSH_TYPE = 'application/x-csh';
    public const APPLICATION_X_CSH_EXTENSIONS = ['.csh'];
    public const APPLICATION_X_CSH_MEANING = 'C-Shell script files';
    public const APPLICATION_X_CSH = [
        'type' => self::APPLICATION_X_CSH_TYPE,
        'extensions' => self::APPLICATION_X_CSH_EXTENSIONS,
        'meaning' => self::APPLICATION_X_CSH_MEANING,
    ];

    /* application/x-director */
    public const APPLICATION_X_DIRECTOR_TYPE = 'application/x-director';
    public const APPLICATION_X_DIRECTOR_EXTENSIONS = ['.dcr', '.dir', '.dxr'];
    public const APPLICATION_X_DIRECTOR_MEANING = 'Macromedia Director files';
    public const APPLICATION_X_DIRECTOR = [
        'type' => self::APPLICATION_X_DIRECTOR_TYPE,
        'extensions' => self::APPLICATION_X_DIRECTOR_EXTENSIONS,
        'meaning' => self::APPLICATION_X_DIRECTOR_MEANING,
    ];

    /* application/x-dvi */
    public const APPLICATION_X_DVI_TYPE = 'application/x-dvi';
    public const APPLICATION_X_DVI_EXTENSIONS = ['.dvi'];
    public const APPLICATION_X_DVI_MEANING = 'DVI files';
    public const APPLICATION_X_DVI = [
        'type' => self::APPLICATION_X_DVI_TYPE,
        'extensions' => self::APPLICATION_X_DVI_EXTENSIONS,
        'meaning' => self::APPLICATION_X_DVI_MEANING,
    ];

    /* application/x-envoy */
    public const APPLICATION_EVY_TYPE = 'application/x-envoy';
    public const APPLICATION_EVY_EXTENSIONS = ['.evy'];
    public const APPLICATION_EVY_MEANING = 'Envoy files';
    public const APPLICATION_EVY = [
        'type' => self::APPLICATION_EVY_TYPE,
        'extensions' => self::APPLICATION_EVY_EXTENSIONS,
        'meaning' => self::APPLICATION_EVY_MEANING,
    ];

    /* application/x-gtar */
    public const APPLICATION_GTAR_TYPE = 'application/x-gtar';
    public const APPLICATION_GTAR_EXTENSIONS = ['.gtar'];
    public const APPLICATION_GTAR_MEANING = 'GNU tar archive files';
    public const APPLICATION_GTAR = [
        'type' => self::APPLICATION_GTAR_TYPE,
        'extensions' => self::APPLICATION_GTAR_EXTENSIONS,
        'meaning' => self::APPLICATION_GTAR_MEANING,
    ];

    /* application/x-hdf */
    public const APPLICATION_HDF_TYPE = 'application/x-hdf';
    public const APPLICATION_HDF_EXTENSIONS = ['.hdf'];
    public const APPLICATION_HDF_MEANING = 'HDF files';
    public const APPLICATION_HDF = [
        'type' => self::APPLICATION_HDF_TYPE,
        'extensions' => self::APPLICATION_HDF_EXTENSIONS,
        'meaning' => self::APPLICATION_HDF_MEANING,
    ];

    /* application/yaml */
    public const APPLICATION_YAML_TYPE = 'application/yaml';
    public const APPLICATION_YAML_EXTENSIONS = ['.yaml', '*.yml'];
    public const APPLICATION_YAML_MEANING = 'YAML configuration files';
    public const APPLICATION_YAML_YML = [
        'type' => self::APPLICATION_YAML_TYPE,
        'extensions' => self::APPLICATION_YAML_EXTENSIONS,
        'meaning' => self::APPLICATION_YAML_MEANING,
    ];

    /* application/x-httpd-php */
    public const APPLICATION_X_HTTPD_PHP_TYPE = 'application/x-httpd-php';
    public const APPLICATION_X_HTTPD_PHP_EXTENSIONS = ['.php', '.phtml'];
    public const APPLICATION_X_HTTPD_PHP_MEANING = 'PHP files';
    public const APPLICATION_X_HTTPD_PHP = [
        'type' => self::APPLICATION_X_HTTPD_PHP_TYPE,
        'extensions' => self::APPLICATION_X_HTTPD_PHP_EXTENSIONS,
        'meaning' => self::APPLICATION_X_HTTPD_PHP_MEANING,
    ];

    /* application/x-latex */
    public const APPLICATION_X_LATEX_TYPE = 'application/x-latex';
    public const APPLICATION_X_LATEX_EXTENSIONS = ['.latex'];
    public const APPLICATION_X_LATEX_MEANING = 'LaTeX source files';
    public const APPLICATION_X_LATEX = [
        'type' => self::APPLICATION_X_LATEX_TYPE,
        'extensions' => self::APPLICATION_X_LATEX_EXTENSIONS,
        'meaning' => self::APPLICATION_X_LATEX_MEANING,
    ];

    /* application/x-macbinary */
    public const APPLICATION_X_MACBINARY_TYPE = 'application/x-macbinary';
    public const APPLICATION_X_MACBINARY_EXTENSIONS = ['.bin'];
    public const APPLICATION_X_MACBINARY_MEANING = 'Macintosh binary files';
    public const APPLICATION_X_MACBINARY = [
        'type' => self::APPLICATION_X_MACBINARY_TYPE,
        'extensions' => self::APPLICATION_X_MACBINARY_EXTENSIONS,
        'meaning' => self::APPLICATION_X_MACBINARY_MEANING,
    ];

    /* application/x-mif */
    public const APPLICATION_X_MIF_TYPE = 'application/x-mif';
    public const APPLICATION_X_MIF_EXTENSIONS = ['.mif'];
    public const APPLICATION_X_MIF_MEANING = 'FrameMaker Interchange Format files';
    public const APPLICATION_X_MIF = [
        'type' => self::APPLICATION_X_MIF_TYPE,
        'extensions' => self::APPLICATION_X_MIF_EXTENSIONS,
        'meaning' => self::APPLICATION_X_MIF_MEANING,
    ];

    /* application/x-netcdf */
    public const APPLICATION_X_NETCDF_TYPE = 'application/x-netcdf';
    public const APPLICATION_X_NETCDF_EXTENSIONS = ['.nc', '.cdf'];
    public const APPLICATION_X_NETCDF_MEANING = 'Unidata CDF files';
    public const APPLICATION_X_NETCDF = [
        'type' => self::APPLICATION_X_NETCDF_TYPE,
        'extensions' => self::APPLICATION_X_NETCDF_EXTENSIONS,
        'meaning' => self::APPLICATION_X_NETCDF_MEANING,
    ];

    /* application/x-nschat */
    public const APPLICATION_X_NSCHAT_TYPE = 'application/x-nschat';
    public const APPLICATION_X_NSCHAT_EXTENSIONS = ['.nsc'];
    public const APPLICATION_X_NSCHAT_MEANING = 'NS Chat files';
    public const APPLICATION_X_NSCHAT = [
        'type' => self::APPLICATION_X_NSCHAT_TYPE,
        'extensions' => self::APPLICATION_X_NSCHAT_EXTENSIONS,
        'meaning' => self::APPLICATION_X_NSCHAT_MEANING,
    ];

    /* application/x-sh */
    public const APPLICATION_X_SH_TYPE = 'application/x-sh';
    public const APPLICATION_X_SH_EXTENSIONS = ['.sh'];
    public const APPLICATION_X_SH_MEANING = 'Bourne Shell script files';
    public const APPLICATION_X_SH = [
        'type' => self::APPLICATION_X_SH_TYPE,
        'extensions' => self::APPLICATION_X_SH_EXTENSIONS,
        'meaning' => self::APPLICATION_X_SH_MEANING,
    ];

    /* application/x-shar */
    public const APPLICATION_X_SHAR_TYPE = 'application/x-shar';
    public const APPLICATION_X_SHAR_EXTENSIONS = ['.shar'];
    public const APPLICATION_X_SHAR_MEANING = 'Shell archive files';
    public const APPLICATION_X_SHAR = [
        'type' => self::APPLICATION_X_SHAR_TYPE,
        'extensions' => self::APPLICATION_X_SHAR_EXTENSIONS,
        'meaning' => self::APPLICATION_X_SHAR_MEANING,
    ];

    /* application/x-shockwave-flash */
    public const APPLICATION_X_SHOCKWAVE_FLASH_TYPE = 'application/x-shockwave-flash';
    public const APPLICATION_X_SHOCKWAVE_FLASH_EXTENSIONS = ['.swf', '.cab'];
    public const APPLICATION_X_SHOCKWAVE_FLASH_MEANING = 'Flash Shockwave files';
    public const APPLICATION_X_SHOCKWAVE_FLASH = [
        'type' => self::APPLICATION_X_SHOCKWAVE_FLASH_TYPE,
        'extensions' => self::APPLICATION_X_SHOCKWAVE_FLASH_EXTENSIONS,
        'meaning' => self::APPLICATION_X_SHOCKWAVE_FLASH_MEANING,
    ];

    /* application/x-sprite */
    public const APPLICATION_X_SPRITE_TYPE = 'application/x-sprite';
    public const APPLICATION_X_SPRITE_EXTENSIONS = ['.spr', '.sprite'];
    public const APPLICATION_X_SPRITE_MEANING = 'Sprite files';
    public const APPLICATION_X_SPRITE = [
        'type' => self::APPLICATION_X_SPRITE_TYPE,
        'extensions' => self::APPLICATION_X_SPRITE_EXTENSIONS,
        'meaning' => self::APPLICATION_X_SPRITE_MEANING,
    ];

    /* application/x-stuffit */
    public const APPLICATION_X_STUFFIT_TYPE = 'application/x-stuffit';
    public const APPLICATION_X_STUFFIT_EXTENSIONS = ['.sit'];
    public const APPLICATION_X_STUFFIT_MEANING = 'Stuffit archive files';
    public const APPLICATION_X_STUFFIT = [
        'type' => self::APPLICATION_X_STUFFIT_TYPE,
        'extensions' => self::APPLICATION_X_STUFFIT_EXTENSIONS,
        'meaning' => self::APPLICATION_X_STUFFIT_MEANING,
    ];

    /* application/x-supercard */
    public const APPLICATION_X_SUPERCARD_TYPE = 'application/x-supercard';
    public const APPLICATION_X_SUPERCARD_EXTENSIONS = ['.sca'];
    public const APPLICATION_X_SUPERCARD_MEANING = 'Supercard files';
    public const APPLICATION_X_SUPERCARD = [
        'type' => self::APPLICATION_X_SUPERCARD_TYPE,
        'extensions' => self::APPLICATION_X_SUPERCARD_EXTENSIONS,
        'meaning' => self::APPLICATION_X_SUPERCARD_MEANING,
    ];

    /* application/x-sv4cpio */
    public const APPLICATION_X_SV4CPIO_TYPE = 'application/x-sv4cpio';
    public const APPLICATION_X_SV4CPIO_EXTENSIONS = ['.sv4cpio'];
    public const APPLICATION_X_SV4CPIO_MEANING = 'SV4 CPIO files';
    public const APPLICATION_X_SV4CPIO = [
        'type' => self::APPLICATION_X_SV4CPIO_TYPE,
        'extensions' => self::APPLICATION_X_SV4CPIO_EXTENSIONS,
        'meaning' => self::APPLICATION_X_SV4CPIO_MEANING,
    ];

    /* application/x-sv4crc */
    public const APPLICATION_X_SV4CRC_TYPE = 'application/x-sv4crc';
    public const APPLICATION_X_SV4CRC_EXTENSIONS = ['.sv4crc'];
    public const APPLICATION_X_SV4CRC_MEANING = 'SV4 CPIO files with CRC';
    public const APPLICATION_X_SV4CRC = [
        'type' => self::APPLICATION_X_SV4CRC_TYPE,
        'extensions' => self::APPLICATION_X_SV4CRC_EXTENSIONS,
        'meaning' => self::APPLICATION_X_SV4CRC_MEANING,
    ];

    /* application/x-tar */
    public const APPLICATION_X_TAR_TYPE = 'application/x-tar';
    public const APPLICATION_X_TAR_EXTENSIONS = ['.tar'];
    public const APPLICATION_X_TAR_MEANING = 'TAR archive files';
    public const APPLICATION_X_TAR = [
        'type' => self::APPLICATION_X_TAR_TYPE,
        'extensions' => self::APPLICATION_X_TAR_EXTENSIONS,
        'meaning' => self::APPLICATION_X_TAR_MEANING,
    ];

    /* application/x-tcl */
    public const APPLICATION_X_TCL_TYPE = 'application/x-tcl';
    public const APPLICATION_X_TCL_EXTENSIONS = ['.tcl'];
    public const APPLICATION_X_TCL_MEANING = 'TCL script files';
    public const APPLICATION_X_TCL = [
        'type' => self::APPLICATION_X_TCL_TYPE,
        'extensions' => self::APPLICATION_X_TCL_EXTENSIONS,
        'meaning' => self::APPLICATION_X_TCL_MEANING,
    ];

    /* application/x-tex */
    public const APPLICATION_X_TEX_TYPE = 'application/x-tex';
    public const APPLICATION_X_TEX_EXTENSIONS = ['.tex'];
    public const APPLICATION_X_TEX_MEANING = 'TeX source files';
    public const APPLICATION_X_TEX = [
        'type' => self::APPLICATION_X_TEX_TYPE,
        'extensions' => self::APPLICATION_X_TEX_EXTENSIONS,
        'meaning' => self::APPLICATION_X_TEX_MEANING,
    ];

    /* application/x-texinfo */
    public const APPLICATION_X_TEXINFO_TYPE = 'application/x-texinfo';
    public const APPLICATION_X_TEXINFO_EXTENSIONS = ['.texinfo', '.texi'];
    public const APPLICATION_X_TEXINFO_MEANING = 'Texinfo files';
    public const APPLICATION_X_TEXINFO = [
        'type' => self::APPLICATION_X_TEXINFO_TYPE,
        'extensions' => self::APPLICATION_X_TEXINFO_EXTENSIONS,
        'meaning' => self::APPLICATION_X_TEXINFO_MEANING,
    ];

    /* application/x-troff */
    public const APPLICATION_X_TROFF_TYPE = 'application/x-troff';
    public const APPLICATION_X_TROFF_EXTENSIONS = ['.t', '.tr', '.roff'];
    public const APPLICATION_X_TROFF_MEANING = 'TROFF files (Unix)';
    public const APPLICATION_X_TROFF = [
        'type' => self::APPLICATION_X_TROFF_TYPE,
        'extensions' => self::APPLICATION_X_TROFF_EXTENSIONS,
        'meaning' => self::APPLICATION_X_TROFF_MEANING,
    ];

    /* application/x-troff-man */
    public const APPLICATION_X_TROFF_MAN_TYPE = 'application/x-troff-man';
    public const APPLICATION_X_TROFF_MAN_EXTENSIONS = ['.man', '.troff'];
    public const APPLICATION_X_TROFF_MAN_MEANING = 'TROFF files with MAN macros (Unix)';
    public const APPLICATION_X_TROFF_MAN = [
        'type' => self::APPLICATION_X_TROFF_MAN_TYPE,
        'extensions' => self::APPLICATION_X_TROFF_MAN_EXTENSIONS,
        'meaning' => self::APPLICATION_X_TROFF_MAN_MEANING,
    ];

    /* application/x-troff-me */
    public const APPLICATION_X_TROFF_ME_TYPE = 'application/x-troff-me';
    public const APPLICATION_X_TROFF_ME_EXTENSIONS = ['.me', '.troff'];
    public const APPLICATION_X_TROFF_ME_MEANING = 'TROFF files with ME macros (Unix)';
    public const APPLICATION_X_TROFF_ME = [
        'type' => self::APPLICATION_X_TROFF_ME_TYPE,
        'extensions' => self::APPLICATION_X_TROFF_ME_EXTENSIONS,
        'meaning' => self::APPLICATION_X_TROFF_ME_MEANING,
    ];

    /* application/x-troff-ms */
    public const APPLICATION_X_TROFF_MS_TYPE = 'application/x-troff-ms';
    public const APPLICATION_X_TROFF_MS_EXTENSIONS = ['.me', '.troff'];
    public const APPLICATION_X_TROFF_MS_MEANING = 'TROFF files with MS macros (Unix)';
    public const APPLICATION_X_TROFF_MS = [
        'type' => self::APPLICATION_X_TROFF_MS_TYPE,
        'extensions' => self::APPLICATION_X_TROFF_MS_EXTENSIONS,
        'meaning' => self::APPLICATION_X_TROFF_MS_MEANING,
    ];

    /* application/x-ustar */
    public const APPLICATION_X_USTAR_TYPE = 'application/x-ustar';
    public const APPLICATION_X_USTAR_EXTENSIONS = ['.ustar'];
    public const APPLICATION_X_USTAR_MEANING = 'POSIX TAR archive files';
    public const APPLICATION_X_USTAR = [
        'type' => self::APPLICATION_X_USTAR_TYPE,
        'extensions' => self::APPLICATION_X_USTAR_EXTENSIONS,
        'meaning' => self::APPLICATION_X_USTAR_MEANING,
    ];

    /* application/x-wais-source */
    public const APPLICATION_X_WAIS_SOURCE_TYPE = 'application/x-wais-source';
    public const APPLICATION_X_WAIS_SOURCE_EXTENSIONS = ['.src'];
    public const APPLICATION_X_WAIS_SOURCE_MEANING = 'WAIS source files';
    public const APPLICATION_X_WAIS_SOURCE = [
        'type' => self::APPLICATION_X_WAIS_SOURCE_TYPE,
        'extensions' => self::APPLICATION_X_WAIS_SOURCE_EXTENSIONS,
        'meaning' => self::APPLICATION_X_WAIS_SOURCE_MEANING,
    ];

    /* application/x-www-form-urlencoded */
    public const APPLICATION_X_WWW_FORM_URLENCODED_TYPE = 'application/x-www-form-urlencoded';
    public const APPLICATION_X_WWW_FORM_URLENCODED_EXTENSIONS = [];
    public const APPLICATION_X_WWW_FORM_URLENCODED_MEANING = 'HTML form data for CGI';
    public const APPLICATION_X_WWW_FORM_URLENCODED = [
        'type' => self::APPLICATION_X_WWW_FORM_URLENCODED_TYPE,
        'extensions' => self::APPLICATION_X_WWW_FORM_URLENCODED_EXTENSIONS,
        'meaning' => self::APPLICATION_X_WWW_FORM_URLENCODED_MEANING,
    ];

    /* application/zip */
    public const APPLICATION_ZIP_TYPE = 'application/zip';
    public const APPLICATION_ZIP_EXTENSIONS = ['.zip'];
    public const APPLICATION_ZIP_MEANING = 'ZIP archive files';
    public const APPLICATION_ZIP = [
        'type' => self::APPLICATION_ZIP_TYPE,
        'extensions' => self::APPLICATION_ZIP_EXTENSIONS,
        'meaning' => self::APPLICATION_ZIP_MEANING,
    ];

    /* A - Audio */

    /* audio/basic */
    public const AUDIO_BASIC_TYPE = 'audio/basic';
    public const AUDIO_BASIC_EXTENSIONS = ['.au', '.snd'];
    public const AUDIO_BASIC_MEANING = 'Basic sound files';
    public const AUDIO_BASIC = [
        'type' => self::AUDIO_BASIC_TYPE,
        'extensions' => self::AUDIO_BASIC_EXTENSIONS,
        'meaning' => self::AUDIO_BASIC_MEANING,
    ];

    /* audio/echospeech */
    public const AUDIO_ECHOSPEECH_TYPE = 'audio/echospeech';
    public const AUDIO_ECHOSPEECH_EXTENSIONS = ['.es'];
    public const AUDIO_ECHOSPEECH_MEANING = 'Echospeed sound files';
    public const AUDIO_ECHOSPEECH = [
        'type' => self::AUDIO_ECHOSPEECH_TYPE,
        'extensions' => self::AUDIO_ECHOSPEECH_EXTENSIONS,
        'meaning' => self::AUDIO_ECHOSPEECH_MEANING,
    ];

    /* audio/mpeg */
    public const AUDIO_MPEG_TYPE = 'audio/mpeg';
    public const AUDIO_MPEG_EXTENSIONS = ['.mp3'];
    public const AUDIO_MPEG_MEANING = 'MP3 audio files';
    public const AUDIO_MPEG = [
        'type' => self::AUDIO_MPEG_TYPE,
        'extensions' => self::AUDIO_MPEG_EXTENSIONS,
        'meaning' => self::AUDIO_MPEG_MEANING,
    ];

    /* audio/mp4 */
    public const AUDIO_MP4_TYPE = 'audio/mp4';
    public const AUDIO_MP4_EXTENSIONS = ['.mp4'];
    public const AUDIO_MP4_MEANING = 'MP4 audio files';
    public const AUDIO_MP4 = [
        'type' => self::AUDIO_MP4_TYPE,
        'extensions' => self::AUDIO_MP4_EXTENSIONS,
        'meaning' => self::AUDIO_MP4_MEANING,
    ];

    /* audio/ogg */
    public const AUDIO_OGG_TYPE = 'audio/ogg';
    public const AUDIO_OGG_EXTENSIONS = ['.ogg'];
    public const AUDIO_OGG_MEANING = 'OGG audio files';
    public const AUDIO_OGG = [
        'type' => self::AUDIO_OGG_TYPE,
        'extensions' => self::AUDIO_OGG_EXTENSIONS,
        'meaning' => self::AUDIO_OGG_MEANING,
    ];

    /* audio/opus */
    public const AUDIO_OPUS_TYPE = 'audio/opus';
    public const AUDIO_OPUS_EXTENSIONS = ['.opus'];
    public const AUDIO_OPUS_MEANING = 'Opus audio files';
    public const AUDIO_OPUS = [
        'type' => self::AUDIO_OPUS_TYPE,
        'extensions' => self::AUDIO_OPUS_EXTENSIONS,
        'meaning' => self::AUDIO_OPUS_MEANING,
    ];

    /* audio/tsplayer */
    public const AUDIO_TSPLAYER_TYPE = 'audio/tsplayer';
    public const AUDIO_TSPLAYER_EXTENSIONS = ['.tsi'];
    public const AUDIO_TSPLAYER_MEANING = 'TS Player sound files';
    public const AUDIO_TSPLAYER = [
        'type' => self::AUDIO_TSPLAYER_TYPE,
        'extensions' => self::AUDIO_TSPLAYER_EXTENSIONS,
        'meaning' => self::AUDIO_TSPLAYER_MEANING,
    ];

    /* audio/voxware */
    public const AUDIO_VOXWARE_TYPE = 'audio/voxware';
    public const AUDIO_VOXWARE_EXTENSIONS = ['.vox'];
    public const AUDIO_VOXWARE_MEANING = 'Vox sound files';
    public const AUDIO_VOXWARE = [
        'type' => self::AUDIO_VOXWARE_TYPE,
        'extensions' => self::AUDIO_VOXWARE_EXTENSIONS,
        'meaning' => self::AUDIO_VOXWARE_MEANING,
    ];

    /* audio/wav */
    public const AUDIO_WAV_TYPE = 'audio/wav';
    public const AUDIO_WAV_EXTENSIONS = ['.wav'];
    public const AUDIO_WAV_MEANING = 'WAV sound files';
    public const AUDIO_WAV = [
        'type' => self::AUDIO_WAV_TYPE,
        'extensions' => self::AUDIO_WAV_EXTENSIONS,
        'meaning' => self::AUDIO_WAV_MEANING,
    ];

    /* audio/x-aiff */
    public const AUDIO_X_AIFF_TYPE = 'audio/x-aiff';
    public const AUDIO_X_AIFF_EXTENSIONS = ['.aif', '.aiff', '.aifc'];
    public const AUDIO_X_AIFF_MEANING = 'AIFF sound files';
    public const AUDIO_X_AIFF = [
        'type' => self::AUDIO_X_AIFF_TYPE,
        'extensions' => self::AUDIO_X_AIFF_EXTENSIONS,
        'meaning' => self::AUDIO_X_AIFF_MEANING,
    ];

    /* audio/x-dspeech */
    public const AUDIO_X_DSPEECH_TYPE = 'audio/x-dspeech';
    public const AUDIO_X_DSPEECH_EXTENSIONS = ['.dus', '.cht'];
    public const AUDIO_X_DSPEECH_MEANING = 'Speech sound files';
    public const AUDIO_X_DSPEECH = [
        'type' => self::AUDIO_X_DSPEECH_TYPE,
        'extensions' => self::AUDIO_X_DSPEECH_EXTENSIONS,
        'meaning' => self::AUDIO_X_DSPEECH_MEANING,
    ];

    /* audio/x-midi */
    public const AUDIO_X_MIDI_TYPE = 'audio/x-midi';
    public const AUDIO_X_MIDI_EXTENSIONS = ['.mid', '.midi'];
    public const AUDIO_X_MIDI_MEANING = 'MIDI audio files';
    public const AUDIO_X_MIDI = [
        'type' => self::AUDIO_X_MIDI_TYPE,
        'extensions' => self::AUDIO_X_MIDI_EXTENSIONS,
        'meaning' => self::AUDIO_X_MIDI_MEANING,
    ];

    /* audio/x-mpeg */
    public const AUDIO_X_MPEG_TYPE = 'audio/x-mpeg';
    public const AUDIO_X_MPEG_EXTENSIONS = ['.mp2'];
    public const AUDIO_X_MPEG_MEANING = 'MPEG audio files';
    public const AUDIO_X_MPEG = [
        'type' => self::AUDIO_X_MPEG_TYPE,
        'extensions' => self::AUDIO_X_MPEG_EXTENSIONS,
        'meaning' => self::AUDIO_X_MPEG_MEANING,
    ];

    /* audio/x-pn-realaudio */
    public const AUDIO_X_PN_REALAUDIO_TYPE = 'audio/x-pn-realaudio';
    public const AUDIO_X_PN_REALAUDIO_EXTENSIONS = ['.ram', '.ra'];
    public const AUDIO_X_PN_REALAUDIO_MEANING = 'RealAudio files';
    public const AUDIO_X_PN_REALAUDIO = [
        'type' => self::AUDIO_X_PN_REALAUDIO_TYPE,
        'extensions' => self::AUDIO_X_PN_REALAUDIO_EXTENSIONS,
        'meaning' => self::AUDIO_X_PN_REALAUDIO_MEANING,
    ];

    /* audio/x-pn-realaudio-plugin */
    public const AUDIO_X_PN_REALAUDIO_PLUGIN_TYPE = 'audio/x-pn-realaudio-plugin';
    public const AUDIO_X_PN_REALAUDIO_PLUGIN_EXTENSIONS = ['.rpm'];
    public const AUDIO_X_PN_REALAUDIO_PLUGIN_MEANING = 'RealAudio plugin files';
    public const AUDIO_X_PN_REALAUDIO_PLUGIN = [
        'type' => self::AUDIO_X_PN_REALAUDIO_PLUGIN_TYPE,
        'extensions' => self::AUDIO_X_PN_REALAUDIO_PLUGIN_EXTENSIONS,
        'meaning' => self::AUDIO_X_PN_REALAUDIO_PLUGIN_MEANING,
    ];

    /* audio/x-qt-stream */
    public const AUDIO_X_QT_STREAM_TYPE = 'audio/x-qt-stream';
    public const AUDIO_X_QT_STREAM_EXTENSIONS = ['.stream'];
    public const AUDIO_X_QT_STREAM_MEANING = 'Quicktime streaming audio';
    public const AUDIO_X_QT_STREAM = [
        'type' => self::AUDIO_X_QT_STREAM_TYPE,
        'extensions' => self::AUDIO_X_QT_STREAM_EXTENSIONS,
        'meaning' => self::AUDIO_X_QT_STREAM_MEANING,
    ];

    /* D - Drawing */

    /* drawing/x-dwf */
    public const DRAWING_X_DWF_TYPE = 'drawing/x-dwf';
    public const DRAWING_X_DWF_EXTENSIONS = ['.dwf'];
    public const DRAWING_X_DWF_MEANING = 'Drawing files';
    public const DRAWING_X_DWF = [
        'type' => self::DRAWING_X_DWF_TYPE,
        'extensions' => self::DRAWING_X_DWF_EXTENSIONS,
        'meaning' => self::DRAWING_X_DWF_MEANING,
    ];

    /* I - Image */

    /* image/bmp */
    public const IMAGE_BMP_TYPE = 'image/bmp';
    public const IMAGE_BMP_EXTENSIONS = ['.bmp'];
    public const IMAGE_BMP_MEANING = 'Windows Bitmap files';
    public const IMAGE_BMP = [
        'type' => self::IMAGE_BMP_TYPE,
        'extensions' => self::IMAGE_BMP_EXTENSIONS,
        'meaning' => self::IMAGE_BMP_MEANING,
    ];

    /* image/x-bmp */
    public const IMAGE_X_BMP_TYPE = 'image/x-bmp';
    public const IMAGE_X_BMP_EXTENSIONS = ['.bmp'];
    public const IMAGE_X_BMP_MEANING = 'Windows Bitmap files';
    public const IMAGE_X_BMP = [
        'type' => self::IMAGE_X_BMP_TYPE,
        'extensions' => self::IMAGE_X_BMP_EXTENSIONS,
        'meaning' => self::IMAGE_X_BMP_MEANING,
    ];

    /* image/x-ms-bmp */
    public const IMAGE_X_MS_BMP_TYPE = 'image/x-ms-bmp';
    public const IMAGE_X_MS_BMP_EXTENSIONS = ['.bmp'];
    public const IMAGE_X_MS_BMP_MEANING = 'Windows Bitmap files';
    public const IMAGE_X_MS_BMP = [
        'type' => self::IMAGE_X_MS_BMP_TYPE,
        'extensions' => self::IMAGE_X_MS_BMP_EXTENSIONS,
        'meaning' => self::IMAGE_X_MS_BMP_MEANING,
    ];

    /* image/cis-cod */
    public const IMAGE_CIS_COD_TYPE = 'image/cis-cod';
    public const IMAGE_CIS_COD_EXTENSIONS = ['.cod'];
    public const IMAGE_CIS_COD_MEANING = 'CIS Cod files';
    public const IMAGE_CIS_COD = [
        'type' => self::IMAGE_CIS_COD_TYPE,
        'extensions' => self::IMAGE_CIS_COD_EXTENSIONS,
        'meaning' => self::IMAGE_CIS_COD_MEANING,
    ];

    /* image/cmu-raster */
    public const IMAGE_CMU_RASTER_TYPE = 'image/cmu-raster';
    public const IMAGE_CMU_RASTER_EXTENSIONS = ['.ras'];
    public const IMAGE_CMU_RASTER_MEANING = 'CMU Raster files';
    public const IMAGE_CMU_RASTER = [
        'type' => self::IMAGE_CMU_RASTER_TYPE,
        'extensions' => self::IMAGE_CMU_RASTER_EXTENSIONS,
        'meaning' => self::IMAGE_CMU_RASTER_MEANING,
    ];

    /* image/fif */
    public const IMAGE_FIF_TYPE = 'image/fif';
    public const IMAGE_FIF_EXTENSIONS = ['.fif'];
    public const IMAGE_FIF_MEANING = 'FIF image files';
    public const IMAGE_FIF = [
        'type' => self::IMAGE_FIF_TYPE,
        'extensions' => self::IMAGE_FIF_EXTENSIONS,
        'meaning' => self::IMAGE_FIF_MEANING,
    ];

    /* image/gif */
    public const IMAGE_GIF_TYPE = 'image/gif';
    public const IMAGE_GIF_EXTENSIONS = ['.gif'];
    public const IMAGE_GIF_MEANING = 'GIF image files';
    public const IMAGE_GIF = [
        'type' => self::IMAGE_GIF_TYPE,
        'extensions' => self::IMAGE_GIF_EXTENSIONS,
        'meaning' => self::IMAGE_GIF_MEANING,
    ];

    /* image/ief */
    public const IMAGE_IEF_TYPE = 'image/ief';
    public const IMAGE_IEF_EXTENSIONS = ['.ief'];
    public const IMAGE_IEF_MEANING = 'IEF image files';
    public const IMAGE_IEF = [
        'type' => self::IMAGE_IEF_TYPE,
        'extensions' => self::IMAGE_IEF_EXTENSIONS,
        'meaning' => self::IMAGE_IEF_MEANING,
    ];

    /* image/jpeg */
    public const IMAGE_JPEG_TYPE = 'image/jpeg';
    public const IMAGE_JPEG_EXTENSIONS = ['.jpeg', '.jpg', '.jpe'];
    public const IMAGE_JPEG_MEANING = 'JPEG image files';
    public const IMAGE_JPEG = [
        'type' => self::IMAGE_JPEG_TYPE,
        'extensions' => self::IMAGE_JPEG_EXTENSIONS,
        'meaning' => self::IMAGE_JPEG_MEANING,
    ];

    /* image/png */
    public const IMAGE_PNG_TYPE = 'image/png';
    public const IMAGE_PNG_EXTENSIONS = ['.png'];
    public const IMAGE_PNG_MEANING = 'PNG image files';
    public const IMAGE_PNG = [
        'type' => self::IMAGE_PNG_TYPE,
        'extensions' => self::IMAGE_PNG_EXTENSIONS,
        'meaning' => self::IMAGE_PNG_MEANING,
    ];

    /* image/svg+xml */
    public const IMAGE_SVG_XML_TYPE = 'image/svg+xml';
    public const IMAGE_SVG_XML_EXTENSIONS = ['.svg'];
    public const IMAGE_SVG_XML_MEANING = 'SVG image files';
    public const IMAGE_SVG_XML = [
        'type' => self::IMAGE_SVG_XML_TYPE,
        'extensions' => self::IMAGE_SVG_XML_EXTENSIONS,
        'meaning' => self::IMAGE_SVG_XML_MEANING,
    ];

    /* image/tiff */
    public const IMAGE_TIFF_TYPE = 'image/tiff';
    public const IMAGE_TIFF_EXTENSIONS = ['.tiff', '.tif'];
    public const IMAGE_TIFF_MEANING = 'TIFF image files';
    public const IMAGE_TIFF = [
        'type' => self::IMAGE_TIFF_TYPE,
        'extensions' => self::IMAGE_TIFF_EXTENSIONS,
        'meaning' => self::IMAGE_TIFF_MEANING,
    ];

    /* image/vasa */
    public const IMAGE_VASA_TYPE = 'image/vasa';
    public const IMAGE_VASA_EXTENSIONS = ['.mcf'];
    public const IMAGE_VASA_MEANING = 'Vasa files';
    public const IMAGE_VASA = [
        'type' => self::IMAGE_VASA_TYPE,
        'extensions' => self::IMAGE_VASA_EXTENSIONS,
        'meaning' => self::IMAGE_VASA_MEANING,
    ];

    /* image/vnd.wap.wbmp */
    public const IMAGE_VND_WAP_WBMP_TYPE = 'image/vnd.wap.wbmp';
    public const IMAGE_VND_WAP_WBMP_EXTENSIONS = ['.wbmp'];
    public const IMAGE_VND_WAP_WBMP_MEANING = 'Bitmap files (WAP)';
    public const IMAGE_VND_WAP_WBMP = [
        'type' => self::IMAGE_VND_WAP_WBMP_TYPE,
        'extensions' => self::IMAGE_VND_WAP_WBMP_EXTENSIONS,
        'meaning' => self::IMAGE_VND_WAP_WBMP_MEANING,
    ];

    /* image/x-freehand */
    public const IMAGE_X_FREEHAND_TYPE = 'image/x-freehand';
    public const IMAGE_X_FREEHAND_EXTENSIONS = ['.fh4', '.fh5', '.fhc'];
    public const IMAGE_X_FREEHAND_MEANING = 'Freehand files';
    public const IMAGE_X_FREEHAND = [
        'type' => self::IMAGE_X_FREEHAND_TYPE,
        'extensions' => self::IMAGE_X_FREEHAND_EXTENSIONS,
        'meaning' => self::IMAGE_X_FREEHAND_MEANING,
    ];

    /* image/x-icon */
    public const IMAGE_X_ICON_TYPE = 'image/x-icon';
    public const IMAGE_X_ICON_EXTENSIONS = ['.ico'];
    public const IMAGE_X_ICON_MEANING = 'Icon files (e.g., favicons)';
    public const IMAGE_X_ICON = [
        'type' => self::IMAGE_X_ICON_TYPE,
        'extensions' => self::IMAGE_X_ICON_EXTENSIONS,
        'meaning' => self::IMAGE_X_ICON_MEANING,
    ];

    /* image/x-portable-anymap */
    public const IMAGE_X_PORTABLE_ANYMAP_TYPE = 'image/x-portable-anymap';
    public const IMAGE_X_PORTABLE_ANYMAP_EXTENSIONS = ['.pnm'];
    public const IMAGE_X_PORTABLE_ANYMAP_MEANING = 'PBM Anymap files';
    public const IMAGE_X_PORTABLE_ANYMAP = [
        'type' => self::IMAGE_X_PORTABLE_ANYMAP_TYPE,
        'extensions' => self::IMAGE_X_PORTABLE_ANYMAP_EXTENSIONS,
        'meaning' => self::IMAGE_X_PORTABLE_ANYMAP_MEANING,
    ];

    /* image/x-portable-bitmap */
    public const IMAGE_X_PORTABLE_BITMAP_TYPE = 'image/x-portable-bitmap';
    public const IMAGE_X_PORTABLE_BITMAP_EXTENSIONS = ['.pbm'];
    public const IMAGE_X_PORTABLE_BITMAP_MEANING = 'PBM Bitmap files';
    public const IMAGE_X_PORTABLE_BITMAP = [
        'type' => self::IMAGE_X_PORTABLE_BITMAP_TYPE,
        'extensions' => self::IMAGE_X_PORTABLE_BITMAP_EXTENSIONS,
        'meaning' => self::IMAGE_X_PORTABLE_BITMAP_MEANING,
    ];

    /* image/x-portable-graymap */
    public const IMAGE_X_PORTABLE_GRAYMAP_TYPE = 'image/x-portable-graymap';
    public const IMAGE_X_PORTABLE_GRAYMAP_EXTENSIONS = ['.pgm'];
    public const IMAGE_X_PORTABLE_GRAYMAP_MEANING = 'PBM Graymap files';
    public const IMAGE_X_PORTABLE_GRAYMAP = [
        'type' => self::IMAGE_X_PORTABLE_GRAYMAP_TYPE,
        'extensions' => self::IMAGE_X_PORTABLE_GRAYMAP_EXTENSIONS,
        'meaning' => self::IMAGE_X_PORTABLE_GRAYMAP_MEANING,
    ];

    /* image/x-portable-pixmap */
    public const IMAGE_X_PORTABLE_PIXMAP_TYPE = 'image/x-portable-pixmap';
    public const IMAGE_X_PORTABLE_PIXMAP_EXTENSIONS = ['.ppm'];
    public const IMAGE_X_PORTABLE_PIXMAP_MEANING = 'PBM Pixmap files';
    public const IMAGE_X_PORTABLE_PIXMAP = [
        'type' => self::IMAGE_X_PORTABLE_PIXMAP_TYPE,
        'extensions' => self::IMAGE_X_PORTABLE_PIXMAP_EXTENSIONS,
        'meaning' => self::IMAGE_X_PORTABLE_PIXMAP_MEANING,
    ];

    /* image/x-rgb */
    public const IMAGE_X_RGB_TYPE = 'image/x-rgb';
    public const IMAGE_X_RGB_EXTENSIONS = ['.rgb'];
    public const IMAGE_X_RGB_MEANING = 'RGB image files';
    public const IMAGE_X_RGB = [
        'type' => self::IMAGE_X_RGB_TYPE,
        'extensions' => self::IMAGE_X_RGB_EXTENSIONS,
        'meaning' => self::IMAGE_X_RGB_MEANING,
    ];

    /* image/x-windowdump */
    public const IMAGE_X_WINDOWDUMP_TYPE = 'image/x-windowdump';
    public const IMAGE_X_WINDOWDUMP_EXTENSIONS = ['.xwd'];
    public const IMAGE_X_WINDOWDUMP_MEANING = 'X-Windows dump files';
    public const IMAGE_X_WINDOWDUMP = [
        'type' => self::IMAGE_X_WINDOWDUMP_TYPE,
        'extensions' => self::IMAGE_X_WINDOWDUMP_EXTENSIONS,
        'meaning' => self::IMAGE_X_WINDOWDUMP_MEANING,
    ];

    /* image/x-xbitmap */
    public const IMAGE_X_XBITMAP_TYPE = 'image/x-xbitmap';
    public const IMAGE_X_XBITMAP_EXTENSIONS = ['.xbm'];
    public const IMAGE_X_XBITMAP_MEANING = 'XBM image files';
    public const IMAGE_X_XBITMAP = [
        'type' => self::IMAGE_X_XBITMAP_TYPE,
        'extensions' => self::IMAGE_X_XBITMAP_EXTENSIONS,
        'meaning' => self::IMAGE_X_XBITMAP_MEANING,
    ];

    /* image/x-xpixmap */
    public const IMAGE_X_XPIXMAP_TYPE = 'image/x-xpixmap';
    public const IMAGE_X_XPIXMAP_EXTENSIONS = ['.xpm'];
    public const IMAGE_X_XPIXMAP_MEANING = 'XPM image files';
    public const IMAGE_X_XPIXMAP = [
        'type' => self::IMAGE_X_XPIXMAP_TYPE,
        'extensions' => self::IMAGE_X_XPIXMAP_EXTENSIONS,
        'meaning' => self::IMAGE_X_XPIXMAP_MEANING,
    ];

    /* M - Message */

    /* message/external-body */
    public const MESSAGE_EXTERNAL_BODY_TYPE = 'message/external-body';
    public const MESSAGE_EXTERNAL_BODY_EXTENSIONS = [];
    public const MESSAGE_EXTERNAL_BODY_MEANING = 'Message with external content';
    public const MESSAGE_EXTERNAL_BODY = [
        'type' => self::MESSAGE_EXTERNAL_BODY_TYPE,
        'extensions' => self::MESSAGE_EXTERNAL_BODY_EXTENSIONS,
        'meaning' => self::MESSAGE_EXTERNAL_BODY_MEANING,
    ];

    /* message/http */
    public const MESSAGE_HTTP_TYPE = 'message/http';
    public const MESSAGE_HTTP_EXTENSIONS = [];
    public const MESSAGE_HTTP_MEANING = 'HTTP header message';
    public const MESSAGE_HTTP = [
        'type' => self::MESSAGE_HTTP_TYPE,
        'extensions' => self::MESSAGE_HTTP_EXTENSIONS,
        'meaning' => self::MESSAGE_HTTP_MEANING,
    ];

    /* message/news */
    public const MESSAGE_NEWS_TYPE = 'message/news';
    public const MESSAGE_NEWS_EXTENSIONS = [];
    public const MESSAGE_NEWS_MEANING = 'Newsgroup message';
    public const MESSAGE_NEWS = [
        'type' => self::MESSAGE_NEWS_TYPE,
        'extensions' => self::MESSAGE_NEWS_EXTENSIONS,
        'meaning' => self::MESSAGE_NEWS_MEANING,
    ];

    /* message/partial */
    public const MESSAGE_PARTIAL_TYPE = 'message/partial';
    public const MESSAGE_PARTIAL_EXTENSIONS = [];
    public const MESSAGE_PARTIAL_MEANING = 'Message with partial content';
    public const MESSAGE_PARTIAL = [
        'type' => self::MESSAGE_PARTIAL_TYPE,
        'extensions' => self::MESSAGE_PARTIAL_EXTENSIONS,
        'meaning' => self::MESSAGE_PARTIAL_MEANING,
    ];

    /* message/rfc822 */
    public const MESSAGE_RFC822_TYPE = 'message/rfc822';
    public const MESSAGE_RFC822_EXTENSIONS = [];
    public const MESSAGE_RFC822_MEANING = 'Message according to RFC 822';
    public const MESSAGE_RFC822 = [
        'type' => self::MESSAGE_RFC822_TYPE,
        'extensions' => self::MESSAGE_RFC822_EXTENSIONS,
        'meaning' => self::MESSAGE_RFC822_MEANING,
    ];

    /* M - Model */

    /* model/vrml */
    public const MODEL_VRML_TYPE = 'model/vrml';
    public const MODEL_VRML_EXTENSIONS = ['.wrl'];
    public const MODEL_VRML_MEANING = 'Virtual Reality Modeling Language (VRML) files';
    public const MODEL_VRML = [
        'type' => self::MODEL_VRML_TYPE,
        'extensions' => self::MODEL_VRML_EXTENSIONS,
        'meaning' => self::MODEL_VRML_MEANING,
    ];

    /* M - Multipart */

    /* multipart/alternative */
    public const MULTIPART_ALTERNATIVE_TYPE = 'multipart/alternative';
    public const MULTIPART_ALTERNATIVE_EXTENSIONS = [];
    public const MULTIPART_ALTERNATIVE_MEANING = 'Multipart data; each part is an equivalent alternative';
    public const MULTIPART_ALTERNATIVE = [
        'type' => self::MULTIPART_ALTERNATIVE_TYPE,
        'extensions' => self::MULTIPART_ALTERNATIVE_EXTENSIONS,
        'meaning' => self::MULTIPART_ALTERNATIVE_MEANING,
    ];

    /* multipart/byteranges */
    public const MULTIPART_BYTERANGES_TYPE = 'multipart/byteranges';
    public const MULTIPART_BYTERANGES_EXTENSIONS = [];
    public const MULTIPART_BYTERANGES_MEANING = 'Multipart data with byte ranges';
    public const MULTIPART_BYTERANGES = [
        'type' => self::MULTIPART_BYTERANGES_TYPE,
        'extensions' => self::MULTIPART_BYTERANGES_EXTENSIONS,
        'meaning' => self::MULTIPART_BYTERANGES_MEANING,
    ];

    /* multipart/digest */
    public const MULTIPART_DIGEST_TYPE = 'multipart/digest';
    public const MULTIPART_DIGEST_EXTENSIONS = [];
    public const MULTIPART_DIGEST_MEANING = 'Multipart data (selection)';
    public const MULTIPART_DIGEST = [
        'type' => self::MULTIPART_DIGEST_TYPE,
        'extensions' => self::MULTIPART_DIGEST_EXTENSIONS,
        'meaning' => self::MULTIPART_DIGEST_MEANING,
    ];

    /* multipart/encrypted */
    public const MULTIPART_ENCRYPTED_TYPE = 'multipart/encrypted';
    public const MULTIPART_ENCRYPTED_EXTENSIONS = [];
    public const MULTIPART_ENCRYPTED_MEANING = 'Encrypted multipart data';
    public const MULTIPART_ENCRYPTED = [
        'type' => self::MULTIPART_ENCRYPTED_TYPE,
        'extensions' => self::MULTIPART_ENCRYPTED_EXTENSIONS,
        'meaning' => self::MULTIPART_ENCRYPTED_MEANING,
    ];

    /* multipart/form-data */
    public const MULTIPART_FORM_DATA_TYPE = 'multipart/form-data';
    public const MULTIPART_FORM_DATA_EXTENSIONS = [];
    public const MULTIPART_FORM_DATA_MEANING = 'Multipart data from an HTML form (e.g., file upload)';
    public const MULTIPART_FORM_DATA = [
        'type' => self::MULTIPART_FORM_DATA_TYPE,
        'extensions' => self::MULTIPART_FORM_DATA_EXTENSIONS,
        'meaning' => self::MULTIPART_FORM_DATA_MEANING,
    ];

    /* multipart/mixed */
    public const MULTIPART_MIXED_TYPE = 'multipart/mixed';
    public const MULTIPART_MIXED_EXTENSIONS = [];
    public const MULTIPART_MIXED_MEANING = 'Multipart data with unrelated parts';
    public const MULTIPART_MIXED = [
        'type' => self::MULTIPART_MIXED_TYPE,
        'extensions' => self::MULTIPART_MIXED_EXTENSIONS,
        'meaning' => self::MULTIPART_MIXED_MEANING,
    ];

    /* multipart/parallel */
    public const MULTIPART_PARALLEL_TYPE = 'multipart/parallel';
    public const MULTIPART_PARALLEL_EXTENSIONS = [];
    public const MULTIPART_PARALLEL_MEANING = 'Multipart data sent in parallel';
    public const MULTIPART_PARALLEL = [
        'type' => self::MULTIPART_PARALLEL_TYPE,
        'extensions' => self::MULTIPART_PARALLEL_EXTENSIONS,
        'meaning' => self::MULTIPART_PARALLEL_MEANING,
    ];

    /* multipart/related */
    public const MULTIPART_RELATED_TYPE = 'multipart/related';
    public const MULTIPART_RELATED_EXTENSIONS = [];
    public const MULTIPART_RELATED_MEANING = 'Multipart data with interdependent parts';
    public const MULTIPART_RELATED = [
        'type' => self::MULTIPART_RELATED_TYPE,
        'extensions' => self::MULTIPART_RELATED_EXTENSIONS,
        'meaning' => self::MULTIPART_RELATED_MEANING,
    ];

    /* multipart/report */
    public const MULTIPART_REPORT_TYPE = 'multipart/report';
    public const MULTIPART_REPORT_EXTENSIONS = [];
    public const MULTIPART_REPORT_MEANING = 'Multipart data for reports';
    public const MULTIPART_REPORT = [
        'type' => self::MULTIPART_REPORT_TYPE,
        'extensions' => self::MULTIPART_REPORT_EXTENSIONS,
        'meaning' => self::MULTIPART_REPORT_MEANING,
    ];

    /* multipart/signed */
    public const MULTIPART_SIGNED_TYPE = 'multipart/signed';
    public const MULTIPART_SIGNED_EXTENSIONS = [];
    public const MULTIPART_SIGNED_MEANING = 'Multipart signed data';
    public const MULTIPART_SIGNED = [
        'type' => self::MULTIPART_SIGNED_TYPE,
        'extensions' => self::MULTIPART_SIGNED_EXTENSIONS,
        'meaning' => self::MULTIPART_SIGNED_MEANING,
    ];

    /* multipart/voice-message */
    public const MULTIPART_VOICE_MESSAGE_TYPE = 'multipart/voice-message';
    public const MULTIPART_VOICE_MESSAGE_EXTENSIONS = [];
    public const MULTIPART_VOICE_MESSAGE_MEANING = 'Multipart voice message data';
    public const MULTIPART_VOICE_MESSAGE = [
        'type' => self::MULTIPART_VOICE_MESSAGE_TYPE,
        'extensions' => self::MULTIPART_VOICE_MESSAGE_EXTENSIONS,
        'meaning' => self::MULTIPART_VOICE_MESSAGE_MEANING,
    ];

    /* T - Text */

    /* text/calendar */
    public const TEXT_CALENDAR_TYPE = 'text/calendar';
    public const TEXT_CALENDAR_EXTENSIONS = ['.ics'];
    public const TEXT_CALENDAR_MEANING = 'iCalendar files';
    public const TEXT_CALENDAR = [
        'type' => self::TEXT_CALENDAR_TYPE,
        'extensions' => self::TEXT_CALENDAR_EXTENSIONS,
        'meaning' => self::TEXT_CALENDAR_MEANING,
    ];

    /* text/csv */
    public const TEXT_CSV_TYPE = 'text/csv';
    public const TEXT_CSV_EXTENSIONS = ['.csv'];
    public const TEXT_CSV_MEANING = 'Comma-separated values files';
    public const TEXT_CSV = [
        'type' => self::TEXT_CSV_TYPE,
        'extensions' => self::TEXT_CSV_EXTENSIONS,
        'meaning' => self::TEXT_CSV_MEANING,
    ];

    /* text/css */
    public const TEXT_CSS_TYPE = 'text/css';
    public const TEXT_CSS_EXTENSIONS = ['.css'];
    public const TEXT_CSS_MEANING = 'CSS stylesheet files';
    public const TEXT_CSS = [
        'type' => self::TEXT_CSS_TYPE,
        'extensions' => self::TEXT_CSS_EXTENSIONS,
        'meaning' => self::TEXT_CSS_MEANING,
    ];

    /* text/html */
    public const TEXT_HTML_TYPE = 'text/html';
    public const TEXT_HTML_EXTENSIONS = ['.htm', '.html', '.shtml'];
    public const TEXT_HTML_MEANING = 'HTML files';
    public const TEXT_HTML = [
        'type' => self::TEXT_HTML_TYPE,
        'extensions' => self::TEXT_HTML_EXTENSIONS,
        'meaning' => self::TEXT_HTML_MEANING,
    ];

    /* text/javascript */
    public const TEXT_JAVASCRIPT_TYPE = 'text/javascript';
    public const TEXT_JAVASCRIPT_EXTENSIONS = ['.js'];
    public const TEXT_JAVASCRIPT_MEANING = 'JavaScript files';
    public const TEXT_JAVASCRIPT = [
        'type' => self::TEXT_JAVASCRIPT_TYPE,
        'extensions' => self::TEXT_JAVASCRIPT_EXTENSIONS,
        'meaning' => self::TEXT_JAVASCRIPT_MEANING,
    ];

    /* text/markdown */
    public const TEXT_MARKDOWN_TYPE = 'text/markdown';
    public const TEXT_MARKDOWN_EXTENSIONS = ['.md', '.markdown'];
    public const TEXT_MARKDOWN_MEANING = 'Markdown files';
    public const TEXT_MARKDOWN = [
        'type' => self::TEXT_MARKDOWN_TYPE,
        'extensions' => self::TEXT_MARKDOWN_EXTENSIONS,
        'meaning' => self::TEXT_MARKDOWN_MEANING,
    ];

    /* text/plain */
    public const TEXT_PLAIN_TYPE = 'text/plain';
    public const TEXT_PLAIN_EXTENSIONS = ['.txt'];
    public const TEXT_PLAIN_MEANING = 'Plain text files';
    public const TEXT_PLAIN = [
        'type' => self::TEXT_PLAIN_TYPE,
        'extensions' => self::TEXT_PLAIN_EXTENSIONS,
        'meaning' => self::TEXT_PLAIN_MEANING,
    ];

    /* text/richtext */
    public const TEXT_RICHTEXT_TYPE = 'text/richtext';
    public const TEXT_RICHTEXT_EXTENSIONS = ['.rtx'];
    public const TEXT_RICHTEXT_MEANING = 'Richtext files';
    public const TEXT_RICHTEXT = [
        'type' => self::TEXT_RICHTEXT_TYPE,
        'extensions' => self::TEXT_RICHTEXT_EXTENSIONS,
        'meaning' => self::TEXT_RICHTEXT_MEANING,
    ];

    /* text/rtf */
    public const TEXT_RTF_TYPE = 'text/rtf';
    public const TEXT_RTF_EXTENSIONS = ['.rtf'];
    public const TEXT_RTF_MEANING = 'RTF files';
    public const TEXT_RTF = [
        'type' => self::TEXT_RTF_TYPE,
        'extensions' => self::TEXT_RTF_EXTENSIONS,
        'meaning' => self::TEXT_RTF_MEANING,
    ];

    /* text/tab-separated-values */
    public const TEXT_TSV_TYPE = 'text/tab-separated-values';
    public const TEXT_TSV_EXTENSIONS = ['.tsv'];
    public const TEXT_TSV_MEANING = 'Tab-separated values files';
    public const TEXT_TSV = [
        'type' => self::TEXT_TSV_TYPE,
        'extensions' => self::TEXT_TSV_EXTENSIONS,
        'meaning' => self::TEXT_TSV_MEANING,
    ];

    /* text/vnd.wap.wml */
    public const TEXT_WML_TYPE = 'text/vnd.wap.wml';
    public const TEXT_WML_EXTENSIONS = ['.wml'];
    public const TEXT_WML_MEANING = 'WML files (WAP)';
    public const TEXT_WML = [
        'type' => self::TEXT_WML_TYPE,
        'extensions' => self::TEXT_WML_EXTENSIONS,
        'meaning' => self::TEXT_WML_MEANING,
    ];

    /* application/vnd.wap.wmlc */
    public const APPLICATION_VND_WAP_WMLC_TYPE = 'application/vnd.wap.wmlc';
    public const APPLICATION_VND_WAP_WMLC_EXTENSIONS = ['.wmlc'];
    public const APPLICATION_VND_WAP_WMLC_MEANING = 'WMLC files (WAP)';
    public const APPLICATION_VND_WAP_WMLC = [
        'type' => self::APPLICATION_VND_WAP_WMLC_TYPE,
        'extensions' => self::APPLICATION_VND_WAP_WMLC_EXTENSIONS,
        'meaning' => self::APPLICATION_VND_WAP_WMLC_MEANING,
    ];

    /* text/vnd.wap.wmlscript */
    public const TEXT_VND_WAP_WMLSCRIPT_TYPE = 'text/vnd.wap.wmlscript';
    public const TEXT_VND_WAP_WMLSCRIPT_EXTENSIONS = ['.wmls'];
    public const TEXT_VND_WAP_WMLSCRIPT_MEANING = 'WML Script files (WAP)';
    public const TEXT_VND_WAP_WMLSCRIPT = [
        'type' => self::TEXT_VND_WAP_WMLSCRIPT_TYPE,
        'extensions' => self::TEXT_VND_WAP_WMLSCRIPT_EXTENSIONS,
        'meaning' => self::TEXT_VND_WAP_WMLSCRIPT_MEANING,
    ];

    /* application/vnd.wap.wmlscriptc */
    public const APPLICATION_VND_WAP_WMLSCRIPTC_TYPE = 'application/vnd.wap.wmlscriptc';
    public const APPLICATION_VND_WAP_WMLSCRIPTC_EXTENSIONS = ['.wmlsc'];
    public const APPLICATION_VND_WAP_WMLSCRIPTC_MEANING = 'WML Script-C files (WAP)';
    public const APPLICATION_VND_WAP_WMLSCRIPTC = [
        'type' => self::APPLICATION_VND_WAP_WMLSCRIPTC_TYPE,
        'extensions' => self::APPLICATION_VND_WAP_WMLSCRIPTC_EXTENSIONS,
        'meaning' => self::APPLICATION_VND_WAP_WMLSCRIPTC_MEANING,
    ];

    /* text/xml */
    public const TEXT_XML_TYPE = 'text/xml';
    public const TEXT_XML_EXTENSIONS = ['.xml'];
    public const TEXT_XML_MEANING = 'XML files';
    public const TEXT_XML = [
        'type' => self::TEXT_XML_TYPE,
        'extensions' => self::TEXT_XML_EXTENSIONS,
        'meaning' => self::TEXT_XML_MEANING,
    ];

    /* text/xml-external-parsed-entity */
    public const TEXT_XML_EXTERNAL_PARSED_ENTITY_TYPE = 'text/xml-external-parsed-entity';
    public const TEXT_XML_EXTERNAL_PARSED_ENTITY_EXTENSIONS = [];
    public const TEXT_XML_EXTERNAL_PARSED_ENTITY_MEANING = 'Externally parsed XML files';
    public const TEXT_XML_EXTERNAL_PARSED_ENTITY = [
        'type' => self::TEXT_XML_EXTERNAL_PARSED_ENTITY_TYPE,
        'extensions' => self::TEXT_XML_EXTERNAL_PARSED_ENTITY_EXTENSIONS,
        'meaning' => self::TEXT_XML_EXTERNAL_PARSED_ENTITY_MEANING,
    ];

    /* text/x-c++ */
    public const TEXT_X_CPP_TYPE = 'text/x-c++';
    public const TEXT_X_CPP_EXTENSIONS = [];
    public const TEXT_X_CPP_MEANING = 'x-c++ files';
    public const TEXT_X_CPP = [
        'type' => self::TEXT_X_CPP_TYPE,
        'extensions' => self::TEXT_X_CPP_EXTENSIONS,
        'meaning' => self::TEXT_X_CPP_MEANING,
    ];

    /* text/x-setext */
    public const TEXT_X_SETEXT_TYPE = 'text/x-setext';
    public const TEXT_X_SETEXT_EXTENSIONS = ['.etx'];
    public const TEXT_X_SETEXT_MEANING = 'SeText files';
    public const TEXT_X_SETEXT = [
        'type' => self::TEXT_X_SETEXT_TYPE,
        'extensions' => self::TEXT_X_SETEXT_EXTENSIONS,
        'meaning' => self::TEXT_X_SETEXT_MEANING,
    ];

    /* text/x-sgml */
    public const TEXT_X_SGML_TYPE = 'text/x-sgml';
    public const TEXT_X_SGML_EXTENSIONS = ['.sgm', '.sgml'];
    public const TEXT_X_SGML_MEANING = 'SGML files';
    public const TEXT_X_SGML = [
        'type' => self::TEXT_X_SGML_TYPE,
        'extensions' => self::TEXT_X_SGML_EXTENSIONS,
        'meaning' => self::TEXT_X_SGML_MEANING,
    ];

    /* text/x-speech */
    public const TEXT_X_SPEECH_TYPE = 'text/x-speech';
    public const TEXT_X_SPEECH_EXTENSIONS = ['.talk', '.spc'];
    public const TEXT_X_SPEECH_MEANING = 'Speech files';
    public const TEXT_X_SPEECH = [
        'type' => self::TEXT_X_SPEECH_TYPE,
        'extensions' => self::TEXT_X_SPEECH_EXTENSIONS,
        'meaning' => self::TEXT_X_SPEECH_MEANING,
    ];


    /* V - Video */

    /* video/mpeg */
    public const VIDEO_MPEG_TYPE = 'video/mpeg';
    public const VIDEO_MPEG_EXTENSIONS = ['.mpeg', '.mpg', '.mpe'];
    public const VIDEO_MPEG_MEANING = 'MPEG video files';
    public const VIDEO_MPEG = [
        'type' => self::VIDEO_MPEG_TYPE,
        'extensions' => self::VIDEO_MPEG_EXTENSIONS,
        'meaning' => self::VIDEO_MPEG_MEANING,
    ];

    /* video/mp4 */
    public const VIDEO_MP4_TYPE = 'video/mp4';
    public const VIDEO_MP4_EXTENSIONS = ['.mp4'];
    public const VIDEO_MP4_MEANING = 'MP4 video files';
    public const VIDEO_MP4 = [
        'type' => self::VIDEO_MP4_TYPE,
        'extensions' => self::VIDEO_MP4_EXTENSIONS,
        'meaning' => self::VIDEO_MP4_MEANING,
    ];

    /* video/ogg */
    public const VIDEO_OGG_TYPE = 'video/ogg';
    public const VIDEO_OGG_EXTENSIONS = ['.ogg', '.ogv'];
    public const VIDEO_OGG_MEANING = 'OGG video files';
    public const VIDEO_OGG = [
        'type' => self::VIDEO_OGG_TYPE,
        'extensions' => self::VIDEO_OGG_EXTENSIONS,
        'meaning' => self::VIDEO_OGG_MEANING,
    ];

    /* video/quicktime */
    public const VIDEO_QUICKTIME_TYPE = 'video/quicktime';
    public const VIDEO_QUICKTIME_EXTENSIONS = ['.qt', '.mov'];
    public const VIDEO_QUICKTIME_MEANING = 'QuickTime video files';
    public const VIDEO_QUICKTIME = [
        'type' => self::VIDEO_QUICKTIME_TYPE,
        'extensions' => self::VIDEO_QUICKTIME_EXTENSIONS,
        'meaning' => self::VIDEO_QUICKTIME_MEANING,
    ];

    /* video/vnd.vivo */
    public const VIDEO_VND_VIVO_TYPE = 'video/vnd.vivo';
    public const VIDEO_VND_VIVO_EXTENSIONS = ['.viv', '.vivo'];
    public const VIDEO_VND_VIVO_MEANING = 'Vivo video files';
    public const VIDEO_VND_VIVO = [
        'type' => self::VIDEO_VND_VIVO_TYPE,
        'extensions' => self::VIDEO_VND_VIVO_EXTENSIONS,
        'meaning' => self::VIDEO_VND_VIVO_MEANING,
    ];

    /* video/webm */
    public const VIDEO_WEBM_TYPE = 'video/webm';
    public const VIDEO_WEBM_EXTENSIONS = ['.webm'];
    public const VIDEO_WEBM_MEANING = 'WebM video files';
    public const VIDEO_WEBM = [
        'type' => self::VIDEO_WEBM_TYPE,
        'extensions' => self::VIDEO_WEBM_EXTENSIONS,
        'meaning' => self::VIDEO_WEBM_MEANING,
    ];

    /* video/x-msvideo */
    public const VIDEO_X_MSVIDEO_TYPE = 'video/x-msvideo';
    public const VIDEO_X_MSVIDEO_EXTENSIONS = ['.avi'];
    public const VIDEO_X_MSVIDEO_MEANING = 'Microsoft AVI video files';
    public const VIDEO_X_MSVIDEO = [
        'type' => self::VIDEO_X_MSVIDEO_TYPE,
        'extensions' => self::VIDEO_X_MSVIDEO_EXTENSIONS,
        'meaning' => self::VIDEO_X_MSVIDEO_MEANING,
    ];

    /* video/x-sgi-movie */
    public const VIDEO_X_SGI_MOVIE_TYPE = 'video/x-sgi-movie';
    public const VIDEO_X_SGI_MOVIE_EXTENSIONS = ['.movie'];
    public const VIDEO_X_SGI_MOVIE_MEANING = 'SGI movie files';
    public const VIDEO_X_SGI_MOVIE = [
        'type' => self::VIDEO_X_SGI_MOVIE_TYPE,
        'extensions' => self::VIDEO_X_SGI_MOVIE_EXTENSIONS,
        'meaning' => self::VIDEO_X_SGI_MOVIE_MEANING,
    ];

    /* video/3gpp */
    public const VIDEO_3GPP_TYPE = 'video/3gpp';
    public const VIDEO_3GPP_EXTENSIONS = ['.3gp'];
    public const VIDEO_3GPP_MEANING = '3GP mobile video files';
    public const VIDEO_3GPP = [
        'type' => self::VIDEO_3GPP_TYPE,
        'extensions' => self::VIDEO_3GPP_EXTENSIONS,
        'meaning' => self::VIDEO_3GPP_MEANING,
    ];

    /* W - Workbook */

    /* workbook/formulaone */
    public const WORKBOOK_FORMULAONE_TYPE = 'workbook/formulaone';
    public const WORKBOOK_FORMULAONE_EXTENSIONS = ['.vts', '.vtts'];
    public const WORKBOOK_FORMULAONE_MEANING = 'FormulaOne files';
    public const WORKBOOK_FORMULAONE = [
        'type' => self::WORKBOOK_FORMULAONE_TYPE,
        'extensions' => self::WORKBOOK_FORMULAONE_EXTENSIONS,
        'meaning' => self::WORKBOOK_FORMULAONE_MEANING,
    ];

    /* X - X-World */

    /* x-world/x-3dmf */
    public const X_WORLD_X_3DMF_TYPE = 'x-world/x-3dmf';
    public const X_WORLD_X_3DMF_EXTENSIONS = ['.mf', '.m', '.qd3d', '.qd3'];
    public const X_WORLD_X_3DMF_MEANING = '3DMF files';
    public const X_WORLD_X_3DMF = [
        'type' => self::X_WORLD_X_3DMF_TYPE,
        'extensions' => self::X_WORLD_X_3DMF_EXTENSIONS,
        'meaning' => self::X_WORLD_X_3DMF_MEANING,
    ];

    /* x-world/x-vrml */
    public const X_WORLD_X_VRML_TYPE = 'x-world/x-vrml';
    public const X_WORLD_X_VRML_EXTENSIONS = ['.wrl'];
    public const X_WORLD_X_VRML_MEANING = 'Visualization of virtual worlds (VRML) [deprecated, use model/vrml]';
    public const X_WORLD_X_VRML = [
        'type' => self::X_WORLD_X_VRML_TYPE,
        'extensions' => self::X_WORLD_X_VRML_EXTENSIONS,
        'meaning' => self::X_WORLD_X_VRML_MEANING,
    ];



    /* Group: A - Application */
    public const GROUP_APPLICATION = 'application/';

    /* Group: A - Audio */
    public const GROUP_AUDIO = 'audio/';

    /* Group: D - Drawing */
    public const GROUP_DRAWING = 'drawing';

    /* Group: I - Image */
    public const GROUP_IMAGE = 'image/';

    /* Group: M - Message */
    public const GROUP_MESSAGE = 'message/';

    /* Group: M - Model */
    public const GROUP_MODEL = 'model/';

    /* Group: M - Multipart */
    public const GROUP_MULTIPART = 'multipart/';

    /* Group: T - Text */
    public const GROUP_TEXT = 'text/';

    /* Group: V - Video */

    /* video/mpeg */
    public const GROUP_VIDEO = 'video/';

    /* Group: W - Workbook */
    public const GROUP_WORKBOOK = 'workbook/';

    /* Group: X - X-World */
    public const GROUP_X_WORLD = 'x-world/';



    /* Supported. */

    public const SUPPORTED = [

        /* A - Application */

        /* application/acad */
        self::APPLICATION_ACAD_TYPE => self::APPLICATION_ACAD,
        /* application/applefile */
        self::APPLICATION_APPLEFILE_TYPE => self::APPLICATION_APPLEFILE,
        /* application/astound */
        self::APPLICATION_ASTOUND_TYPE => self::APPLICATION_ASTOUND,
        /* application/dsptype */
        self::APPLICATION_DSPTYPE_TYPE => self::APPLICATION_DSPTYPE,
        /* application/dxf */
        self::APPLICATION_DXF_TYPE => self::APPLICATION_DXF,
        /* application/force-download */
        self::APPLICATION_FORCE_DOWNLOAD_TYPE => self::APPLICATION_FORCE_DOWNLOAD,
        /* application/futuresplash */
        self::APPLICATION_FUTURESPLASH_TYPE => self::APPLICATION_FUTURESPLASH,
        /* application/gzip */
        self::APPLICATION_GZIP_TYPE => self::APPLICATION_GZIP,
        /* application/javascript */
        self::APPLICATION_JAVASCRIPT_TYPE => self::APPLICATION_JAVASCRIPT,
        /* application/json */
        self::APPLICATION_JSON_TYPE => self::APPLICATION_JSON,
        /* application/listenup */
        self::APPLICATION_LISTENUP_TYPE => self::APPLICATION_LISTENUP,
        /* application/mac-binhex40 */
        self::APPLICATION_MAC_BINHEX40_TYPE => self::APPLICATION_MAC_BINHEX40,
        /* application/msexcel */
        self::APPLICATION_MSEXCEL_TYPE => self::APPLICATION_MSEXCEL,
        /* application/mshelp */
        self::APPLICATION_MSHELP_TYPE => self::APPLICATION_MSHELP,
        /* application/mspowerpoint */
        self::APPLICATION_MSPOWERPOINT_TYPE => self::APPLICATION_MSPOWERPOINT,
        /* application/msword */
        self::APPLICATION_MSWORD_TYPE => self::APPLICATION_MSWORD,
        /* application/octet-stream */
        self::APPLICATION_OCTET_STREAM_TYPE => self::APPLICATION_OCTET_STREAM,
        /* application/oda */
        self::APPLICATION_ODA_TYPE => self::APPLICATION_ODA,
        /* application/pdf */
        self::APPLICATION_PDF_TYPE => self::APPLICATION_PDF,
        /* application/postscript */
        self::APPLICATION_POSTSCRIPT_TYPE => self::APPLICATION_POSTSCRIPT,
        /* application/rtc */
        self::APPLICATION_RTC_TYPE => self::APPLICATION_RTC,
        /* application/rtf */
        self::APPLICATION_RTF_TYPE => self::APPLICATION_RTF,
        /* application/studiom */
        self::APPLICATION_STUDIOM_TYPE => self::APPLICATION_STUDIOM,
        /* application/toolbook */
        self::APPLICATION_TOOLBOOK_TYPE => self::APPLICATION_TOOLBOOK,
        /* application/vnd.oasis.opendocument.chart */
        self::APPLICATION_ODC_TYPE => self::APPLICATION_ODC,
        /* application/vnd.oasis.opendocument.formula */
        self::APPLICATION_ODF_TYPE => self::APPLICATION_ODF,
        /* application/vnd.oasis.opendocument.graphics */
        self::APPLICATION_ODG_TYPE => self::APPLICATION_ODG,
        /* application/vnd.oasis.opendocument.image */
        self::APPLICATION_ODI_TYPE => self::APPLICATION_ODI,
        /* application/vnd.oasis.opendocument.presentation */
        self::APPLICATION_ODP_TYPE => self::APPLICATION_ODP,
        /* application/vnd.oasis.opendocument.spreadsheet */
        self::APPLICATION_ODS_TYPE => self::APPLICATION_ODS,
        /* application/vnd.oasis.opendocument.text */
        self::APPLICATION_ODT_TYPE => self::APPLICATION_ODT,
        /* application/vnd.oasis.opendocument.text-master */
        self::APPLICATION_ODM_TYPE => self::APPLICATION_ODM,
        /* application/vocaltec-media-desc */
        self::APPLICATION_VMD_TYPE => self::APPLICATION_VMD,
        /* application/vocaltec-media-file */
        self::APPLICATION_VMF_TYPE => self::APPLICATION_VMF,
        /* application/vnd.openxmlformats-officedocument.presentationml.presentation */
        self::APPLICATION_PPTX_TYPE => self::APPLICATION_PPTX,
        /* application/vnd.openxmlformats-officedocument.spreadsheetml.sheet */
        self::APPLICATION_XLSX_TYPE => self::APPLICATION_XLSX,
        /* application/vnd.openxmlformats-officedocument.wordprocessingml.document */
        self::APPLICATION_DOCX_TYPE => self::APPLICATION_DOCX,
        /* application/xhtml+xml */
        self::APPLICATION_XHTML_TYPE => self::APPLICATION_XHTML,
        /* application/xml */
        self::APPLICATION_XML_TYPE => self::APPLICATION_XML,
        /* application/x-bcpio */
        self::APPLICATION_X_BCPIO_TYPE => self::APPLICATION_X_BCPIO,
        /* application/x-compress */
        self::APPLICATION_X_COMPRESS_TYPE => self::APPLICATION_X_COMPRESS,
        /* application/x-cpio */
        self::APPLICATION_X_CPIO_TYPE => self::APPLICATION_X_CPIO,
        /* application/x-csh */
        self::APPLICATION_X_CSH_TYPE => self::APPLICATION_X_CSH,
        /* application/x-director */
        self::APPLICATION_X_DIRECTOR_TYPE => self::APPLICATION_X_DIRECTOR,
        /* application/x-dvi */
        self::APPLICATION_X_DVI_TYPE => self::APPLICATION_X_DVI,
        /* application/x-envoy */
        self::APPLICATION_EVY_TYPE => self::APPLICATION_EVY,
        /* application/x-gtar */
        self::APPLICATION_GTAR_TYPE => self::APPLICATION_GTAR,
        /* application/x-hdf */
        self::APPLICATION_HDF_TYPE => self::APPLICATION_HDF,
        /* application/x-httpd-php */
        self::APPLICATION_X_HTTPD_PHP_TYPE => self::APPLICATION_X_HTTPD_PHP,
        /* application/x-latex */
        self::APPLICATION_X_LATEX_TYPE => self::APPLICATION_X_LATEX,
        /* application/x-macbinary */
        self::APPLICATION_X_MACBINARY_TYPE => self::APPLICATION_X_MACBINARY,
        /* application/x-mif */
        self::APPLICATION_X_MIF_TYPE => self::APPLICATION_X_MIF,
        /* application/x-netcdf */
        self::APPLICATION_X_NETCDF_TYPE => self::APPLICATION_X_NETCDF,
        /* application/x-nschat */
        self::APPLICATION_X_NSCHAT_TYPE => self::APPLICATION_X_NSCHAT,
        /* application/x-sh */
        self::APPLICATION_X_SH_TYPE => self::APPLICATION_X_SH,
        /* application/x-shar */
        self::APPLICATION_X_SHAR_TYPE => self::APPLICATION_X_SHAR,
        /* application/x-shockwave-flash */
        self::APPLICATION_X_SHOCKWAVE_FLASH_TYPE => self::APPLICATION_X_SHOCKWAVE_FLASH,
        /* application/x-sprite */
        self::APPLICATION_X_SPRITE_TYPE => self::APPLICATION_X_SPRITE,
        /* application/x-stuffit */
        self::APPLICATION_X_STUFFIT_TYPE => self::APPLICATION_X_STUFFIT,
        /* application/x-supercard */
        self::APPLICATION_X_SUPERCARD_TYPE => self::APPLICATION_X_SUPERCARD,
        /* application/x-sv4cpio */
        self::APPLICATION_X_SV4CPIO_TYPE => self::APPLICATION_X_SV4CPIO,
        /* application/x-sv4crc */
        self::APPLICATION_X_SV4CRC_TYPE => self::APPLICATION_X_SV4CRC,
        /* application/x-tar */
        self::APPLICATION_X_TAR_TYPE => self::APPLICATION_X_TAR,
        /* application/x-tcl */
        self::APPLICATION_X_TCL_TYPE => self::APPLICATION_X_TCL,
        /* application/x-tex */
        self::APPLICATION_X_TEX_TYPE => self::APPLICATION_X_TEX,
        /* application/x-texinfo */
        self::APPLICATION_X_TEXINFO_TYPE => self::APPLICATION_X_TEXINFO,
        /* application/x-troff */
        self::APPLICATION_X_TROFF_TYPE => self::APPLICATION_X_TROFF,
        /* application/x-troff-man */
        self::APPLICATION_X_TROFF_MAN_TYPE => self::APPLICATION_X_TROFF_MAN,
        /* application/x-troff-me */
        self::APPLICATION_X_TROFF_ME_TYPE => self::APPLICATION_X_TROFF_ME,
        /* application/x-troff-ms */
        self::APPLICATION_X_TROFF_MS_TYPE => self::APPLICATION_X_TROFF_MS,
        /* application/x-ustar */
        self::APPLICATION_X_USTAR_TYPE => self::APPLICATION_X_USTAR,
        /* application/x-wais-source */
        self::APPLICATION_X_WAIS_SOURCE_TYPE => self::APPLICATION_X_WAIS_SOURCE,
        /* application/x-www-form-urlencoded */
        self::APPLICATION_X_WWW_FORM_URLENCODED_TYPE => self::APPLICATION_X_WWW_FORM_URLENCODED,
        /* application/zip */
        self::APPLICATION_ZIP_TYPE => self::APPLICATION_ZIP,

        /* A - Audio */

        /* audio/basic */
        self::AUDIO_BASIC_TYPE => self::AUDIO_BASIC,
        /* audio/echospeech */
        self::AUDIO_ECHOSPEECH_TYPE => self::AUDIO_ECHOSPEECH,
        /* audio/mpeg */
        self::AUDIO_MPEG_TYPE => self::AUDIO_MPEG,
        /* audio/mp4 */
        self::AUDIO_MP4_TYPE => self::AUDIO_MP4,
        /* audio/ogg */
        self::AUDIO_OGG_TYPE => self::AUDIO_OGG,
        /* audio/opus */
        self::AUDIO_OPUS_TYPE => self::AUDIO_OPUS,
        /* audio/tsplayer */
        self::AUDIO_TSPLAYER_TYPE => self::AUDIO_TSPLAYER,
        /* audio/voxware */
        self::AUDIO_VOXWARE_TYPE => self::AUDIO_VOXWARE,
        /* audio/wav */
        self::AUDIO_WAV_TYPE => self::AUDIO_WAV,
        /* audio/x-aiff */
        self::AUDIO_X_AIFF_TYPE => self::AUDIO_X_AIFF,
        /* audio/x-dspeech */
        self::AUDIO_X_DSPEECH_TYPE => self::AUDIO_X_DSPEECH,
        /* audio/x-midi */
        self::AUDIO_X_MIDI_TYPE => self::AUDIO_X_MIDI,
        /* audio/x-mpeg */
        self::AUDIO_X_MPEG_TYPE => self::AUDIO_X_MPEG,
        /* audio/x-pn-realaudio */
        self::AUDIO_X_PN_REALAUDIO_TYPE => self::AUDIO_X_PN_REALAUDIO,
        /* audio/x-pn-realaudio-plugin */
        self::AUDIO_X_PN_REALAUDIO_PLUGIN_TYPE => self::AUDIO_X_PN_REALAUDIO_PLUGIN,
        /* audio/x-qt-stream */
        self::AUDIO_X_QT_STREAM_TYPE => self::AUDIO_X_QT_STREAM,

        /* D - Drawing */

        /* drawing/x-dwf */
        self::DRAWING_X_DWF_TYPE => self::DRAWING_X_DWF,

        /* I - Image */

        /* image/bmp */
        self::IMAGE_BMP_TYPE => self::IMAGE_BMP,
        /* image/x-bmp */
        self::IMAGE_X_BMP_TYPE => self::IMAGE_X_BMP,
        /* image/x-ms-bmp */
        self::IMAGE_X_MS_BMP_TYPE => self::IMAGE_X_MS_BMP,
        /* image/cis-cod */
        self::IMAGE_CIS_COD_TYPE => self::IMAGE_CIS_COD,
        /* image/cmu-raster */
        self::IMAGE_CMU_RASTER_TYPE => self::IMAGE_CMU_RASTER,
        /* image/fif */
        self::IMAGE_FIF_TYPE => self::IMAGE_FIF,
        /* image/gif */
        self::IMAGE_GIF_TYPE => self::IMAGE_GIF,
        /* image/ief */
        self::IMAGE_IEF_TYPE => self::IMAGE_IEF,
        /* image/jpeg */
        self::IMAGE_JPEG_TYPE => self::IMAGE_JPEG,
        /* image/png */
        self::IMAGE_PNG_TYPE => self::IMAGE_PNG,
        /* image/svg+xml */
        self::IMAGE_SVG_XML_TYPE => self::IMAGE_SVG_XML,
        /* image/tiff */
        self::IMAGE_TIFF_TYPE => self::IMAGE_TIFF,
        /* image/vasa */
        self::IMAGE_VASA_TYPE => self::IMAGE_VASA,
        /* image/vnd.wap.wbmp */
        self::IMAGE_VND_WAP_WBMP_TYPE => self::IMAGE_VND_WAP_WBMP,
        /* image/x-freehand */
        self::IMAGE_X_FREEHAND_TYPE => self::IMAGE_X_FREEHAND,
        /* image/x-icon */
        self::IMAGE_X_ICON_TYPE => self::IMAGE_X_ICON,
        /* image/x-portable-anymap */
        self::IMAGE_X_PORTABLE_ANYMAP_TYPE => self::IMAGE_X_PORTABLE_ANYMAP,
        /* image/x-portable-bitmap */
        self::IMAGE_X_PORTABLE_BITMAP_TYPE => self::IMAGE_X_PORTABLE_BITMAP,
        /* image/x-portable-graymap */
        self::IMAGE_X_PORTABLE_GRAYMAP_TYPE => self::IMAGE_X_PORTABLE_GRAYMAP,
        /* image/x-portable-pixmap */
        self::IMAGE_X_PORTABLE_PIXMAP_TYPE => self::IMAGE_X_PORTABLE_PIXMAP,
        /* image/x-rgb */
        self::IMAGE_X_RGB_TYPE => self::IMAGE_X_RGB,
        /* image/x-windowdump */
        self::IMAGE_X_WINDOWDUMP_TYPE => self::IMAGE_X_WINDOWDUMP,
        /* image/x-xbitmap */
        self::IMAGE_X_XBITMAP_TYPE => self::IMAGE_X_XBITMAP,
        /* image/x-xpixmap */
        self::IMAGE_X_XPIXMAP_TYPE => self::IMAGE_X_XPIXMAP,

        /* M - Message */

        /* message/external-body */
        self::MESSAGE_EXTERNAL_BODY_TYPE => self::MESSAGE_EXTERNAL_BODY,
        /* message/http */
        self::MESSAGE_HTTP_TYPE => self::MESSAGE_HTTP,
        /* message/news */
        self::MESSAGE_NEWS_TYPE => self::MESSAGE_NEWS,
        /* message/partial */
        self::MESSAGE_PARTIAL_TYPE => self::MESSAGE_PARTIAL,
        /* message/rfc822 */
        self::MESSAGE_RFC822_TYPE => self::MESSAGE_RFC822,

        /* M - Model */

        /* model/vrml */
        self::MODEL_VRML_TYPE => self::MODEL_VRML,

        /* M - Multipart */

        /* multipart/alternative */
        self::MULTIPART_ALTERNATIVE_TYPE => self::MULTIPART_ALTERNATIVE,
        /* multipart/byteranges */
        self::MULTIPART_BYTERANGES_TYPE => self::MULTIPART_BYTERANGES,
        /* multipart/digest */
        self::MULTIPART_DIGEST_TYPE => self::MULTIPART_DIGEST,
        /* multipart/encrypted */
        self::MULTIPART_ENCRYPTED_TYPE => self::MULTIPART_ENCRYPTED,
        /* multipart/form-data */
        self::MULTIPART_FORM_DATA_TYPE => self::MULTIPART_FORM_DATA,
        /* multipart/mixed */
        self::MULTIPART_MIXED_TYPE => self::MULTIPART_MIXED,
        /* multipart/parallel */
        self::MULTIPART_PARALLEL_TYPE => self::MULTIPART_PARALLEL,
        /* multipart/related */
        self::MULTIPART_RELATED_TYPE => self::MULTIPART_RELATED,
        /* multipart/report */
        self::MULTIPART_REPORT_TYPE => self::MULTIPART_REPORT,
        /* multipart/signed */
        self::MULTIPART_SIGNED_TYPE => self::MULTIPART_SIGNED,
        /* multipart/voice-message */
        self::MULTIPART_VOICE_MESSAGE_TYPE => self::MULTIPART_VOICE_MESSAGE,

        /* T - Text */

        /* text/calendar */
        self::TEXT_CALENDAR_TYPE => self::TEXT_CALENDAR,
        /* text/csv */
        self::TEXT_CSV_TYPE => self::TEXT_CSV,
        /* text/css */
        self::TEXT_CSS_TYPE => self::TEXT_CSS,
        /* text/html */
        self::TEXT_HTML_TYPE => self::TEXT_HTML,
        /* text/javascript */
        self::TEXT_JAVASCRIPT_TYPE => self::TEXT_JAVASCRIPT,
        /* text/markdown */
        self::TEXT_MARKDOWN_TYPE => self::TEXT_MARKDOWN,
        /* text/plain */
        self::TEXT_PLAIN_TYPE => self::TEXT_PLAIN,
        /* text/richtext */
        self::TEXT_RICHTEXT_TYPE => self::TEXT_RICHTEXT,
        /* text/rtf */
        self::TEXT_RTF_TYPE => self::TEXT_RTF,
        /* text/tab-separated-values */
        self::TEXT_TSV_TYPE => self::TEXT_TSV,
        /* text/vnd.wap.wml */
        self::TEXT_WML_TYPE => self::TEXT_WML,
        /* application/vnd.wap.wmlc */
        self::APPLICATION_VND_WAP_WMLC_TYPE => self::APPLICATION_VND_WAP_WMLC,
        /* text/vnd.wap.wmlscript */
        self::TEXT_VND_WAP_WMLSCRIPT_TYPE => self::TEXT_VND_WAP_WMLSCRIPT,
        /* application/vnd.wap.wmlscriptc */
        self::APPLICATION_VND_WAP_WMLSCRIPTC_TYPE => self::APPLICATION_VND_WAP_WMLSCRIPTC,
        /* text/xml */
        self::TEXT_XML_TYPE => self::TEXT_XML,
        /* text/xml-external-parsed-entity */
        self::TEXT_XML_EXTERNAL_PARSED_ENTITY_TYPE => self::TEXT_XML_EXTERNAL_PARSED_ENTITY,
        /* text/x-setext */
        self::TEXT_X_SETEXT_TYPE => self::TEXT_X_SETEXT,
        /* text/x-sgml */
        self::TEXT_X_SGML_TYPE => self::TEXT_X_SGML,
        /* text/x-speech */
        self::TEXT_X_SPEECH_TYPE => self::TEXT_X_SPEECH,

        /* V - Video */

        /* video/mpeg */
        self::VIDEO_MPEG_TYPE => self::VIDEO_MPEG,
        /* video/mp4 */
        self::VIDEO_MP4_TYPE => self::VIDEO_MP4,
        /* video/ogg */
        self::VIDEO_OGG_TYPE => self::VIDEO_OGG,
        /* video/quicktime */
        self::VIDEO_QUICKTIME_TYPE => self::VIDEO_QUICKTIME,
        /* video/vnd.vivo */
        self::VIDEO_VND_VIVO_TYPE => self::VIDEO_VND_VIVO,
        /* video/webm */
        self::VIDEO_WEBM_TYPE => self::VIDEO_WEBM,
        /* video/x-msvideo */
        self::VIDEO_X_MSVIDEO_TYPE => self::VIDEO_X_MSVIDEO,
        /* video/x-sgi-movie */
        self::VIDEO_X_SGI_MOVIE_TYPE => self::VIDEO_X_SGI_MOVIE,
        /* video/3gpp */
        self::VIDEO_3GPP_TYPE => self::VIDEO_3GPP,

        /* W - Workbook */

        /* workbook/formulaone */
        self::WORKBOOK_FORMULAONE_TYPE => self::WORKBOOK_FORMULAONE,

        /* X - X-World */

        /* x-world/x-3dmf */
        self::X_WORLD_X_3DMF_TYPE => self::X_WORLD_X_3DMF,
        /* x-world/x-vrml */
        self::X_WORLD_X_VRML_TYPE => self::X_WORLD_X_VRML,
    ];
}
