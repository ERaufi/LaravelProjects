<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Include Toastr.js library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

</head>

<body>
    <label>Export</label>
    <input type="button" value="Export" onclick="exportExcel()" />


    <form id="importForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".xlsx, .xls">
        <button type="button" onclick="importExcel()">Import</button>
    </form>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    function exportExcel() {
        location.href = "{{ URL('prodcts/export/') }}";
    }

    function importExcel() {
        // Disable the form while processing
        $('#importForm').attr('disabled', 'disabled');

        // Create a new FormData object to send the file
        var formData = new FormData($('#importForm')[0]);

        // Send the AJAX request
        $.ajax({
            url: "{{ URL('/products/import') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Enable the form after processing
                $('#importForm').removeAttr('disabled');

                // Check if the import was successful
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Enable the form after processing
                $('#importForm').removeAttr('disabled');

                // Handle AJAX errors
                toastr.error('An error occurred while importing data.');
            }
        });
    }
</script>

</html>
