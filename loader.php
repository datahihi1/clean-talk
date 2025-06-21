<?php

if(!class_exists('CleanTalk\Censor')) {
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/src')) as $file) {
        if ($file->isFile() && strtolower($file->getExtension()) === 'php') {
            require_once $file->getPathname();
        }
    }
}