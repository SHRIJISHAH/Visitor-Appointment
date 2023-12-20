<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto Sans' rel='stylesheet'>
</head>

<body>
    <h2>All Users</h2>

    <ul>
        @foreach($users as $user)
        <li>
            {{ $user->name }}
            <a href="{{ route('admin.show-user', ['id' => $user->id]) }}">View</a>
        </li>
        @endforeach
    </ul>
</body>

</html>
