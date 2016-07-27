<!DOCTYPE html>
<html>
<head>
    <title>hce microframework</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="@if ($GLOBAL->isRtl){{$GLOBAL->rtlCss}}@else{{$GLOBAL->css}} @endif">
    <link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
</head>
<body>

@yield('components')

<script src="{{$GLOBAL->js}}"></script>
</body>
</html>