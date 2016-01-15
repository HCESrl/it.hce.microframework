<?php

namespace it\hce\microframework\core\factories;

class AjaxFactory {
    public $isAjax;

    public function __construct($isAjax = false)
    {
        if($this->isAjax = $isAjax)
        {
            $this->setHeader();
        }
    }

    private function setHeader()
    {
        header('Content-Type: application/json');
    }
}