<?php

if (!function_exists('storage_url')) {
    /**
     * Generate URL for a file in storage/app/public (served via /media route).
     * Use this instead of asset('storage/'.$path) when symlink is not available (e.g. Hostinger).
     *
     * @param string|null $path Path relative to storage/app/public (e.g. 'products/xxx.jpg')
     * @return string Full URL to the file
     */
    function storage_url(?string $path): string
    {
        if (empty($path)) {
            return '';
        }
        return url('media/' . ltrim($path, '/'));
    }
}
