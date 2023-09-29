<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <p>Export and Import From CSV</p>
    <br>
    <br>
    <a href="{{ URL('export-csv') }}">Export</a>
    <br>
    <br>

    <form method="POST" action="{{ URL('import-csv') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="csv_file">Upload CSV File:</label>
            <input type="file" name="csv_file" accept=".csv">
        </div>
        <button type="submit" class="btn btn-primary">Import</button>
    </form>

</body>

</html>
