<?php

namespace it\hce\microframework\core\factories;

use CssMin;
use it\hce\microframework\core\MicroFramework;
use Leafo\ScssPhp\Compiler;

class SassFactory {
    private $compiler;
    private $main;

    public function __construct()
    {
        include_once (MicroFramework::getBasePath() . 'vendor/leafo/scssphp/scss.inc.php');
        $this->compiler = new Compiler();

        $this->main = file_get_contents(MicroFramework::getPublicPath() . 'css/main.scss');
    }

    public function collectSCSS()
    {
        $this->compiler->setImportPaths(MicroFramework::getPublicPath() . 'css/');
    }

    public function write($path)
    {
        include_once (MicroFramework::getBasePath() . 'vendor/natxet/CssMin/src/CssMin.php');

        file_put_contents($path, CssMin::minify($this->compiler->compile($this->main)));
    }
}