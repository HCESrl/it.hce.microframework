# it.hce.microframework
### a lightweight framework designed for prototyping

## Install
* `php composer.phar create-project hce/microframework projectName`
or
* `composer.phar create-project hce/microframework projectName`
then
* `cd projectName`
* `npm install`
* Point your webserver to `projectName/public` folder
* Set `public/css` and `public/js` as writable folders (create them if necessary)
* Set `cache` as writable folder

## Create a component
* Create a folder under `components` named as you wish, for example `component`

* Create a component template: `template.blade.php`

```
<div class="component">{{$component->text}}</div>
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

* Create a template file under `templates`, for example: `homepage.blade.php`

```
<!DOCTYPE html>
<html>
<head>
    <title>hce microframework</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{$GLOBAL->css}}">
    <link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
</head>
<body class="home">

@include('components.logo.template')

<script src="{{$GLOBAL->js}}"></script>
</body>
</html>
```

## Combine components inside templates

* Create a folder under `public` for your route, example: `homepage`
* Create a `.json` file called `homepage.json` inside that folder

```
{
  "templateName": "homepage",
  "components": [
    {
      "name": "logo",
      "componentName": "logo",
      "dataSet": "default"
    },
    {
      "name": "subLogo",
      "componentName": "subLogo",
      "dataSet": "sub"
    }
  ]
}
```

`name` will be the internal name of the component
`componentName` is the component's directory name in the filesystem
`dataSet` is the loadding model

*You can load a component more that once, just give it a different name*

The JSON should follow this Schema:
```
{
  "type": "object",
  "properties": {
    "templateName": {
      "type": "string",
      "default": "homepage",
      "required": true
    },
    "components": {
      "type": "array",
      "required": true,
      "items": [
        {
          "type": "object",
          "required": true,
          "properties": {
            "name": {
              "type": "string",
              "required": true
            },
            "componentName": {
              "type": "string",
              "required": true
            },
            "dataSet": {
              "type": "string",
              "required": true,
              "default": "default"
            }
          }
        }
      ]
    }
  }
}
```

## See results

* Run `gulp`
* Go to your webserver `http://www.your.host/homepage/homepage`

## Features

* Compile Sass on the fly
Add any entry to `resources/css/main.scss` and let PHP compile and minify it for you.
Create a `main.scss.lock` to bypass this.

* Compile JS on the fly
All your components' JS and the list located at `config/javascripts.json` will be compiled under a unique main.js file.
Create a `main.js.lock` to bypass this.

* Icon support
Save your SVG icons under `resources/svg` and they will be parsed by the icons factory.
Include them using `@include inline-svg($icon-name)` in any scss file.

* All your common resources in one folder
Place audio, video, css, fonts, images, js, svgs in the `resources` folder, with `gulp` everything will be smartly copied in `public`

* Blade Support
The whole template engine is powered by [Blade](https://laravel.com/docs/5.1/blade)
The components also use that engine to work

* Native responsive images support
add the following code to the blade template:
`@responsiveImage(['image' => $component->image, 'component' => 'componentName', 'attributes' => 'class="" alt="'.$component->articleTitle.'"'])
`the system will insert a tag with the image path, and create the appropriate srcset attribute according to the component's configuration. Responsive images can be created with the build-images Gulp task, based on a source image in the resoursces/images/scalable/componentName directory.

# HCE Microframework Static Output

## Usage
Compile the whole project as static output

`php static-output.php` and `gulp`;

`cd static`

Install the http-server (provided by node)

`npm install http-server -g`

Run the server

`http-server`

Open your browser@
`localhost:8080`