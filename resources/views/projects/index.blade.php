<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Birdboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
    <h1>Birdboard project manager</h1>

    @forelse($projects as $project)
        <li> <a href=" {{ $project->path() }} "> {{ $project->title }} </a></li>
    @empty
        <h3>No Projects Yet</h3>
    @endforelse
</body>
</html>