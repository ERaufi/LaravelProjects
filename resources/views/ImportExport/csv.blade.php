<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <p>Export and Import From CSV</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ URL('export-csv') }}">Export</a>
                    </div>
                    <div class="col-md-6">
                        <form method="POST" action="{{ URL('import-csv') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="csv_file">Upload CSV File:</label>
                                <input type="file" name="csv_file" accept=".csv">
                            </div>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
