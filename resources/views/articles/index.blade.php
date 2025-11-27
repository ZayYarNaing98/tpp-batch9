<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div>
        <h2 style="color: red;">Article Listing</h2>
        @foreach ($data as $category)
            <p>{{ $category['id'] }} : {{ $category['name'] }}</p>
        @endforeach
    </div>
</body>

</html>
