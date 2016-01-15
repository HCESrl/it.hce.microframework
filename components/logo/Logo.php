<?php
namespace it\hce\microframework\components;


use it\hce\microframework\core\AComponent;

class Logo extends AComponent {
    const name = 'logo';

    public function __construct($basePath, $dataSet) {
        parent::__construct($basePath, self::name, $dataSet);
    }
}