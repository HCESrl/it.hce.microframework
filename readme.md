# it.hce.microframework
### a lightweight framework designed for prototyping

## Install
* `php composer.phar create-project hce/microframework projectName`
* `npm install`
* Point your webserver to `public` folder
* Set `public/css` and `public/js` as writable folders (create them if necessary)

## Create a component
* Create a folder under `components` named as you wish, for example `component`
* Create a PHP loader called `Component.php` with:

```
<?php
namespace it\hce\microframework\components;


use it\hce\microframework\core\AComponent;

class Component extends AComponent {
    const name = 'component';

    public function __construct($basePath, $dataSet) {
        parent::__construct($basePath, self::name, $dataSet);
    }
}
```

* Create a component template: `template.html`

```
<div class="component">{{{$text}}}</div>
```

* Style it with a new file called `_style.scss`, add this entry to `resources/css/main.scss`

```
.component {
    color: red;
}
```

* Make it dynamic with `script.js`

```
App.Component = function () ...
```

* Create a `datasets` folder and place a `default.json` file

```
{
  "text": "it.hce.microframework"
}
```

## Create a template

* Create a template file under `templates`, for example: `template.html`

```
<!DOCTYPE html>
<html>
    <head>
        <title>hce microframework</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../css/main.css?{{{$time}}}">
        <link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
    </head>
    <body class="home">
        {{{$components}}}

        <script src="{{{$jsFile}}}?{{{$time}}}"></script>
    </body>
</html>
```

The `{{{$components}}}` placeholder is where your component list (we will define it later), will be placed
The `{{{$time}}}` placeholder is a special framework placeholder that displays the UNIX time

## Combine components inside templates

* Create a folder under `public` for your route, example: `test`
* Create a `.php` file called `testing.php`

```
<?php

use it\hce\microframework\core\factories\TemplateFactory;

//Template Name
$templateName = 'template';

//Components list ['name' => 'dataset']
$components = array(
    array(
        "component" => 'component',
        "dataset"   => null
    ),
);

//Loading Template Factory
echo TemplateFactory::loadTemplate($templateName, $components, 'component');
```

## See results

* Run `gulp`
* Go to your webserver `http://www.your.host/test/testing`

## Features

* Compile Sass on the fly
Add any entry to `resources/css/main.scss` and let PHP compile and minify it for you.

* Compile JS on the fly
All your components' JS and the list located at `config/javascripts.json` will be compiled under a unique main.js file.

* Icon support
Save your SVG icons under `resources/svg` and they will be parsed by the icons factory.
Include them using `@include inline-svg($icon-name)` in any scss file.

* JSON output support
Under your route you can pass `true` as last parameter to enable JSON header reply by the server:

```
//Loading Template Factory
echo TemplateFactory::loadTemplate($templateName, $components, 'component', true);
```

Useful when some kind of JSON reply is needed.

* All your common resources in one folder
Place audio, video, css, fonts, images, js, svgs in the `resources` folder, with `gulp` everything will be smartly copied in `public`

