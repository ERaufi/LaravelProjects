@extends('layouts.app')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
@endsection

@section('content')
    <div id="image-container"></div>
    <button id="load-images">Load Images</button>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
    <script>
        $(document).ready(function() {
            $('#load-images').on('click', function() {
                $.ajax({
                    url: '/lazy-load-data',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            $('#image-container').empty();
                            data.map(x => {
                                console.log(x.filename);
                                $('#image-container').append(
                                    `<img class="lazyload" style="width:30%" data-src="{{ URL::asset('images') }}/${x.filename}">`
                                );
                            });
                            lazyload();
                        } else {
                            $('#image-container').html('No images found.');
                        }
                    },
                    error: function() {
                        $('#image-container').html('Error loading images.');
                    }
                });
            });
        });
    </script>
@endsection
