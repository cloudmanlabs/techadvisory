<?php

namespace App\Http\Controllers;

use App\Folder;
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

        $folder = Folder::find($request->folder_id);
        if($folder == null){
            abort(404);
        }

        $files = $request->file('files');
        foreach ($files as $key => $file) {
            Storage::disk('public')->putFileAs('folders/' . $folder->name, $file, $file->getClientOriginalName());
        }
    }

    public function uploadSingleFile(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|numeric',
            'file' => 'required'
        ]);

        $folder = Folder::find($request->folder_id);
        if ($folder == null) {
            abort(404);
        }

        $file = $request->file('file');
        Storage::disk('public')->putFileAs('folders/' . $folder->name, $file, $file->getClientOriginalName());
    }

    public function removeFile(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|numeric',
            'file' => 'required'
        ]);

        $folder = Folder::find($request->folder_id);
        if ($folder == null) {
            abort(404);
        }

        $exists = Storage::disk('public')->exists('folders/' . $folder->name . '/' . $request->file);
        if ($exists) {
            Storage::disk('public')->delete('folders/' . $folder->name . '/' . $request->file);
        }
    }
}
