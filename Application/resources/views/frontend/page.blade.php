<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Courses Page</title>

    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Add Custom CSS -->
    <style>
        /* Add your custom CSS here */
        body {
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Premium Courses</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Profile</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <h1>Welcome Premium Subscriber!</h1>
    <p>You have access to the following courses for free:</p>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="course1.jpg" class="card-img-top" alt="Course 1 Image">
                <div class="card-body">
                    <h5 class="card-title">Course 1</h5>
                    <p class="card-text">This is a description of Course 1.</p>
                    <a href="#" class="btn btn-primary">View Course</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="course2.jpg" class="card-img-top" alt="Course 2 Image">
                <div class="card-body">
                    <h5 class="card-title">Course 2</h5>
                    <p class="card-text">This is a description of Course 2.</p>
                    <a href="#" class="btn btn-primary">View Course</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="course3.jpg" class="card-img-top" alt="Course 3 Image">
                <div class="card-body">
                    <h5 class="card-title">Course 3</h5>
                    <p class="card-text">This is a description of Course 3.</p>
                    <a href="#" class="btn btn-primary">View Course</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add Bootstrap JS and jQuery links if needed -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
