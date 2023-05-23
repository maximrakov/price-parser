<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @routes

    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
</head>
<body>
@inertia
</body>
</html>
