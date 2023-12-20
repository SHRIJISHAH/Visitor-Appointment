<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Noto Sans' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha384-ezC+JZuHiit1kiaBFOcDpDDmr4oQ0q6D/KlJv7HwkWEG2e1feVpW/6aBLzj7eE7I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/appointment.css') }}">

</head>

<body>
    <div class="container">
        <div class="mt-2">
            <div class="row">
                <div class="back" onclick="goBack()">
                    < </div>
                        <div class="ttl">Add New Event</div>
                </div>
                @if(session('success'))
                <div style="color: green;">{{ session('success') }}</div>
                @endif
                <div class="layout">
                    <form action="/appointment" method="POST">
                        @csrf

                        <input type="text" class="ename" id="event_name" name="event_name" placeholder="Event name*"
                            required>

                        <textarea id="description" class="desc" name="description"
                            placeholder="Type the note here..."></textarea>

                        <div class="date-container">
                            <input class="date flatpickr" id="date" name="date" placeholder="Date" required>
                            <span class="date-icon" id="date-icon"><i class="fas fa-calendar-alt"></i></span>
                        </div>

                        <div class="time">
                            <input type="time" class="stime" id="start_time" name="start_time" placeholder="Start Time"
                                required value="09:00">
                            <input type="time" class="etime" id="end_time" name="end_time" placeholder="End Time"
                                required value="12:00">
                        </div>


                        <div class="time">
                            <input type="text" class="stime" id="name" name="name" placeholder="Name" required>

                            <input type="tel" class="etime" id="mobile_no" name="mobile_no" placeholder="Mobile_No" required>
                        </div>

                        <div class="cat">
                            <label for="category" class="selectCat">Select Category:</label><br>
                            <div class="catgrp">
                                <div class="op">
                                    <div class="meeting">
                                        <input type="radio" id="Meeting" name="category" value="Meeting">
                                        <label for="Meeting">Meeting</label>
                                    </div>
                                    <div class="event">
                                        <input type="radio" id="Event" name="category" value="Event">
                                        <label for="Event">Event</label>
                                    </div>
                                    <div class="service">
                                        <input type="radio" id="Service" name="category" value="Service">
                                        <label for="Service">Service</label><br>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="submit">CREATE APPOINTMENT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-VoW0MRK3PzHs6PPeavMRXCgxyxT5sSNMyuB+vRfBT8SOfCtMr5S1EkTCDUjBFBS8FQkSrR6zqvgPBo05Gz/PQw=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"
        integrity="sha512-+pg0FZA8aoyWMT3ayKmz6Dq/4FFddJydXYG9p6bcGfRP2L0Cr4B/XC4PlkAHL0pjbI7TPg4YAFh+YUqJkz9ftw=="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".flatpickr", {
            dateFormat: "Y-m-d",
            enableTime: false,
            static: true,
        });

        document.getElementById('date-icon').addEventListener('click', function() {
            document.getElementById('date').flatpickr.open();
        });
    });

    function goBack() {
        window.history.back();
    }
    </script>
</body>

</html>
