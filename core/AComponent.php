<?php

namespace it\hce\microframework\core;


abstract class AComponent
{
    public $config = [];

    public function __construct($basePath, $name, $data)
    {
        $this->name = $name;
        $this->basePath = $basePath;
        $this->html = $this->loadHtml();
        $this->css = $this->loadCss();
        $this->config = $data;
        $dataset = $data["dataset"];
        $this->hydrate(is_null($dataset) ? 'default' : $dataset);
    }

    public function getConfigValue($name)
    {
        if (array_key_exists($name, $this->config))
        {
            return $this->config[$name];
        }

        return null;
    }

    public function getCss()
    {
        return $this->css;
    }

    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @param $key
     * @param $data
     * @return string
     * internal function to preprocess data
     */
    public function preprocessData($key, $data)
    {
        return $data;
    }

    public function hydrate($dataSet = 'default')
    {
        $dataSet = $this->loadDataSet($dataSet);
        foreach ($dataSet as $key => $data)
        {
            $data = $this->preprocessData($key, $data);

            // first try optional fields [[<p>{{{$key}}}</p>]]
            // you can have multiple optional fields in a sequence, if any of the two is empty they are both removed
            $regexp = '/\[\[(.+\{\{\{\$' . $key . '\}\}\}.+)\]\]/';
            while (preg_match($regexp, $this->html, $matches))
            {
                $found = $matches[0];
                if ($data == "" || $data == false)
                {
                    $this->html = str_replace($found, "", $this->html);
                } else {
                    $content = $matches[1];
                    $content = str_replace('{{{$' . $key . '}}}', $data, $content);
                    $this->html = str_replace($found, $content, $this->html);
                }
            }

            // then compulsory fields
            $this->html = str_replace('{{{$' . $key . '}}}', $data, $this->html);
        }

        $this->postprocessData();
    }

    public function postprocessData()
    {

    }

    private function loadDataSet($name = 'default')
    {
        return json_decode(file_get_contents(MicroFramework::getComponentsPath() . $this->name . '/datasets/' . $name . '.json'), true);
    }

    private function loadCss($css = 'head')
    {
        $path = MicroFramework::getComponentsPath() . $this->name . '/' . $css . '.css';
        if (file_exists($path))
        {
            return file_get_contents($path);
        }

        return '';
    }

    private function loadHtml($html = 'template')
    {
        return file_get_contents(MicroFramework::getComponentsPath() . $this->name . '/' . $html . '.html');
    }
}