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
    {{-- {{dd($categories)}} --}}
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                + Create User
            </div>
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <label for="name" class="form-label">Name :</label>
                    <input type="text" name="name" placeholder="Enter Product Name"
                        class="form-control mb-2 @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="card-body">
                    <label for="email" class="form-label @error('email') is-invalid @enderror">
                        Email :
                    </label>
                    <input type="text" name="email" placeholder="Enter Your Email"
                        class="form-control mb-2">
                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="card-body">
                    <label for="password" class="form-label">Password :</label>
                    <input type="password" name="password" placeholder="Enter Your Password"
                        class="form-control mb-2 @error('description') is-invalid @enderror">
                    @error('price')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                 <div class="card-body">
                    <label for="password_confirmation" class="form-label">Password :</label>
                    <input type="password" name="password_confirmation" placeholder="Enter Your Contirm password"
                        class="form-control mb-2 @error('description') is-invalid @enderror">
                    @error('price')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="card-body">
                    <label for="image" class="form-label @error('image') is-invalid @enderror">Upload Your Image
                        Image :</label>
                    <input type="file" class="form-control" name="image" />
                    @error('image')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="card-body">
                    <label for="gender" class="form-label @error('gender') is-invalid @enderror">
                        Gender :
                    </label>
                    <input type="text" name="gender" placeholder="Enter Your Gender"
                        class="form-control mb-2">
                    @error('gender')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="card-body">
                    <label for="phone" class="form-label @error('phone') is-invalid @enderror">
                        Phone :
                    </label>
                    <input type="text" name="phone" placeholder="Enter Your Phone"
                        class="form-control mb-2">
                    @error('phone')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="card-body">
                    <label for="address" class="form-label @error('address') is-invalid @enderror">
                        Address :
                    </label>
                    <input type="text" name="address" placeholder="Enter Your Address"
                        class="form-control mb-2">
                    @error('address')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="card-body">
                    <label for="" class="form-label me-3">Active or Expired:</label>
                    <input type="checkbox" class="form-check-input mb-2" name="status" role="switch" checked>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm">+Create</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>
