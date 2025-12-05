<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Users Listing</h1>
        <a href="{{ route('users.create') }}" class="btn btn-outline-success my-2 btn-sm">+Create</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="bg-secondary text-white">#</th>
                    <th class="bg-secondary text-white">NAME</th>
                    <th class="bg-secondary text-white">EMAIL</th>
                    <th class="bg-secondary text-white">PHONE</th>
                    <th class="bg-secondary text-white">ADDRESS</th>
                    <th class="bg-secondary text-white">GENDER</th>
                    <th class="bg-secondary text-white">STATUS</th>
                    <th class="bg-secondary text-white">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{ $user->name }}</td>
                        <td> {{ $user->email }} </td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>
                            @if ($user->status === 1)
                                <span class="text-success">
                                    ACTIVE
                                </span>
                            @else
                                <span class="text-danger">
                                    SUSPEND
                                </span>
                            @endif
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>
</html>
