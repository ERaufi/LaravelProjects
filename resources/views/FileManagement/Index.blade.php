@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .files {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
        }

        .file-item {
            text-align: center;
        }

        .file-item i {
            font-size: 48px;
            margin-bottom: 10px;
            color: #007bff;
            /* Blue color */
        }

        .file-item span {
            display: block;
            font-size: 14px;
            color: #333;
        }

        .context-menu {
            display: none;
            position: absolute;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .context-menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .context-menu ul li {
            padding: 10px 20px;
            cursor: pointer;
        }

        .context-menu ul li:hover {
            background: #f0f0f0;
        }

        input[type="file"] {
            display: none;
        }

        .custom-file-upload {
            border: 1px solid #5bf635;
            /* color: #5bf635; */
            background-color: #5bf635;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <h2 class="text-center mb-4">File Management Demo</h2>
        <div class="row">
            <div class="col-md-2">
                <form id="upload-form" method="POST" enctype="multipart/form-data">
                    <label for="file-upload" class="custom-file-upload">
                        Upload your files
                    </label>
                    <input id="file-upload" type="file" multiple />
                </form>
            </div>
            <div class="col-md-10">
                <input type="button" value="{{ __('Back') }}" id="backButton" class="btn btn-success" onclick="back()" hidden />
                <input type="button" value="{{ __('Create File') }}" class="btn btn-success" onclick="createFile()" />
                <input type="button" value="{{ __('Create Folder') }}" id="folderCreate" class="btn btn-success" onclick="createFolder()">
                <input type="button" value="{{ __('Paste') }}" id="paste" class="btn btn-success" onclick="paste()" hidden>
                <input type="button" value="{{ __('Zip This Folder') }}" class="btn btn-success" onclick="zipFolder()">
            </div>

        </div>

        <div class="card">
            <div class="card-body">
                <div class="files">

                </div>
            </div>
        </div>



        <!-- Context Menu -->
        <div class="context-menu" id="contextMenu">
            <ul>
                <li onclick="rename()">Rename</li>
                <li onclick="cutAndCopy('cut')">Cut</li>
                <li onclick="cutAndCopy('copy')">Copy</li>
                <li onclick="paste()" id="paste" hidden>Paste</li>
                <li onclick="downloadItem()">Download</li>
                <li onclick="deleteItem()">Delete</li>
            </ul>
        </div>

    </div>
@endsection




@section('script')
    <script>
        let currentPath = '';
        let copiedItem = null;
        let isCopy = null;
        let address = [];

        function getAllFilesAndFolders() {
            $.ajax({
                type: 'get',
                url: '{{ URL('file-management/get-all') }}',
                data: {
                    'path': currentPath,
                },
                success: function(data) {
                    // Empty the files div
                    $('.files').empty();
                    displayFilesAndFolders(data.directories, 'folder', data.path);
                    displayFilesAndFolders(data.files, 'file', data.path);
                    currentPath = data.path;


                    if (currentPath != address.at(-1)) {
                        address.push(data.path);
                    }

                    if (address.length > 1) {
                        $("#backButton").attr('hidden', false);
                    } else {
                        $("#backButton").attr('hidden', true);
                    }
                }
            });
        }

        function back() {
            address.pop();
            currentPath = address.at(-1);
            getAllFilesAndFolders();
        }

        function displayFilesAndFolders(data, type, path) {
            // Define mapping of file extensions to icon classes
            const iconMappings = {
                'jpg': 'fas fa-image',
                'png': 'fas fa-image',
                'gif': 'fas fa-image',
                'bmp': 'fas fa-image',
                'zip': 'fas fa-file-archive',
                'doc': 'fas fa-file-word',
                'docx': 'fas fa-file-word',
                'xls': 'fas fa-file-excel',
                'xlsx': 'fas fa-file-excel'
                // Add more mappings as needed
            };

            var html = '';
            data.map(item => {
                var iconClass = 'fas fa-folder';
                if (type != 'folder') {
                    iconClass = iconMappings[item.split('.').pop().toLowerCase()] || 'fas fa-file'; // Default to file icon
                }

                html += `<div class="file-item" data-name="${item}" data-type="${type}" data-path="${path}">
            <i style="cursor:pointer" onclick="changePath('${item}')" class="${iconClass}" oncontextmenu="showContextMenu(event)"></i>
            <span style="cursor:pointer" oncontextmenu="showContextMenu(event)">${item}</span>
            </div>`;
            });
            $('.files').append(html);
        }

        function changePath(path) {
            currentPath = path;
            getAllFilesAndFolders();

        }
        // Call getAllFilesAndFolders function when the page loads
        $(document).ready(function() {
            getAllFilesAndFolders();
        });

        // Show context menu
        function showContextMenu(event) {
            event.preventDefault();
            var contextMenu = document.getElementById('contextMenu');
            contextMenu.style.display = 'block';
            contextMenu.style.left = event.pageX + 'px';
            contextMenu.style.top = event.pageY + 'px';

            // Store the selected item data in the context menu element
            var selectedItem = $(event.target).closest('.file-item');
            $('.context-menu').data('selectedItem', selectedItem);
        }

        // Hide context menu
        document.addEventListener('click', function(event) {
            closeContextMenu(event);
        });


        function closeContextMenu(event) {
            var contextMenu = document.getElementById('contextMenu');
            if (!event || !event.target.closest('.context-menu')) {
                contextMenu.style.display = 'none';
                document.removeEventListener('click', closeContextMenu); // Remove the event listener
            }
        }



        function createFile() {
            let name = 'test file';
            let data = {
                'fileName': 'test',
                'fileContent': 'this is just test',
            };
            postAjax("{{ URL('file-management/create-file') }}", data)
        }

        function createFolder() {
            let data = {
                'folderName': 'testing',
            };
            postAjax("{{ URL('file-management/create-folder') }}", data)
        }

        function rename() {
            var selectedItem = $('.context-menu').data('selectedItem');
            var oldName = selectedItem.data('name');
            var type = selectedItem.data('type');

            let name = 'test file';
            let data = {
                'oldName': oldName,
                'newName': 'new_test',
            };
            postAjax("{{ URL('file-management/rename') }}", data);
        }


        function cutAndCopy(cutOrCopy) {

            var selectedItem = $('.context-menu').data('selectedItem');
            copiedItem = selectedItem.data('name');
            if (cutOrCopy == 'copy') {
                isCopy = 1;
            } else {
                isCopy = 0;
            }
            $("#paste").attr('hidden', false);
            closeContextMenu();
        }

        function paste() {
            let data = {
                'source': copiedItem,
                'destination': currentPath,
                'isCopy': isCopy,
            };
            postAjax("{{ URL('file-management/paste') }}", data);
            $("#paste").attr('hidden', true);
            copiedItem = null;
            isCopy = null;
        }


        function zipFolder() {
            let data = {
                'folderToZip': currentPath,
            };
            postAjax("{{ URL('file-management/zip-folder') }}", data);
        }

        function downloadItem() {
            var selectedItem = $('.context-menu').data('selectedItem');
            var name = selectedItem.data('name');
            var encodedName = encodeURIComponent(name); // Encode the file name
            window.open("{{ URL('file-management/download') }}?encoded_file_name=" + encodedName, "_blank");
        }



        function deleteItem() {
            var selectedItem = $('.context-menu').data('selectedItem');
            var name = selectedItem.data('name');
            let data = {
                'name': name,
            };
            postAjax("{{ URL('file-management/delete') }}", data);
        }


        function postAjax(url, data) {
            data['_token'] = "{{ csrf_token() }}";
            data['path'] = currentPath;
            $.ajax({
                type: 'post',
                url: url,
                data: data,
                success: function(data) {
                    getAllFilesAndFolders();
                    closeContextMenu();
                }
            });
        }


        $(document).ready(function() {
            $('#file-upload').on('change', function() {
                var formData = new FormData();
                var files = $(this)[0].files;

                for (var i = 0; i < files.length; i++) {
                    formData.append('files[]', files[i]);
                }

                // Add CSRF token directly to FormData
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('path', currentPath);
                $.ajax({
                    url: 'file-management/upload',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        getAllFilesAndFolders();
                        // Handle success response
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Handle error
                    }
                });
            });
        });
    </script>
@endsection
