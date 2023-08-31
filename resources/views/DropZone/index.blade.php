<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .drop-zone {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            text-align: center;
        }

        .drop-zone.active {
            border: 2px dashed #3490dc;
        }

        #progressBar {
            width: 100%;
            height: 10px;
            background-color: #f0f0f0;
            border-radius: 4px;
            margin-top: 10px;
            overflow: hidden;
        }

        #progress {
            height: 100%;
            background-color: #3490dc;
            width: 0;
        }

        .img-thumbnail {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 4px;
            max-width: 100px;
            max-height: 100px;
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center">Image Upload</h2>
                <div id="drop-zone" class="drop-zone border">
                    <span class="drop-text">Drag and drop files here or click to select files</span>
                </div>
            </div>
        </div>

        <div class="progress mt-3">
            <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>
        <div id="uploaded-images" class="mt-3 d-flex flex-wrap"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            var dropZone = document.getElementById('drop-zone');
            var progressBar = document.getElementById('progress-bar');
            var uploadedImages = document.getElementById('uploaded-images');

            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                dropZone.classList.add('active');
            });

            dropZone.addEventListener('dragleave', function() {
                dropZone.classList.remove('active');
            });

            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                dropZone.classList.remove('active');
                var files = e.dataTransfer.files;
                uploadImages(files, 0);
            });

            function uploadImages(files, index) {
                if (index >= files.length) {
                    return;
                }

                var formData = new FormData();
                formData.append('images[]', files[index]);
                $.ajax({
                    type: 'POST',
                    url: '/drop-zone',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(event) {
                            if (event.lengthComputable) {
                                var percent = (event.loaded / event.total) * 100;
                                progressBar.style.width = percent + '%';
                                progressBar.textContent = percent.toFixed(2) + '%';
                            }
                        });
                        return xhr;
                    },
                    success: function(response) {
                        progressBar.style.width = '0%';
                        progressBar.textContent = '0%';

                        var imageThumbnail = document.createElement('img');
                        imageThumbnail.src = `{{ URL::asset('images') }}/` + response.filename;
                        imageThumbnail.className = 'img-thumbnail mr-2';
                        uploadedImages.appendChild(imageThumbnail);

                        uploadImages(files, index + 1);
                    }
                });
            }
        });
    </script>

</body>

</html>
