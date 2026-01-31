<?php
    function loadFiles(array $files, string $type) {
        foreach ($files as $file) {
            $serverPath = ROOT_PATH . $file;
            $version = file_exists($serverPath) ? filemtime($serverPath) : time();

            if ($type == 'css') {
                echo '<link rel="stylesheet" href="' . ROOT_URL . $file . '?v=' . $version . '">';
            }

            if ($type == 'lib') {
                echo '<script src="' . ROOT_URL . $file . '"></script>';
            }
        }
    }
?>