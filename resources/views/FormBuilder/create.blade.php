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
        jQuery(function($) {
            $(document.getElementById('fb-editor')).formBuilder({
                onSave: function(evt, formData) {
                    console.log(formData);
                    saveForm(formData);
                },
            });
        });

        function saveForm(form) {
            $.ajax({
                type: 'post',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                url: '{{ URL('save-form-builder') }}',
                data: {
                    'form': form,
                    'name': $("#name").val(),
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    location.href = "/form-builder";
                    console.log(data);
                }
            });
        }
    </script>
@endsection
