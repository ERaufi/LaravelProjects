<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;


class FileManagementController extends Controller
{
    private $filesPath = 'users-files';
    public function getAllFilesAndFolders()
    {
        $directories = Storage::directories($this->filesPath);
        $files = Storage::files($this->filesPath);
        return response()->json([
            'directories' => $directories,
            'files' => $files,
            'path' => $this->filesPath
        ], 200);
    }



    public function createFile(Request $request)
    {
        Storage::put($this->filesPath . '/' . $request->fileName . '.txt', $request->fileContent);
        return response()->json(['message' => 'Created Successfully'], 200);
    }

    public function createFolder(Request $request)
    {
        // $folderName = $request->input('folderName');
        // mkdir(public_path('users-files/' . $folderName));
        Storage::makeDirectory($this->filesPath . '/' . $request->folderName);
        return response()->json(['message' => 'Created Successfully'], 200);
    }

    public function rename(Request $request)
    {
        $oldName = $request->input('oldName');
        $newName = $request->input('newName');

        // Determine if the item being renamed is a file or folder
        if (is_file(public_path('users-files/' . $oldName))) {
            $extension = '.txt';
        } else {
            $extension = '';
        }

        // Add extension only if it's a file
        $oldPath = public_path('users-files/' . $oldName);
        $newPath = public_path('users-files/' . $newName . $extension);

        // Rename the file or folder
        rename($oldPath, $newPath);

        return "File/Folder renamed successfully!";
    }



    public function move(Request $request)
    {
        $source = $request->input('source');
        $destination = $request->input('destination');
        // rename(public_path('users-files/' . $source), public_path('users-files/' . $destination . '/'));
        // public::move(public_path('users-files/' . $source), public_path('users-files/' . $destination . '/'));
        return "File/Folder moved successfully!";
    }

    public function addFileToFolder(Request $request)
    {
        $folderPath = $request->input('folderPath');
        $fileName = $request->input('fileName');
        $fileContent = $request->input('fileContent');
        file_put_contents(public_path($folderPath . '/' . $fileName), $fileContent);
        return "File added to folder successfully!";
    }

    public function zipFolder(Request $request)
    {
        $folderToZip = $request->input('folderToZip');
        $zipFileName = $folderToZip . '.zip';
        $zip = new ZipArchive;
        $zip->open(public_path($zipFileName), ZipArchive::CREATE);
        $files = glob(public_path($folderToZip . '/*'));
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();
        return "Folder zipped successfully!";
    }

    public function delete(Request $request)
    {
        $path = $request->input('path');
        if (file_exists(public_path($path))) {
            if (is_dir(public_path($path))) {
                $this->deleteDirectory(public_path($path));
            } else {
                unlink(public_path($path));
            }
            return "File/Folder deleted successfully!";
        } else {
            return "File/Folder does not exist!";
        }
    }

    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }

    public function download(Request $request)
    {
        $filePath = $request->input('filePath');
        if (file_exists(public_path($filePath))) {
            return response()->download(public_path($filePath));
        } else {
            return "File does not exist!";
        }
    }

    public function editFile(Request $request)
    {
        $filePath = $request->input('filePath');
        $newContent = $request->input('newContent');
        if (file_exists(public_path($filePath))) {
            file_put_contents(public_path($filePath), $newContent);
            return "File edited successfully!";
        } else {
            return "File does not exist!";
        }
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $files = glob(public_path('*'));
        $filteredFiles = array_filter($files, function ($file) use ($searchTerm) {
            return strpos($file, $searchTerm) !== false;
        });
        return $filteredFiles;
    }
}
