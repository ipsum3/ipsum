<!doctype html>
<!--[if lte IE 10 &!(IEMobile)]><html lang="fr" class="old-ie"> <![endif]-->
<!--[if gt IE 10 &!(IEMobile)]><!-->
<html lang="fr">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <title>@yield('title') -  {{{ config('settings.nom_site') }}}</title>
    <meta name="description" content="@yield('description')" />


</head>

<body data-lang="fr">

    @yield('content')

</body>