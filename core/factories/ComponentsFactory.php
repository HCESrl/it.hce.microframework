<?php

namespace it\hce\microframework\core\factories;


use it\hce\microframework\core\AComponent;
use it\hce\microframework\core\MicroFramework;

class ComponentsFactory {
    private $componentsArray;
    private $basePath;

    /**
     * ComponentsFactory constructor.
     * @param $basePath
     * @param $componentsArray
     */
    public function __construct($basePath, $componentsArray)
    {
        $this->basePath = $basePath;
        $this->componentsArray = $componentsArray;
    }

    /**
     * Gets the component's name based on file name
     * @param $name
     * @return bool|mixed class name
     */
    public function getComponentClassName($name)
    {
        $componentDir = scandir(MicroFramework::getComponentsPath() . $name . '/');

        foreach($componentDir as $file)
        {
            if(strpos($file, '.php') !== false)
            {
                return str_replace('.php', '', $file);
            }
        }

        return false;
    }

    /**
     * @param $headCssComponentName AComponent the component that CSS will be in the header
     * @return bool|AComponent
     */
    public function loadHeadComponent($headCssComponentName)
    {
        $headCssComponent = false;

        foreach($this->componentsArray as $component)
        {
            if($component["component"] == $headCssComponentName)
            {
                $headCssComponent = $this->loadComponent($component);
                break;
            }
        }

        return $headCssComponent;
    }

    /**
     * Load a component
     * @param $data array component's data
     * @return bool| AComponent
     */
    public function loadComponent($data)
    {
        // Setup the references
        $className = $this->getComponentClassName($data["component"]);
        $fileName = $className . '.php';
        $componentFile = MicroFramework::getComponentsPath() . $data["component"] . '/' . $fileName;

        // Checks if the component exists TODO: Exceptions
        if(file_exists($componentFile))
        {
            include_once ($componentFile);
            $className = '\\it\\hce\\microframework\\components\\' . $className;
            return new $className($this->basePath, $data);
        }

        return false;
    }

    /**
     * Loads a list of components
     * @return array list of component objects
     */
    public function loadComponents()
    {
        $ret = [];
        foreach($this->componentsArray as $component)
        {
            array_push($ret, $this->loadComponent($component));
        }

        return $ret;
    }
}