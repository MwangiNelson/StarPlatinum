<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- I have imported bootsrap css via cdn -->
    <!-- bootstrap css cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- This is for the icons I'll be using in-app -->
    <!-- fontawesome cdn -->
    <script src="https://kit.fontawesome.com/db540a34d6.js" crossorigin="anonymous"></script>

    <!-- Here I have imported google fonts : Barlow Condensed to be specific -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300&display=swap" rel="stylesheet">


    <!-- This is the link to the custom css file for this app -->
    <link rel="stylesheet" href="css/app.css">
    <!-- Some little styling for quick fixes -->
    <style>
        * {
            font-family: 'Barlow Condensed', sans-serif;
        }

        h1 {
            text-transform: uppercase;
        }

        .nav-image {
            width: 4vw;
            height: 4vw;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>

    <!-- Importing the vue app via js bundling -->
    <!-- The defer attribute makes the script run after render -->
    <script src="{{asset('js/app.js')}}" defer></script>

    <title>To do App</title>
</head>

<body class="antialiased">

    <!-- Since the navabar is constant for now, I placed it on the index file -->
    <nav class="navbar w-100 navbar-dark bg-dark">
        <div class="w-25 d-flex justify-content-center">
            <h1 class="navbar-text">My To Do App</h1>
        </div>
        <div class="w-25 d-flex justify-content-center">
            <img src="https://images.pexels.com/photos/5091121/pexels-photo-5091121.jpeg?auto=compress&cs=tinysrgb&w=600" alt="" class="nav-image">
        </div>
    </nav>
    <!-- This will be the vue app container -->
    <div id="app">
        <!-- Appending the main app Component that serves like the main() view -->
        <app-component></app-component>
    </div>


</body>

</html>

<!-- The Vue component files are located in the resources/js/components folder -->