<?php

namespace App\Http\Controllers;

use Guimcaballero\LaravelFolders\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FolderController extends Controller
{
    public function uploadFiles(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|numeric',
            'files' => 'required'
        ]);

        /** @var Folder $folder */
        $folder = Folder::find($request->folder_id);
        if($folder == null){
            abort(404);
        }

        $files = $request->file('files');
        $folder->uploadFiles($files);
        $this->createPreviewImageForFiles($folder);
    }

    public function uploadSingleFile(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|numeric',
            'file' => 'required'
        ]);

        /** @var Folder $folder */
        $folder = Folder::find($request->folder_id);
        if ($folder == null) {
            abort(404);
        }

        $file = $request->file('file');
        $folder->uploadSingleFile($file);
        $this->createPreviewImageForFiles($folder);
    }

    private static function createPreviewImageForFiles(Folder $folder): void
    {
        $files = $folder->getListOfFiles();

        // Delete and create folder to remove all existing files
        Storage::disk('public')->deleteDirectory('/previewImages/' . $folder->name);
        Storage::disk('public')->makeDirectory('/previewImages/' . $folder->name);

        foreach ($files as $key => $file) {
            // Check if file is pdf
            $fileName = escapeshellarg(basename($file));
            $extension = pathinfo($file, PATHINFO_EXTENSION);

            if ($extension != 'pdf') continue;

            $escapedFile = escapeshellarg($file);
            $filepath = base_path("storage/app/public/$escapedFile");
            $imagePath = base_path("storage/app/public/previewImages/$folder->name/$fileName.jpg");

            // Convert the first page into image
            $command = "convert        \
                    -verbose        \
                    -density 150    \
                    -trim           \
                    $filepath\[0\] \
                    -quality 100    \
                    -flatten        \
                    -sharpen 0x1.0  \
                    $imagePath";
            $ret = null;
            passthru($command, $ret);
        }
    }

    static function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }


    public function removeFile(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|numeric',
            'file' => 'required'
        ]);

        /** @var Folder $folder */
        $folder = Folder::find($request->folder_id);
        if ($folder == null) {
            abort(404);
        }

        $folder->removeSingleFile($request->file);
    }
}
