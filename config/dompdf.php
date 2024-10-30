<?php

return [

    'show_warnings' => false,   // Throw an Exception on warnings from dompdf

    'public_path' => null,  // Override the public path if needed

    'convert_entities' => true,

    'options' => [
        /**
         * The location of the DOMPDF font directory
         *
         * The location of the directory where DOMPDF will store fonts and font metrics
         * Note: This directory must exist and be writable by the webserver process.
         * *Please note the trailing slash.*
         */
        "font_dir" => storage_path('fonts/'), // advised by dompdf (https://github.com/dompdf/dompdf/pull/782)

        /**
         * The location of the DOMPDF font cache directory
         *
         * This directory contains the cached font metrics for the fonts used by DOMPDF.
         * This directory can be the same as DOMPDF_FONT_DIR
         */
        "font_cache" => storage_path('fonts/'),

        /**
         * The location of a temporary directory.
         *
         * The directory specified must be writeable by the webserver process.
         */
        "temp_dir" => sys_get_temp_dir(),

        /**
         * dompdf's "chroot": Prevents dompdf from accessing system files or other
         * files on the webserver.  All local files opened by dompdf must be in a
         * subdirectory of this directory.
         */
        "chroot" => realpath(base_path()),

        /**
         * Protocol whitelist
         */
        'allowed_protocols' => [
            "file://" => ["rules" => []],
            "http://" => ["rules" => []],
            "https://" => ["rules" => []]
        ],

        /**
         * Whether to enable font subsetting or not.
         */
        "enable_font_subsetting" => false,

        /**
         * The PDF rendering backend to use
         */
        "pdf_backend" => "CPDF",

        /**
         * html target media view which should be rendered into pdf.
         */
        "default_media_type" => "screen",

        /**
         * The default paper size.
         */
        "default_paper_size" => "a4",

        /**
         * The default paper orientation.
         */
        'default_paper_orientation' => "portrait",

        /**
         * The default font family
         */
        "default_font" => "sarabun", // กำหนดฟอนต์เริ่มต้นเป็น Sarabun

        /**
         * Image DPI setting
         */
        "dpi" => 96,

        /**
         * Enable inline PHP
         */
        "enable_php" => false,

        /**
         * Enable inline Javascript
         */
        "enable_javascript" => true,

        /**
         * Enable remote file access
         */
        "enable_remote" => true,

        /**
         * A ratio applied to the fonts height to be more like browsers' line height
         */
        "font_height_ratio" => 1.1,

        /**
         * Use the HTML5 Lib parser
         */
        "enable_html5_parser" => true,

        /**
         * Custom font directory and data
         */
        'custom_font_dir' => public_path('fonts/'), // ไดเรกทอรีฟอนต์ภาษาไทย

        'custom_font_data' => [
            'sarabun' => [
                'R' => 'thsarabunNew.ttf',    // ปกติ
                'B' => 'thsarabunNewBold.ttf',       // หนา
                'I' => 'thsarabunNewBoldltalic.ttf',     // เอียง
                'BI' => 'thsarabunNewItalic.ttf' // หนาเอียง
            ],
        ],
    ],
];
