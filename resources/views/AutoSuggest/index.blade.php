@extends('layouts.app')
@section('head')
    <title>Laravel Auto Suggest Search</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        html,
        body {
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: linear-gradient(to right, #fc5c7d, #6a82fb);
            overflow: hidden;
        }

        /* Style the input field */
        input#searchInput {
            border-color: blue;
        }
    </style>
@endsection

@section('content')
    <div class="container text-center">
        <h1>Stack Tips</h1>
        <h1>{{__('Laravel Auto Suggest Search')}}</h1>
        <input id="searchInput" class="form-control" type="text">
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#searchInput").autocomplete({
                source: function(request, response) {
                    $.getJSON("search", {
                        query: request.term
                    }, function(data) {
                        response($.map(data, function(item) {
                            return {
                                value: item.name
                            };
                        }));
                    });
                }
            });
        });
    </script>
@endsection
