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
