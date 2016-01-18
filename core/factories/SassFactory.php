<?php

namespace it\hce\microframework\core\factories;

use it\hce\microframework\core\MicroFramework;
use Leafo\ScssPhp\Compiler;
use MatthiasMullie\Minify\CSS;

class SassFactory {
    private $compiler;
    private $main;
    private $minifier;

    public function __construct()
    {
        include_once (MicroFramework::getBasePath() . 'vendor/leafo/scssphp/scss.inc.php');
        $this->compiler = new Compiler();

        $this->main = file_get_contents(MicroFramework::getResourcesPath() . 'css/main.scss');

        include_once(MicroFramework::getBasePath() . 'vendor/matthiasmullie/minify/src/Minify.php');
        include_once(MicroFramework::getBasePath() . 'vendor/matthiasmullie/minify/src/CSS.php');
        include_once(MicroFramework::getBasePath() . 'vendor/matthiasmullie/path-converter/src/Converter.php');

        $this->minifier = new CSS();
    }

    public function collectSCSS()
    {
        $this->compiler->setImportPaths(MicroFramework::getResourcesPath() . 'css/');
    }

    public function write($path)
    {
        $this->minifier->add($this->compiler->compile($this->main));

        file_put_contents($path, $this->minifier->minify());
    }
}