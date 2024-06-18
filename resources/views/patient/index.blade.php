<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Your custom CSS files -->
    <link rel="stylesheet" href="{{ asset('assets/css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}"> <!-- Rename this file to navbar.css as planned -->
    <style>
        /* Your additional inline styles */
        .popup, .sub-table, .filter-container, .anim {
            animation: transitionIn-Y-bottom 0.5s;
        }

        body {
            padding-top: 70px; /* Sesuaikan dengan tinggi navbar Anda */
        }

        .col-md-6 {
            margin-top: 20px; /* Atur margin atas pada kolom */
        }

        .navbar-custom {
            background-color: #161c2d; /* Sama seperti .container-color */
            color: white;
        }

        .profile-title {
            color: white; /* Sesuaikan warna teks agar kontras dengan background */
        }

        .upload-container,
        .container-color {
            border-radius: 10px;
            margin-top: 10px;
        }

        .status-container {
            background-color: #161c2d; /* Sama seperti .container-color */
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 10px;
        }

        .info-container {
            background-color: #161c2d; /* Sama seperti .container-color */
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 10px;
            cursor: pointer; /* Add pointer cursor to indicate interactivity */
            height: 70vh; /* 8 rows, adjust as needed */
        }

        .info-container img {
            width: 100%; /* Make image take full width of the container */
            height: 100%; /* Make image take full height of the container */
            object-fit: cover; /* Ensure the image covers the container */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <a class="navbar-brand" href="#">
            <span style="color: white; margin-right: -4px;">MIND</span>
            <span style="color: #007bff; margin-left: -1px;">MEND</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('patient.doctors') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('patient.doctors') }}">Doctors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('patient.schedule') }}">Sessions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('patient.appointment') }}">Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('patient.settings') }}">Settings</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="profile-title mr-4"><h1">{{ $user->pname }}.</h1></span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="btn btn-primary">Log out</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Dashboard Body -->
    <div class="container-fluid mt-1">
        <div class="row">
            <div class="col-md-6 anim">
                <div class="upload-container container-card">
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <label class="upload-label">Upload Sound</label>
                        <div class="form-group">
                            <input type="file" class="form-control-file btn btn-primary mt-4" id="fileToUpload" name="fileToUpload">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary mt-4">Upload</button>
                        </div>
                    </form>
                </div>
                <div class="status-container">
                    <h5>Status Report</h5>
                    <p>Hasil diagnosis dari suara tersebut adalah anda tidak sigma</p>
                </div>
            </div>
            <div class="col-md-6 anim">
                <div class="info-container" id="posterContainer">
                    <img src="{{ asset('assets/img/poster.png') }}" id="posterImage" alt="Poster">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and other JavaScript libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // JavaScript for changing the poster image
        let images = ["{{ asset('assets/img/poster.png') }}", "{{ asset('assets/img/poster1.png') }}"];
        let currentIndex = 0;

        document.getElementById("posterContainer").addEventListener("click", function() {
            currentIndex = (currentIndex + 1) % images.length;
            document.getElementById("posterImage").src = images[currentIndex];
        });


    </script>
</body>
</html>
