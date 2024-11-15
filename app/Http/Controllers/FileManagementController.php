<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileManagementRequest;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\Validator;


class FileManagementController extends Controller
{
    // private $filesPath = 'users-files';
    public function getAllFilesAndFolders(Request $request)
    {
        $path = 'users-files';
        if ($request->path != '') {
            $path = $request->path;
        }

        $directories = Storage::directories($path);
        $files = Storage::files($path);

        return response()->json([
            'directories' => $directories,
            'files' => $files,
            'path' => $path,
        ], 200);
    }



    public function createFile(Request $request)
    {
        Storage::put($request->path . '/' . $request->fileName . '.txt', $request->fileContent);
        return response()->json(['message' => 'Created Successfully'], 200);
    }

    public function createFolder(Request $request)
    {
        Storage::makeDirectory($request->path . '/' . $request->folderName);
        return response()->json(['message' => 'Created Successfully'], 200);
    }

    public function rename(Request $request)
    {
        $oldName = $request->input('oldName');
        $newName = $request->input('newName');
        $extension = '';


        $mime = Storage::mimeType($oldName);

        if ($mime) {
            $extension = '.' . pathinfo(storage_path($oldName), PATHINFO_EXTENSION);
        }
        // Perform the rename operation
        Storage::move($oldName, $request->path . '/' . $newName . $extension);

        return response()->json(['message' => 'Renamed Successfully'], 200);
    }



    public function paste(Request $request)
    {
        $source = $request->input('source');
        $destination = $request->input('destination');

        // Get the filename or directory name from the source path
        $filename = basename($source);

        // Append the filename to the destination path
        $destinationPath = $destination . '/' . $filename;

        // Move the file or directory
        if ($request->isCopy == 1) {
            Storage::copy($source, $destinationPath);
        } else {
            Storage::move($source, $destinationPath);
        }

        return response()->json(['message' => 'File/Folder Moved Successfully'], 200);
    }



    public function zipFolder(Request $request)
    {
        $folderToZip = $request->input('folderToZip');
        $zipFileName = basename($folderToZip) . '.zip'; // Get the folder name and append .zip extension
        $zipFilePath = storage_path('app/' . $zipFileName); // Specify the path to the zip file in the app folder
        $zip = new ZipArchive;

        // Create the zip file
        if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
            return "Failed to create zip file.";
        }

        // Add the folder and its contents to the zip file
        $files = Storage::allFiles($folderToZip);
        foreach ($files as $file) {
            $relativePath = str_replace($folderToZip . '/', '', $file);
            $zip->addFile(storage_path('app/' . $file), $relativePath);
        }

        // Close the zip file
        $zip->close();

        // Move the zip file back into the same folder
        Storage::move($zipFileName, $folderToZip . '/' . $zipFileName);

        return "Folder zipped successfully!";
    }


    public function download(Request $request)
    {
        $encoded_file_name = $request->query('encoded_file_name');
        $file_name = urldecode($encoded_file_name);

        try {
            return Storage::download($file_name);
        } catch (\Exception $e) {
            return abort(404);
        }
    }



    public function delete(Request $request)
    {
        $mime = Storage::mimeType($request->name);
        if ($mime) {
            Storage::delete($request->name);
        } else {
            Storage::deleteDirectory($request->name);
        }

        return response()->json(['message' => 'File/Folder Deleted Successfully'], 200);
    }




    public function upload(FileManagementRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'files.*' => 'required|mimes:jpeg,jpg,png,gif,pdf,doc,docx,xls,xlsx|max:2048', // Adjust max file size as needed
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()->first()], 400);
        // }
        $request->validate([
            'files' => 'array',
            'files.*' => 'required|mimes:jpeg,jpg,png,gif,pdf,doc,docx,xls,xlsx|max:2048'
        ]);

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $uploadedFiles = [];

            foreach ($files as $file) {
                $fileName = $file->getClientOriginalName();
                $file->storeAs($request->path, $fileName);
                $uploadedFiles[] = $fileName;
            }

            return response()->json(['message' => 'Files uploaded successfully', 'files' => $uploadedFiles]);
        }

        return response()->json(['error' => 'No files were uploaded'], 400);
    }
}
