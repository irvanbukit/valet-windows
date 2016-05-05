<?php

class StatamicValetDriver extends ValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return void
     */
    public function serves($sitePath, $siteName, $uri)
    {
        return is_dir($sitePath.'/statamic');
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        if (strpos($uri, '/site') === 0 && strpos($uri, '/site/themes') !== 0) {
            return false;
        } elseif (strpos($uri, '/local') === 0 || strpos($uri, '/statamic') === 0) {
            return false;
        } elseif (file_exists($staticFilePath = $sitePath.'/'.$uri)) {
            return $staticFilePath;
        } elseif (file_exists($staticFilePath = $sitePath.'/public/'.$uri)) {
            return $staticFilePath;
        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        $_SERVER['SCRIPT_NAME'] = '/index.php';

        if (file_exists($indexPath = $sitePath.'/index.php')) {
            return $indexPath;
        }

        if (file_exists($indexPath = $sitePath.'/public/index.php')) {
            return $indexPath;
        }
    }
}
