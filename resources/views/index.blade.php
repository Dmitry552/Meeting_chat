<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon.svg">

    <title>{{config('app.name', "Meeting Chat")}}</title>

    @vite('resources/js/app.ts')
    @vite('resources/css/app.css')
</head>
    <body class="app">
    <div id="document-preload" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <img src="loading.gif" alt="" />
    </div>
    <div id="app"></div>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('#document-preload').remove();
      });
    </script>
</body>
</html>
