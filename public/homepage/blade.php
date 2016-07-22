<?php

use it\hce\microframework\core\factories\TemplateFactory;

//Template Name
$templateName = 'templates.homepage-blade';

//Models ['name' => 'dataset']
$models = array(
    'logoBlade' => 'default',
    'subLogoBlade' => 'sub'
);

//Loading Template Factory
echo TemplateFactory::loadBladeTemplate($templateName, $models);