@extends('layouts.app')
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Select2</h2>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Simple Select2</h3>
                            </div>
                            <div class="card-body">
                                <label for='countries'>{{ __('countries') }}</label>
                                <select id='countries' name='countries' class='form-control'>
                                    <option>{{ __('Select Country') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->code }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Simple Depend</h3>
                            </div>
                            <div class="card-body">
                                <label for='cities'>{{ __('Cities') }}</label>
                                <select id='cities' name='cities' class='form-control'>
                                    <option>{{ __('Select City') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>



                <hr />
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Ajax Select2</h3>
                            </div>
                            <div class="card-body">
                                <label for='ajaxCountries'>{{ __('countries') }}</label>
                                <select id='ajaxCountries' name='ajaxCountries' class='form-control'>
                                    <option>{{ __('Select Country') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Depend Ajax Select2</h3>
                            </div>
                            <div class="card-body">
                                <label for='ajaxCities'>{{ __('Cities') }}</label>
                                <select id='ajaxCities' name='ajaxCities' class='form-control'>
                                    <option>{{ __('Select City') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#countries").select2();
            $("#cities").select2();

            $("#countries").on('change', function() {
                $("#cities").empty();
                let code = $(this).find('option:selected').val();
                $.ajax({
                    type: 'get',
                    url: '{{ URL('select2/get-cities') }}',
                    data: {
                        'country_code': code,
                    },
                    success: function(data) {
                        data.map(x => {
                            $("#cities").append(`<option value="${x.id}">${x.name}</option>`)
                        })
                    }
                });
            });


            $("#ajaxCountries").select2({
                ajax: {
                    url: '{{ URL('select2/search-countries') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            search: params.term,
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.code,
                                    text: item.name
                                };
                            })
                        };
                    },
                    cache: true,
                },
                placeholder: '{{ __('Select Country') }}',
                minimumInputLength: 2
            }).on('change', function() {
                var country = $(this).val();

                $("#ajaxCities").empty().trigger('change');

                if (country) {
                    $("#ajaxCities").select2({
                        ajax: {
                            url: '{{ URL('select2/search-cities') }}',
                            dataType: 'json',
                            data: function(params) {
                                return {
                                    country: country,
                                    search: params.term
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: data.map(function(item) {
                                        return {
                                            id: item.id,
                                            text: item.name
                                        };
                                    })
                                }
                            },
                            cache: true,
                        },
                        placeholder: '{{ __('Select City') }}',
                        minimumInputLength: 1
                    })
                }
            })
        });
    </script>
@endsection
