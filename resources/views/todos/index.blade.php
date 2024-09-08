@extends('layouts.app')

@section('head')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .todo-app {
            margin-top: 50px;
            max-width: 700px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border-radius: 10px;
        }

        .input-section {
            margin-bottom: 20px;
        }

        #todoInput {
            border-top-left-radius: 50px;
            border-bottom-left-radius: 50px;
            padding-left: 20px;
        }

        #addBtn {
            border-top-right-radius: 50px;
            border-bottom-right-radius: 50px;
            background-color: #28a745;
            color: #fff;
        }

        #addBtn:hover {
            background-color: #218838;
        }

        #search-input {
            border-radius: 50px;
            padding-left: 20px;
        }

        .search {
            border-radius: 50px;
            background-color: #007bff;
            color: #fff;
        }

        .search:hover {
            background-color: #0056b3;
        }

        .todos {
            max-width: 100%;
        }

        .card {
            margin-bottom: 15px;
            border-radius: 10px;
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .card-body {
            padding: 20px;
        }

        .todo-title {
            font-size: 18px;
            font-weight: 500;
            color: #333;
        }

        .completed {
            text-decoration: line-through;
            color: gray;
        }

        .complete-btn {
            background-color: #28a745;
            color: white;
            border-radius: 50px;
        }

        .complete-btn[disabled] {
            background-color: #6c757d;
        }

        .edit-btn {
            background-color: #ffc107;
            color: white;
            border-radius: 50px;
        }

        .save-btn {
            background-color: #17a2b8;
            color: white;
            border-radius: 50px;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            border-radius: 50px;
        }

        .btn {
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="todo-app">
            <form class="input-section d-flex align-items-center" id="todoForm">
                <input id="todoInput" type="text" class="form-control" placeholder="Add item..." />
                <button id="addBtn" type="submit" class="btn add">Add</button>
                <input type="text" id="search-input" class="form-control ms-2" placeholder="Search" />
                <button type="button" id="search-button" class="btn search ms-2" onclick="getAll()">Search</button>
            </form>
            <div class="todos"></div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // let searchValue = null;

        // function search() {
        //     searchValue = $("#search-input").val();
        // }

        $(function() {
            getAll();
        });

        function getAll() {
            $.ajax({
                type: 'get',
                url: '{{ URL('todos/get-all') }}',
                data: {
                    'search': $("#search-input").val()
                },
                success: function(data) {
                    console.log(data);
                    $('.todos').empty();
                    data.forEach(todo => {
                        const completedClass = todo.completed ? 'completed' : '';
                        const completedBtnDisabled = todo.completed ? 'disabled' : '';

                        $('.todos').append(`
                            <div class="card" data-id="${todo.id}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span class="todo-title ${completedClass}">${todo.title}</span>
                                            <input type="text" class="edit-input form-control" value="${todo.title}" style="display:none;">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-success complete-btn" data-id="${todo.id}" ${completedBtnDisabled}>Complete</button>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-warning edit-btn" data-id="${todo.id}">Edit</button>
                                            <button class="btn btn-success save-btn" data-id="${todo.id}" style="display:none;">Save</button>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-danger delete-btn" data-id="${todo.id}">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }
            });
        }

        $(document).on('click', '.complete-btn', function() {
            const id = $(this).data('id');

            $.ajax({
                url: `{{ URL('todos/complete') }}`,
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function() {
                    getAll();
                }
            });
        });

        $(document).on('click', '.edit-btn', function() {
            const card = $(this).closest('.card');
            card.find('.todo-title').hide();
            card.find('.edit-input').show();
            $(this).hide();
            card.find('.save-btn').show();
        });

        $(document).on('click', '.save-btn', function() {
            const card = $(this).closest('.card');
            const id = $(this).data('id');
            const newTitle = card.find('.edit-input').val();
            $("#search-input").val('');
            $.ajax({
                url: `{{ URL('todos/update') }}`,
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    title: newTitle,
                },
                success: function() {
                    getAll();
                }
            });
        });

        $('#todoForm').on('submit', function(event) {
            event.preventDefault();
            const title = $('#todoInput').val();
            $("#search-input").val('');

            $.ajax({
                url: `{{ URL('todos/add') }}`,
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    'title': title,
                },
                success: function() {
                    getAll();
                    $('#todoInput').val('');
                    $('#update-button').hide();
                    $('#addBtn').show();
                }
            });
        });

        $(document).on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            $.ajax({
                url: `todos/delete`,
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    'id': id,
                },
                success: function() {
                    getAll();
                }
            });
        });
    </script>
@endsection
