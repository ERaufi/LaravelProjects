@extends('layouts.app')

@section('content')
    <div class="container">
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
                                <button id="add-task-todo" class="btn btn-info" onclick="showTaskModal('todo')">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body connectedSortable" id="todo">
                        <!-- Kanban Items for To Do -->

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
                                <button id="add-task-in_progress" class="btn btn-info" onclick="showTaskModal('in_progress')">+</button>
                            </div>
                        </div>
                    </div>



                    <div class="card-body connectedSortable" id="in_progress">
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
                                <button id="add-task-done" class="btn btn-info" onclick="showTaskModal('done')">+</button>
                            </div>
                        </div>
                    </div>


                    <div class="card-body connectedSortable" id="done">
                        <!-- Kanban Items for Done -->
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
    <script>
        var currentSection = '';
        var addOrUpdate = null;
        var selectedTask = null;

        $(function() {
            $.ajax({
                type: 'get',
                url: '{{ URL('kanban-board/get-all') }}',
                success: function(data) {
                    console.log(data);
                    data.map(x => {
                        appendItem(x);
                    })

                }
            });
        });


        function appendItem(item) {
            var newItem = `
                <div class="card mb-2 kanban-item">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p id="taskName" item_id="${item.id}">${item.name}</p>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-sm btn-warning edit-task"><i class='bx bx-comment-edit'></i></button>
                                <button class="btn btn-sm btn-danger delete-task"><i class='bx bx-comment-x'></i></button>
                            </div>
                        </div>
                    </div>
                </div>`;
            $("#" + item.status).append(newItem);
        }

        function reOrderKanbanOrder() {
            var tasks = [];
            $('.connectedSortable').each(function() {
                var sectionId = $(this).attr('id');
                $(this).children('.kanban-item').each(function(index) {
                    tasks.push({
                        id: $(this).find("#taskName").attr('item_id'),
                        name: $(this).find("#taskName").text(),
                        status: sectionId,
                        order: index
                    });
                });
            });

            $.post("{{ url('kanban-board/reorder') }}", {
                _token: "{{ csrf_token() }}",
                tasks: tasks
            }, function(response) {
                console.log(response);
            });
        }

        $(".connectedSortable").sortable({
            connectWith: ".connectedSortable",
            items: "> .kanban-item",
            placeholder: "ui-state-highlight",
            update: reOrderKanbanOrder,
        }).disableSelection();

        function showTaskModal(section) {
            currentSection = section;
            addOrUpdate = 'add';
            $('#taskModalLabel').text('Add Task');
            $('#task-name').val('');
            $('#taskModal').modal('show');
        }

        $('#save-task').click(function() {
            var taskName = $('#task-name').val();

            if (taskName) {
                if (addOrUpdate == 'add') {
                    $.post("{{ url('kanban-board/store') }}", {
                        _token: "{{ csrf_token() }}",
                        name: taskName,
                        status: currentSection,
                    }, function(response) {
                        appendItem(response.item);
                    });
                } else {
                    $.post("{{ url('kanban-board/update') }}", {
                        _token: "{{ csrf_token() }}",
                        name: taskName,
                        id: selectedTask.attr('item_id'),
                    }, function(response) {
                        selectedTask.text(taskName);
                    });
                }

                $('#taskModal').modal('hide');
            }
        });

        $(document).on('click', '.edit-task', function() {
            addOrUpdate = 'update';
            selectedTask = $(this).parent().parent().find("#taskName");
            $('#taskModalLabel').text('Edit Task');
            $('#task-name').val(selectedTask.text());
            $('#taskModal').modal('show');
        });

        $(document).on('click', '.delete-task', function() {
            if (confirm('Are you sure you want to delete this task?')) {
                let item = $(this);
                $.post("{{ url('kanban-board/delete') }}", {
                    _token: "{{ csrf_token() }}",
                    id: item.parent().parent().find("#taskName").attr('item_id'),
                }, function(response) {
                    item.parent().parent().parent().remove();
                });
            }
        });
    </script>
@endsection
