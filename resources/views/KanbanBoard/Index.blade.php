@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col text-center">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2 class="text-center">Kanban Board</h2>
                <div class="row" id="kanban-board">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <div class="row">
                                    <div class="col-md-6">
                                        To Do
                                    </div>
                                    <div class="col-md-6" style="text-align: right">
                                        <button id="add-task-todo" class="btn btn-info">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body connectedSortable" id="todo">
                                <!-- Kanban Items for To Do -->
                                <div class="card mb-2 kanban-item" id="item-1">
                                    <div class="card-body">
                                        Task 1
                                        <div class="float-start">
                                            <button class="btn btn-sm btn-warning edit-task"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger delete-task"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-2 kanban-item" id="item-2">
                                    <div class="card-body">
                                        Task 2
                                        <div class="float-start">
                                            <button class="btn btn-sm btn-warning edit-task"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger delete-task"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-2 kanban-item" id="item-3">
                                    <div class="card-body">
                                        Task 3
                                        <div class="float-start">
                                            <button class="btn btn-sm btn-warning edit-task"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger delete-task"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-2 kanban-item" id="item-4">
                                    <div class="card-body">
                                        Task 4
                                        <div class="float-start">
                                            <button class="btn btn-sm btn-warning edit-task"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger delete-task"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <div class="row">
                                    <div class="col-md-6">
                                        In Progress
                                    </div>
                                    <div class="col-md-6" style="text-align: right">
                                        <button id="add-task-in-progress" class="btn btn-info">+</button>
                                    </div>
                                </div>
                            </div>



                            <div class="card-body connectedSortable" id="in-progress">
                                <!-- Kanban Items for In Progress -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <div class="row">
                                    <div class="col-md-6">
                                        Done
                                    </div>
                                    <div class="col-md-6" style="text-align: right">
                                        <button id="add-task-done" class="btn btn-info">+</button>
                                    </div>
                                </div>
                            </div>


                            <div class="card-body connectedSortable" id="done">
                                <!-- Kanban Items for Done -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Adding/Editing Task -->
        <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskModalLabel">Add Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="taskForm">
                            <div class="mb-3">
                                <label for="task-name" class="form-label">Task Name</label>
                                <input type="text" class="form-control" id="task-name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save-task">Save Task</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        $(function() {
            var currentSection = '';

            // Make the Kanban columns sortable
            $(".connectedSortable").sortable({
                connectWith: ".connectedSortable",
                items: "> .kanban-item",
                placeholder: "ui-state-highlight",
                update: function(event, ui) {
                    var todo = $("#todo").sortable("toArray");
                    var inProgress = $("#in-progress").sortable("toArray");
                    var done = $("#done").sortable("toArray");

                    // Handle AJAX request to update the order in the database
                    $.ajax({
                        url: "{{ url('kanban.update') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            todo: todo,
                            inProgress: inProgress,
                            done: done
                        },
                        success: function(response) {
                            console.log(response);
                        }
                    });
                }
            }).disableSelection();

            // Add Task Button Click
            $('#add-task-todo, #add-task-in-progress, #add-task-done').on('click', function() {
                var buttonId = $(this).attr('id');
                if (buttonId === 'add-task-todo') {
                    currentSection = '#todo';
                } else if (buttonId === 'add-task-in-progress') {
                    currentSection = '#in-progress';
                } else if (buttonId === 'add-task-done') {
                    currentSection = '#done';
                }
                $('#taskModalLabel').text('Add Task');
                $('#task-name').val('');
                $('#taskModal').modal('show');
            });

            // Save Task Button Click
            $('#save-task').on('click', function() {
                var taskName = $('#task-name').val();
                if (taskName) {
                    var newItem = `<div class="card mb-2 kanban-item">
                                        <div class="card-body">
                                            ${taskName}
                                            <div class="float-start">
                                                <button class="btn btn-sm btn-warning edit-task"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-danger delete-task"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div>
                                   </div>`;
                    $(currentSection).append(newItem);
                    $('#taskModal').modal('hide');
                }
            });

            // Edit Task Button Click
            $(document).on('click', '.edit-task', function() {
                var taskItem = $(this).closest('.kanban-item');
                var taskName = taskItem.find('.card-body').text().trim();
                $('#taskModalLabel').text('Edit Task');
                $('#task-name').val(taskName);
                $('#taskModal').modal('show');

                $('#save-task').off('click').on('click', function() {
                    taskItem.find('.card-body').text($('#task-name').val());
                    taskItem.find('.card-body').append(`
                        <div class="float-start">
                            <button class="btn btn-sm btn-warning edit-task"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger delete-task"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    `);
                    $('#taskModal').modal('hide');
                });
            });

            // Delete Task Button Click
            $(document).on('click', '.delete-task', function() {
                if (confirm('Are you sure you want to delete this task?')) {
                    $(this).closest('.kanban-item').remove();
                }
            });
        });
    </script>
@endsection
