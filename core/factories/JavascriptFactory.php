<?php

namespace it\hce\microframework\core\factories;

use it\hce\microframework\core\MicroFramework;
use MatthiasMullie\Minify;
use MatthiasMullie\Minify\JS;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

class JavascriptFactory
{
    private $minifier;

    public function __construct()
    {
        include_once(MicroFramework::getBasePath() . 'vendor/matthiasmullie/minify/src/Minify.php');
        include_once(MicroFramework::getBasePath() . 'vendor/matthiasmullie/minify/src/JS.php');
        $this->minifier = new JS();
    }

    /**
     * @return string min output
     */
    public function output()
    {
        return $this->minifier->minify();
    }

    /**
     * Writes the output in a file
     * @param $file string path of the file
     */
    public function write($file)
    {
        file_put_contents($file, $this->output());
    }

    public function collectJS()
    {
        // Read manual JS includes from a JSON file
        $this->getStaticLibs();

        // Read components' JS
        $this->getComponentsLibs();
    }

    private function getStaticLibs()
    {
        $file = file_get_contents(MicroFramework::getConfigPath('javascripts.json'));
        $files = json_decode($file);

        foreach ($files as $key => $value) {
            $files[$key] = MicroFramework::getBasePath() . $value;
        }

        $this->collectJSFromFiles($files);
    }

    private function getComponentsLibs()
    {
        $this->collectJSFromDirectory(MicroFramework::getComponentsPath());
    }

    /**
     * @param $directory
     */
    private function collectJSFromDirectory($directory)
    {
        $Directory = new RecursiveDirectoryIterator($directory);
        $Iterator = new RecursiveIteratorIterator($Directory);
        $Regex = new RegexIterator($Iterator, '/^.+\.js$/i', RecursiveRegexIterator::GET_MATCH);

        foreach ($Regex as $k => $v) {
            $this->collectJsFromFile($k);
        }
    }

    /**
     * @param $files
     */
    private function collectJSFromFiles($files)
    {
        foreach ($files as $file) {
            $this->collectJSFromFile($file);
        }
    }

    /**
     * @param $file
     * @param $base
     */
    private function collectJSFromFile($file, $base = false)
    {
        $jsResult = '';
        $jsResult .= "\r\n/* INCLUDE $file */ \r\n";
        $jsResult .= file_get_contents($file);

        $this->minifier->add($jsResult);
    }
}