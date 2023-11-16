@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/cropperjs/cropper.min.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .label {
            cursor: pointer;
        }

        .progress {
            display: none;
            margin-bottom: 1rem;
        }

        .alert {
            display: none;
        }

        .img-container img {
            max-width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <h1>Upload cropped image to server</h1>

        <img class="rounded" id="profile-img" src="https://avatars0.githubusercontent.com/u/3456749?s=160" alt="avatar">

        <label class="label custom-file-upload btn btn-primary ml-3">
            <input type="file" class="d-none" id="file-input" name="image" accept="image/*">
            Select Image
        </label>

        <div class="modal fade" id="cropAvatarmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Crop the image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <img id="uploadedAvatar" src="https://avatars0.githubusercontent.com/u/3456749">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="crop">Save And Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/cropperjs/cropper.min.js') }}"></script>
    <script>
        $(function() {
            // Select the image element with the ID 'uploadedAvatar'
            var image = $('#uploadedAvatar')[0];

            // Declare a variable to hold the Cropper instance
            var cropper;

            // Triggered when the file input field changes (when a user selects an image)
            $("#file-input").on('change', function(event) {
                // Get the selected files from the input field
                var files = event.target.files;

                // Define a function to be executed when image loading is done
                var done = function(url) {
                    // Set the source of the image element to the provided URL
                    image.src = url;

                    // Show the modal for cropping
                    $('#cropAvatarmodal').modal('show');
                };

                // Check if files were selected and at least one file is present
                if (files && files.length > 0) {
                    // Get the first file from the selected files
                    let file = files[0];

                    // Create a new FileReader instance to read the file content
                    reader = new FileReader();

                    // Define a callback function to be executed when the file reading is completed
                    reader.onload = function(e) {
                        // Call the 'done' function with the result of reading the file (URL)
                        done(reader.result);
                    };

                    // Read the file as a data URL, triggering the onload callback when done
                    reader.readAsDataURL(file);
                }
            });

            // Event handlers for the 'shown.bs.modal' and 'hidden.bs.modal' events of the cropping modal
            $('#cropAvatarmodal').on('shown.bs.modal', function() {
                // Initialize a new Cropper instance on the selected image
                cropper = new Cropper(image, {
                    aspectRatio: 1, // Set the aspect ratio of the crop box (square in this case)
                    viewMode: 3, // Set the view mode of the cropper (3 means display within the container, no restrictions)
                });
            }).on('hidden.bs.modal', function() {
                // When the modal is hidden, destroy the Cropper instance and set it to null
                cropper.destroy();
                cropper = null;
            });


            $("#crop").on('click', function() {
                var canvas;
                $('#cropAvatarmodal').modal('hide');
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
                        url: "{{ url('upload-cropped-image') }}", // Change this URL to your Laravel route
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
                }
            });
        })
    </script>
@endsection
