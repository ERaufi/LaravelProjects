@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/cropperjs/cropper.min.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .label {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <h1>Upload cropped image to server</h1>

        <div class="img-container">
            <img class="rounded" id="profile-img">
        </div>

        <label class="label custom-file-upload btn btn-primary ml-3">
            <input type="file" class="d-none" id="file-input" name="image" accept="image/*">
            Select Image
        </label>

        <button type="button" class="btn btn-primary" id="crop">Save And Upload</button>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/cropperjs/cropper.min.js') }}"></script>
    <script>
        $(function() {
            // Select the image element with the ID 'profile-img'
            var image = $('#profile-img')[0];

            // Declare a variable to hold the Cropper instance
            var cropper;

            // Triggered when the file input field changes (when a user selects an image)
            $("#file-input").on('change', function(event) {
                // Get the selected files from the input field
                var files = event.target.files;

                // Check if files were selected and at least one file is present
                if (files && files.length > 0) {
                    // Get the first file from the selected files
                    let file = files[0];

                    // Create a new FileReader instance to read the file content
                    reader = new FileReader();

                    // Define a callback function to be executed when the file reading is completed
                    reader.onload = function(e) {
                        // Set the source of the image element to the result of reading the file (URL)
                        image.src = e.target.result;

                        // Initialize a new Cropper instance on the selected image
                        cropper = new Cropper(image, {
                            // Set the aspect ratio of the crop box (square in this case)
                            aspectRatio: 1,
                            // Set the view mode of the cropper (3 means display within the container, no restrictions)
                            viewMode: 3,
                        });
                    };

                    // Read the file as a data URL, triggering the onload callback when done
                    reader.readAsDataURL(file);
                }
            });

            // Event handler for the "Save And Upload" button
            $("#crop").on('click', function() {
                var canvas;
                if (cropper) {
                    canvas = cropper.getCroppedCanvas({
                        width: 160,
                        height: 160,
                    });

                    // Convert the canvas content to a data URL
                    var imageData = canvas.toDataURL();

                    // Send the cropped image data to the server using AJAX
                    $.ajax({
                        type: "POST",
                        url: "{{ url('upload-cropped-image') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            image: imageData
                        },
                        success: function(response) {
                            // Handle the response from the server, if needed
                            console.log(response);
                        },
                        error: function(error) {
                            // Handle the error, if any
                            console.error(error);
                        }
                    });

                    // Update the profile image on the front-end
                    $("#profile-img").attr('src', imageData);

                    // Destroy the Cropper instance after cropping
                    cropper.destroy();
                }
            });
        })
    </script>
@endsection
