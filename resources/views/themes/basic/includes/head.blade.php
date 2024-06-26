@include('themes.basic.includes.meta-tags')
<title>{{ pageTitle($__env) }}</title>
<link rel="icon" href="{{ asset($themeSettings->general->favicon) }}">
@include('themes.basic.includes.styles')
