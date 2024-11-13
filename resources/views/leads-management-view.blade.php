<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Leads Capture</title>

  @vite(['resources/css/app.css', 'resources/ts/app.ts'])
</head>

<body>
  <div id="app">
    <leads-management-view></leads-management-view>
  </div>
</body>

</html>