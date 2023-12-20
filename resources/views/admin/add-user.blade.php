<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto Sans' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>


<body>
    <div class="container">
        <div class="onboarding">

            @if(session('success'))
            <div style="color: green;">{{ session('success') }}</div>
            @endif

            @if(session('error'))
            <div style="color: red;">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.add-user') }}" method="post">
                @csrf

                <input type="text" class="form-control" placeholder="Name" name="name" required>

                <input type="email" class="form-control" placeholder="Email" name="email" required>

                <input type="tel" class="form-control" name="mobile_no" placeholder="Mobile no" required>

                <input type="text" class="form-control" name="designation" placeholder="Designation" required>

                <input type="text" class="form-control" name="department" placeholder="Department" required>

                <button type="submit">Add User</button>
            </form>
        </div>
    </div>
</body>

</html>
