@extends('layouts.app')
@section('head')
    <title>{{__('Example formBuilder')}}</title>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <label for="name">{{__('Name')}}</label>
            <input type="text" id="name" name="name" class="form-control" />
            <div id="fb-editor"></div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="{{ URL::asset('assets/form-builder/form-builder.min.js') }}"></script>
    <script>
        var fbEditor = document.getElementById('fb-editor');
        var formBuilder = $(fbEditor).formBuilder({
            onSave: function(evt, formData) {
                saveForm(formData);
            },
        });

        $(function() {
            $.ajax({
                type: 'get',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                url: '{{ URL('get-form-builder-edit') }}',
                data: {
                    'id': '{{ $id }}'
                },
                success: function(data) {
                    $("#name").val(data.name);
                    formBuilder.actions.setData(data.content);
                }
            });
        });

        function saveForm(form) {
            $.ajax({
                type: 'post',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                url: '{{ URL('update-form-builder') }}',
                data: {
                    'form': form,
                    'name': $("#name").val(),
                    'id': {{ $id }},
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    location.href = "/form-builder";
                }
            });
        }
    </script>
@endsection
