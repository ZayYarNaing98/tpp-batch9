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
        {{-- {{dd($data)}} --}}
        <h1>Catgory List</h1>
        <a href="{{ route('categories.create') }}">+Create</a>
        @foreach ($data as $category)
            <p>{{ $category['id'] }} : {{ $category['name'] }}</p>
            <a href="{{ route('categories.edit', ['id' => $category->id ]) }}">Edit</a>
        @endforeach
    </div>
</body>
</html>
