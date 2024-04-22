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
    </style>
@endsection
@section('content')
    <div class="container">
        <h2 class="text-center mb-4">File Management Demo</h2>
        <input type="button" value="Create File" class="btn btn-success" onclick="createFile()" />
        <input type="button" value="Create Folder" id="folderCreate" class="btn btn-success" onclick="createFolder()">
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
                <li onclick="moveItem()">Move</li>
                <li onclick="addFileToFolder()">Add File to Folder</li>
                <li onclick="zipFolder()">Zip Folder</li>
                <li onclick="deleteItem()">Delete</li>
                <li onclick="downloadItem()">Download</li>
                <li onclick="editFile()">Edit File</li>
            </ul>
        </div>

    </div>
@endsection




@section('script')
    <script>
        function getAllFilesAndFolders() {
            $.ajax({
                type: 'get',
                url: '{{ URL('file-management/get-all') }}',
                success: function(data) {
                    console.log("🚀 ~ getAllFilesAndFolders ~ data:", data)
                    // Empty the files div
                    $('.files').empty();
                    displayFilesAndFolders(data.directories, 'folder', data.path);
                    displayFilesAndFolders(data.directories, 'file', data.path);
                }
            });
        }

        function displayFilesAndFolders(data, type, path) {
            // Loop through the data and append to the files div

            var iconClass = '';
            if (type == 'folder') {
                iconClass = 'fas fa-folder';
            } else {
                iconClass = 'fas fa-file';
            }

            data.forEach(function(item) {
                var html = '<div class="file-item" data-name="' + item + '" data-type="' + type + '" data-path="' + path + '">' +
                    '<i style="cursor:pointer" class="' + iconClass + '" oncontextmenu="showContextMenu(event)"></i>' +
                    '<span style="cursor:pointer" oncontextmenu="showContextMenu(event)">' + item + '</span>' +
                    '</div>';
                $('.files').append(html);
            });
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
            // var contextMenu = document.getElementById('contextMenu');
            // if (!event.target.closest('.context-menu')) {
            //     contextMenu.style.display = 'none';
            // }
            closeContextMenu(event);
        });


        function closeContextMenu(event) {
            var contextMenu = document.getElementById('contextMenu');
            if (!event || !event.target.closest('.context-menu')) {
                contextMenu.style.display = 'none';
                document.removeEventListener('click', closeContextMenu); // Remove the event listener
            }
        }


        function addFileToFolder() {
            // Implement add file to folder functionality
        }

        function zipFolder() {
            // Implement zip folder functionality
        }

        function deleteItem() {
            // Implement delete functionality
        }

        function downloadItem() {
            // Implement download functionality
        }

        function editFile() {
            // Implement edit file functionality
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


        function moveItem() {
            // Get the selected item data
            var selectedItem = $('.context-menu').data('selectedItem');
            var name = selectedItem.data('name');
            var path = selectedItem.data('path');

            // Now you have both the name and path of the selected item
            console.log('Name:', name);
            console.log('Path:', path);


            let data = {
                'source': path,
                'destination': 'new_test',
            };
            postAjax("{{ URL('file-management/move') }}", data);

            // Implement the move functionality here, you can use the name and path variables
        }




        function postAjax(url, data) {
            data['_token'] = "{{ csrf_token() }}";
            $.ajax({
                type: 'post',
                url: url,
                data: data,
                success: function(data) {
                    console.log(data);
                    getAllFilesAndFolders();
                    closeContextMenu();
                }
            });
        }
    </script>
@endsection
