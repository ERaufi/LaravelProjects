@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
@endsection
@section('content')
    <div class="container mt-5">
        <h2>Test Page for Laravel Dusk</h2>

        <!-- Text Input -->
        <div class="mb-3">
            <label for="modal_text_input" class="form-label">Text Input:</label>
            <input type="text" class="form-control" id="modal_text_input" name="modal_text_input" placeholder="Enter text">
        </div>

        <!-- Select Option -->
        <div class="mb-3">
            <label for="modal_select_option" class="form-label">Select Option:</label>
            <select class="form-select" id="modal_select_option" name="modal_select_option">
                <option value="option1">Option 1</option>
                <option value="option2">Option 2</option>
                <option value="option3">Option 3</option>
            </select>
        </div>

        <!-- Radio Buttons -->
        <div class="mb-3">
            <label class="form-label">Radio Buttons:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="modal_radio_options" id="modal_radio_option1" value="option1">
                <label class="form-check-label" for="modal_radio_option1">Radio Option 1</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="modal_radio_options" id="modal_radio_option2" value="option2">
                <label class="form-check-label" for="modal_radio_option2">Radio Option 2</label>
            </div>
        </div>

        <!-- Checkboxes -->
        <div class="mb-3">
            <label class="form-label">Checkboxes:</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="modal_checkbox1" id="modal_checkbox1" name="modal_checkbox_options[]">
                <label class="form-check-label" for="modal_checkbox1">Checkbox 1</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="modal_checkbox2" id="modal_checkbox2" name="modal_checkbox_options[]">
                <label class="form-check-label" for="modal_checkbox2">Checkbox 2</label>
            </div>
        </div>

        <!-- Date Picker -->
        <div class="mb-3">
            <label for="modal_date_picker" class="form-label">Date Picker:</label>
            <input type="text" class="form-control datepicker" id="modal_date_picker" name="modal_date_picker" placeholder="Select a date">
        </div>

        <!-- File Upload -->
        <div class="mb-3">
            <label for="modal_file_upload" class="form-label">File Upload:</label>
            <input type="file" class="form-control" id="modal_file_upload" name="modal_file_upload">
        </div>


















        <!-- Bootstrap Modal Trigger Button -->
        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Open Bootstrap Modal
        </button>

        <!-- Bootstrap Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form inside the Modal -->
                        <form id="modalForm">
                            <!-- Text Input -->
                            <div class="mb-3">
                                <label for="modal_text_input" class="form-label">Text Input:</label>
                                <input type="text" class="form-control" id="modal_text_input" name="modal_text_input" placeholder="Enter text">
                            </div>

                            <!-- Select Option -->
                            <div class="mb-3">
                                <label for="modal_select_option" class="form-label">Select Option:</label>
                                <select class="form-select" id="modal_select_option" name="modal_select_option">
                                    <option value="option1">Option 1</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                </select>
                            </div>

                            <!-- Radio Buttons -->
                            <div class="mb-3">
                                <label class="form-label">Radio Buttons:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="modal_radio_options" id="modal_radio_option1" value="option1">
                                    <label class="form-check-label" for="modal_radio_option1">Radio Option 1</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="modal_radio_options" id="modal_radio_option2" value="option2">
                                    <label class="form-check-label" for="modal_radio_option2">Radio Option 2</label>
                                </div>
                            </div>

                            <!-- Checkboxes -->
                            <div class="mb-3">
                                <label class="form-label">Checkboxes:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="modal_checkbox1" id="modal_checkbox1"
                                        name="modal_checkbox_options[]">
                                    <label class="form-check-label" for="modal_checkbox1">Checkbox 1</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="modal_checkbox2" id="modal_checkbox2"
                                        name="modal_checkbox_options[]">
                                    <label class="form-check-label" for="modal_checkbox2">Checkbox 2</label>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submitModalForm()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>




        <!-- Additional Elements for Testing -->
        <div class="mt-3">
            <label>Additional Elements for Testing:</label>
            <!-- Alert Button -->
            <button type="button" class="btn btn-warning" onclick="showAlert()">Show Alert</button>

            <!-- Confirm Dialog Button -->
            <button type="button" class="btn btn-danger" onclick="showConfirmDialog()">Show Confirm Dialog</button>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });

        function showAlert() {
            // Show an alert
            alert("This is a sample alert!");
        }

        function showConfirmDialog() {
            // Show a confirm dialog
            var result = confirm("Do you want to proceed?");
            if (result) {
                // User clicked 'OK'
                alert("You clicked OK!");
            } else {
                // User clicked 'Cancel'
                alert("You clicked Cancel!");
            }
        }
    </script>
@endsection
