<?php

use it\hce\microframework\core\factories\TemplateFactory;

//Template Name
$templateName = 'templates.homepage-blade-rtl';

//Models ['name' => 'dataset']
$models = array(
    'logoBlade' => 'default',
    'subLogoBlade' => 'sub'
);

//Loading Template Factory
TemplateFactory::setLanguage("ar");
TemplateFactory::setDirection("rtl");
echo TemplateFactory::loadBladeTemplate($templateName, $models);