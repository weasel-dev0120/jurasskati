<?php

if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst(string $string, string $encoding = 'UTF-8'): string
    {
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);

        return mb_strtoupper($firstChar, $encoding).$then;
    }
}

if (!function_exists('column')) {
    function column(string $column): string
    {
        return $column.'->'.config('app.locale');
    }
}

if (!function_exists('locales')) {
    function locales(): array
    {
        return array_keys(config('typicms.locales'));
    }
}

if (!function_exists('getMigrationFileName')) {
    function getMigrationFileName(string $name): string
    {
        $directory = database_path(DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR);
        $migrations = File::glob($directory.'*_'.$name.'.php');

        return $migrations[0] ?? $directory.date('Y_m_d_His').'_'.$name.'.php';
    }
}

if (!function_exists('slugify')) {
    function slugify($input) {
        $slugify = new Cocur\Slugify\Slugify();
        return $slugify->slugify($input);
    }
}

if (!function_exists('resize')) {
    function resize($path, $width, $height, $format = 'jpg') {
        $suffix = "-{$width}x{$height}.{$format}";
        if ( ! file_exists(public_path($path) . $suffix)) {
            $image = Image::make(public_path($path));
            $image->fit($width, $height);
            $quality = $width > 1200 ? 60 : 80;
            $image->save(public_path($path) . $suffix, $quality);
        }
        return $path . $suffix;
    }
}

if (!function_exists('picture_source')) {
    function picture_source($path, $sourceList) {
        $origPath = public_path($path);
        $sourceHtml = '';
        foreach ($sourceList as $source) {
            @list($media, $width, $height) = $source;
            $sourceHtml .= "<source media=\"{$media}\" ";
            $src = resize($path, $width, $height, 'webp');
            $srcDouble = resize($path, $width*2, $height*2, 'webp');
            $sourceHtml .= "srcset=\"{$src} 1x, {$srcDouble} 2x\" type=\"image/webp\" ";
            $sourceHtml = trim($sourceHtml) . '>';
        }
        return $sourceHtml;
    }
}
