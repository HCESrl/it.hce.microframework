<?php

namespace it\hce\microframework\core\factories;


use it\hce\microframework\components;
use it\hce\microframework\core\MicroFramework;

class TemplateFactory
{
    const templatesExt = '.html';

    static $currentTemplate;
    static $jsLibs = false;
    static $ajaxFactory;
    static $templateName;
    static $componentsFactory;

    /**
     * @param $templateName
     * @param $componentsArray
     * @param $headCssComponentName
     * @param bool $ajax
     * @return string
     */
    public static function loadTemplate($templateName, $componentsArray, $headCssComponentName, $ajax = false)
    {
        // Check if the request is AJAX type and load the factory
        self::$ajaxFactory = new AjaxFactory($ajax);

        // Write minified JS to main.js
        $jsFactory = new JavascriptFactory();
        $jsFactory->collectJS();
        $jsFactory->write(MicroFramework::getPublicPath() . 'js/main.js');

        // Write minified CSS to main.css
        $sassFactory = new SassFactory();
        $sassFactory->collectSCSS();
        $sassFactory->write(MicroFramework::getPublicPath() . 'css/main.css');

        // Load the template file
        self::$currentTemplate = file_get_contents(MicroFramework::getTemplatesPath() . $templateName . self::templatesExt);

        // If the current template is valid, load the components factory
        if (self::$currentTemplate) {
            // Load ComponentsFactory
            self::$componentsFactory = new ComponentsFactory(MicroFramework::getBasePath(), $componentsArray);

            // Load a possible headCss component and write it to the header
            $headCssComponent = self::$componentsFactory->loadHeadComponent($headCssComponentName);

            // Load the components array
            $components = self::$componentsFactory->loadComponents();

            // Write HTML
            TemplateFactory::writeTimestampOnTemplate();
            TemplateFactory::writeJS();
            TemplateFactory::writeComponents($components);

            return self::$currentTemplate;
        }

        return false;
    }

    /**
     * Writes a timestamp just for development
     */
    private static function writeTimestampOnTemplate()
    {
        self::$currentTemplate = str_replace('{{{$time}}}', time(), self::$currentTemplate);
    }

    /**
     * Writes main.js path to header
     */
    private static function writeJS()
    {
        self::$currentTemplate = str_replace('{{{$jsFile}}}', 'js/main.js', self::$currentTemplate); // PHP COMPILED
    }

    /**
     * Writes components' HTML inside the template
     * @param array $components
     */
    private static function writeComponents($components)
    {
        $componentContent = '';
        foreach ($components as $component) {
            $componentContent .= $component->getHtml();
        }

        if (self::$ajaxFactory->isAjax) {
            sleep(2); //TODO: ?
            $componentContent = json_encode($componentContent);
        }
        self::$currentTemplate = str_replace('{{{$components}}}', $componentContent, self::$currentTemplate);
    }
}