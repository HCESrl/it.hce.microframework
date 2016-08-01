<div class="logo">
    <div>{{$logo->text}}</div>
</div>

@include('components.subLogo.template')

<div class="img">@responsiveImage(['image' => $logo->image, 'component' => $logo->imageSet])</div>