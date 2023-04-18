<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap css cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- fontawesome cdn -->
    <script src="https://kit.fontawesome.com/db540a34d6.js" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="css/app.css">
    <!-- <style src="{{asset('css/app.css')}}"></style> -->
    <style>
        * {
            font-family: 'Barlow Condensed', sans-serif;
        }

        h1 {
            text-transform: uppercase;
            /* color: white; */
        }

        .nav-image {
            width: 4vw;
            height: 4vw;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
    <title>To do App</title>
</head>

<body class="antialiased">
    <nav class="navbar w-100 navbar-dark bg-dark">
        <div class="w-25 d-flex justify-content-center">
            <h1 class="navbar-text">My To Do App</h1>
        </div>
        <div class="w-25 d-flex justify-content-center">
            <img src="https://images.pexels.com/photos/5091121/pexels-photo-5091121.jpeg?auto=compress&cs=tinysrgb&w=600" alt="" class="nav-image">
        </div>
    </nav>
    <div id="app">
        <example-component></example-component>
    </div>
    <script src="{{asset('js/app.js')}}"></script>
</body>

</html>