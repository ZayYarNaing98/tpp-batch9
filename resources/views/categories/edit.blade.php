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
        <div class="card mt-4">
            <div class="card-header">
                Edit Category
            </div>
            <form action="{{ route('categories.update', [$category->id]) }}" method="POST">
                @csrf
                <div class="card-body">
                    <label for="name" class="form-input-label mb-2">Category Name:</label>
                    <input type="text" class="form-control" value="{{ $category->name }}" name="name" />
                    @error('name')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="card-body">
                    <label for="image" class="form-input-label mb-2">Category Image:</label>
                    <img src="{{ asset('categoryImages/' . $category->image) }}" alt="{{ $category->image }}"
                        style="width: 100px; height: auto;">

                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-primary btn-sm me-2" type="submit">Update</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm"> Back </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>
