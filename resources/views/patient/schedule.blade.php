<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
    <title>Dashboard</title>
    <style>
            .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .anim {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .header-searchbar {
            animation: transitionIn-Y-bottom 0.5s;
            width: 500px;
            /* Adjust the width as needed */
            padding: 5px;
            /* Adjust the padding as needed */
            font-size: 14px;
            /* Adjust the font size as needed */
        }

        .login-btn {
            padding: 5px 15px;
            /* Adjust the padding as needed */
            font-size: 14px;
            /* Adjust the font size as needed */
        }

        .table-session {
            width: 100%;
            height: 100%;
            overflow: auto;
            margin: 0;
        }

        .sub-table thead th {
            border-bottom: 2px solid #465060;
            /* Tambahkan border bawah biru pada header tabel */
            padding: 10px;
            /* Atur padding jika diperlukan */
        }

        .sub-table {
            border: 0px solid #161c2d;
            border-radius: 8px;
            margin: 0;
        }
    </style>
</head>

<body>
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
                    <a class="nav-link" href="{{ route('patient.index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('patient.doctors') }}">Doctors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('patient.schedule') }}">Sessions</a>
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
    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px;">
            <div class="header-container mt-2 anim" style="background-color: #161c2d;">
                <div class="title">ss</div>
                
            </div>
            <tr>
                <td>
                <form action="{{ route('patient.schedule') }}" method="GET" class="header-search">
    @csrf <!-- Laravel CSRF protection -->
    
    <input type="search" name="search" class="input-text header-searchbar"
           placeholder="Search Doctor name or Email or Date (YYYY-MM-DD)" list="doctors">&nbsp;&nbsp;
    
    <datalist id="doctors">
        <!-- Populate datalist options -->
        @foreach ($doctors as $doctor)
            <option value="{{ $doctor->docname }}">
        @endforeach
    </datalist>
    
    <input type="submit" value="Search" class="login-btn btn-primary btn anim"
           style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 10px;">
</form>


                </td>
            </tr>

            <tr>
                <td colspan="4" style="padding-top:10px;">
                    <p class="heading-main12 anim" style="margin-left: 45px;font-size:18px; color: #0A76D8;">
                        All Sessions ({{ $list11->count() }})
                    </p>
                </td>
            </tr>




            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="100%" class="sub-table scrolldown" border="0"
                                style="padding: 50px;border:none">
                                <tbody>
                                    @if ($schedules->isEmpty())
                                    <tr>
                                        <td colspan="4">
                                            <br><br><br><br>
                                            <center>
                                                <img src="{{ asset('assets/img/notfound.svg') }}" width="25%">
                                                <br>
                                                <p class="heading-main12"
                                                    style="margin-left: 45px;font-size:20px;color: #071327">
                                                    We couldn't find anything related to your keywords!
                                                </p>
                                                <a class="non-style-link" href="{{ route('patient.schedule') }}">
                                                    <button class="login-btn btn-primary btn anim">
                                                        &nbsp; Show all Sessions &nbsp;
                                                    </button>
                                                </a>
                                            </center>
                                            <br><br><br><br>
                                        </td>
                                    </tr>
                                    @else
                                    @foreach ($schedules as $schedule)
                                    <tr>
                                        <td style="width: 25%;">
                                            <div class="dashboard-items search-items"
                                                style="background-color: #161c2d;">
                                                <div style="width:100%">
                                                    <div class="h1-search">
                                                    
                                                        {{ substr($schedule->title, 0, 21) }}
                                                    </div><br>
                                                    <div class="h3-search">
                                                        {{ substr($schedule->docname, 0, 30) }}
                                                    </div>
                                                    <div class="h4-search">
                                                    Dokter: {{ $schedule->doctor->docname }}<br>
                                                        {{ $schedule->scheduledate }}<br>Starts:
                                                        <b>{{ substr($schedule->scheduletime, 0, 5) }}</b>
                                                        (24h)
                                                    </div>
                                                    <br>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </center>
                </td>
            </tr>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
