<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto Sans' rel='stylesheet'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/calendar-styles.css') }}">
</head>

<body>
    <div class="container">
        <div class="onboarding">
            <div class="mt-2">
                <div class="row">
                    <div class="col-3">
                        <img src="{{ asset('img/group35.png') }}" alt="Image Alt Text">
                    </div>
                    <div class="col-7">
                        <div class="ttl">Set Up an Appointment</div>
                    </div>
                    <div class="col-2">
                        <button id="openAppointmentForm" class="add-btn">+</button>
                    </div>
                </div>
<!-- Calendar -->
                <div class="calendar">
                    <div class="row">
                        <div class="col-3">
                            <button id="prev-btn" class="prev">
                                < </button>
                        </div>
                        <div class="col-6">
                            <h2 class="month" id="month"></h2>
                            <h3 class="year" id="year"></h3>
                        </div>
                        <div class="col-3">
                            <button id="next-btn" class="next"> > </button>
                        </div>
                    </div>
                    <div class="days">
                        <div class="day-name">Mon</div>
                        <div class="day-name">Tue</div>
                        <div class="day-name">Wed</div>
                        <div class="day-name">Thu</div>
                        <div class="day-name">Fri</div>
                        <div class="day-name">Sat</div>
                        <div class="day-name">Sun</div>
                    </div>
                    <div class="days" id="days-container"></div>

                <div id="date-data-container"></div>



                <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>



            </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/calendar-script.js') }}"></script>

</body>
</html>
