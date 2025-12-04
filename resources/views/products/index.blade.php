<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        {{-- {{dd($products)}} --}}
        <h1 class="my-4">Product Lists</h1>
        <a href="{{ route('products.create') }}" class="btn btn-outline-success mb-4 btn-sm">+ Create</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="bg-primary text-white">#</th>
                    <th class="bg-primary text-white">NAME</th>
                    <th class="bg-primary text-white">DESCRIPTION</th>
                    <th class="bg-primary text-white">PRICE</th>
                    <th class="bg-primary text-white">Category</th>
                    <th class="bg-primary text-white">IMAGE</th>
                    <th class="bg-primary text-white">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $data)
                    <tr>
                        <th>{{ $data['id'] }}</th>
                        <th>{{ $data['name'] }}</th>
                        <th>{{ $data['description'] }}</th>
                        <th>{{ $data['price'] }}</th>
                        <th>
                            {{ $data['category'] ? $data["category"]['name'] : "-" }}
                        </th>
                        <th>
                            <img src="{{ asset('productImages/' . $data->image) }}" alt="{{ $data->image }}"
                                style="width: 50px; height: auto;" />
                        </th>
                        <th class="d-flex">
                            <a href="{{ route('products.edit', ['id' => $data->id]) }}"
                                class="btn btn-outline-secondary me-2 btn-sm">Edit</a>
                            <form action="{{ route('products.delete', $data->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                        </th>
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
