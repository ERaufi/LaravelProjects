@extends('layouts.app')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap-5.3.2-dist/css/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/datatables.min.css') }}">
    {{-- Start Adding Button ------------------------------------------------------------------------------------------------------- --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/Buttons-2.4.2/css/buttons.dataTables.min.css') }}">
    {{-- End Adding Button ------------------------------------------------------------------------------------------------------- --}}
    {{-- Start Row ReOrdering------------------------------------------------------------------------------------------------------ --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/RowReorder-1.4.1/css/rowReorder.dataTables.min.css') }}">
    {{-- End Row ReOrdering------------------------------------------------------------------------------------------------------ --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <h2>{{__('Countries DataTable')}}</h2>
    <div class="card">
        <div class="card-body">
            <table id="countries-table" class="table">
                <thead>
                    <tr>
                        <th>{{__('ID')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Order Number')}}</th>
                        <th>{{__('Created At')}}</th>
                        <th>{{__('Updated At')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    {{-- Start Adding Button ------------------------------------------------------------------------------------------------------- --}}
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/DataTables/Buttons-2.4.2/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/DataTables/JSZip-3.10.1/jszip.min.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/DataTables/pdfmake-0.2.7/pdfmake.min.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/DataTables/pdfmake-0.2.7/vfs_fonts.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/DataTables/Buttons-2.4.2/js/buttons.html5.min.js') }}"></script>
    {{-- End Adding Button ------------------------------------------------------------------------------------------------------- --}}

    {{-- Start Row ReOrdering------------------------------------------------------------------------------------------------------ --}}
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/DataTables/RowReorder-1.4.1/js/dataTables.rowReorder.min.js') }}"></script>
    {{-- End Row ReOrdering------------------------------------------------------------------------------------------------------ --}}

    <script>
        $(document).ready(function() {
            var table = $('#countries-table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ URL('countries') }}",
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "order_number"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "updated_at"
                    },
                    {
                        render: function(data, type, row) {
                            return `<input type="button" class="btn btn-success edit-btn" value="Edit"/>
                            <input type="button" class="btn btn-danger" value="Delete"/>
                            `;
                        },
                    }
                ],
                order: [
                    [2, 'asc']
                ],
                "pageLength": 25,
                // Start Adding Buttons -----------------------------------
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                // End Adding Buttons ------------------------------------

                // Enable inline editing for the 'Name' column -------------------
                "columnDefs": [{
                    "targets": 1, // 'Name' column index
                    "render": function(data, type, row) {
                        return `<div class="editable" data-name="name" data-pk="${row.id}">${data}</div>`;
                    }
                }],

                // Enable Row Reordering based on 'Order Number' column ----------
                rowReorder: {
                    dataSrc: 'order_number',
                    update: false, // Prevent automatic update after reorder
                },
            });

            // Handle inline editing on button click ----------------------------
            $('#countries-table').on('click', '.edit-btn', function() {
                var $this = $(this);
                var $editable = $this.closest('tr').find('.editable');

                // Check if the cell is already in edit mode
                if (!$editable.hasClass('editing')) {
                    // Enter edit mode
                    var currentValue = $editable.text().trim();
                    $editable.addClass('editing');
                    $editable.html(`<input type="text" class="form-control" value="${currentValue}"/>`);
                }
            });

            // Handle focusout event to exit edit mode -------------------------
            $('#countries-table').on('focusout', '.editable input', function() {
                var $this = $(this);
                var $editable = $this.closest('.editable');
                var pk = $editable.data('pk');
                var name = $editable.data('name');
                var value = $this.val();

                // Update the table cell if a new value is provided ----------------
                $.ajax({
                    url: '{{ URL('countries/update') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: pk,
                        name: value
                    },
                    success: function(response) {
                        // Handle success
                        console.log(response);
                        // Update the cell in the DataTable
                        table.cell($editable).data(value);
                    },
                    error: function(error) {
                        // Handle error
                        console.error(error);
                    }
                });

                // Exit edit mode
                $editable.removeClass('editing');
                $editable.html(value);
            });

            // End inline Editing ---------------------------------------------





            // Start Reordering Rows
            table.on('row-reorder', function(e, diff, edit) {
                for (var i = 0, ien = diff.length; i < ien; i++) {
                    var rowData = table.row(diff[i].node).data();
                    rowData.order_number = diff[i].newData;
                    table.row(diff[i].node).data(rowData);
                }

                // Get the new order of the rows
                var newOrder = table.rows().data().toArray().map(function(row) {
                    return row.order_number;
                });

                var ids = table.rows().data().toArray().map(function(row) {
                    return row.id;
                });

                $(function() {
                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ URL('countries/reordering') }}',
                        data: {
                            id: ids,
                            order_number: newOrder
                        },
                        success: function(data) {
                            console.log(data);
                        }
                    });
                });
            });

            // End Reordering Rows
        });
    </script>
@endsection
