<?php

use it\hce\microframework\core\factories\TemplateFactory;

//Template Name
$templateName = 'homepage-rtl';

//Components list ['name' => 'dataset']
$components = array(
    array(
        "component" => 'logo',
        "dataset"   => null
    ),
);

//Loading Template Factory
TemplateFactory::setLanguage("ar");
TemplateFactory::setDirection("rtl");
echo TemplateFactory::loadTemplate($templateName, $components, 'hero-image-home');