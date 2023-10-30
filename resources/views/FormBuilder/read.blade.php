@extends('layouts.app')
@section('head')
    <title>Example formBuilder</title>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ URL('save-form-transaction') }}">
                @csrf
                <input type="number" id="form_id" name="form_id" />
                <div id="fb-reader"></div>
                <input type="submit" value="Save" class="btn btn-success" />
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="{{ URL::asset('assets/form-builder/form-render.min.js') }}"></script>
    <script>
        $(function() {
            $.ajax({
                type: 'get',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                url: '{{ URL('get-form-builder') }}',
                data: {
                    'id': 1
                },
                success: function(data) {
                    $("#form_id").val(data.id);
                    $('#fb-reader').formRender({
                        formData: data.content
                    });
                }
            });
        });
    </script>
@endsection
