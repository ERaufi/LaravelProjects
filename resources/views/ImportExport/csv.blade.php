<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>

<div class="container">
    <div class="card">
        <div class="card-header">
            <p>{{ __('Export and Import From CSV') }}</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ URL('export-csv') }}">{{ __('Export') }}</a>
                </div>
                <div class="col-md-6">
                    <form method="POST" action="{{ URL('import-csv') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="csv_file">{{ __('Upload CSV File:') }}</label>
                            <input type="file" name="csv_file" accept=".csv">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Import') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
