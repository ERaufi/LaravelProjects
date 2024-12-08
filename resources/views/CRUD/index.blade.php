<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Document</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>{{ __('Product List') }}</h1>
        </div>
    </div>
    {{-- Start Create Button================================================================== --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <a href="{{ route('products.create') }}" class="btn btn-success">{{ __('Create Product') }}</a>
        </div>
    </div>
    {{-- End Create Button================================================================== --}}
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered" width="100%">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th>{{ __('Buying Price') }}</th>
                        <th>{{ __('Selling Price') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->buyingPrice }}</td>
                            <td>{{ $product->sellingPrice }}</td>
                            <td>{{ $product->description }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary editButton">Edit</a>
                                <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger deleteButton"
                                        onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Start Pagination============================================================ --}}
    <div class="d-flex justify-content-center" id="paginiation">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
    {{-- End Pagination============================================================ --}}
</div>

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
        $('.notifyjs-corner').css('z-index', 999999);

    });
</script>
