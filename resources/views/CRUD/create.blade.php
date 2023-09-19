<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


</head>

<body>
    <div class="container">
        <a href="/products">Products</a>

        <h1>Create Product</h1>

        <form method="POST" action="{{ route('products.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <label for="name">Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                </div>
                <div class="col-md-3">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}">
                </div>
                <div class="col-md-3">
                    <label for="buyingPrice">Buying Price:</label>
                    <input type="number" name="buyingPrice" class="form-control" value="{{ old('buyingPrice') }}">
                </div>
                <div class="col-md-3">
                    <label for="sellingPrice">Selling Price:</label>
                    <input type="number" name="sellingPrice" class="form-control" value="{{ old('sellingPrice') }}">
                </div>
                <div class="col-md-3">
                    <label for="image_url">Image URL:</label>
                    <input type="text" name="image_url" class="form-control" value="{{ old('image_url') }}">
                </div>
                <div class="col-md-3">
                    <label for="weight">Weight (in kg):</label>
                    <input type="number" name="weight" step="0.01" class="form-control" value="{{ old('weight') }}">
                </div>
                <div class="col-md-3">
                    <label for="description">Description:</label>
                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{ asset('assets/notify.min.js') }}"></script>


<script>
    $(document).ready(function($) {
        // Start Show Validation Error messages==========================================================
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                $.notify("{{ $error }}", "error");
            @endforeach
        @endif
        // End Show Validation Error messages==========================================================

        // Start Show Success message ====================================================================
        @if (session('success'))
            $.notify("{{ session('success') }}", "success");
        @endif
        // End Show Success message ====================================================================
    });
</script>

</html>
