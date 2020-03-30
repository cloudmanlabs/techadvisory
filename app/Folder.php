<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * @property string $name
 */
class Folder extends Model
{
    public $guarded = [];


    /**
     * Get the owning folderable model.
     */
    public function folderable()
    {
        return $this->morphTo();
    }






    /**
     * Creates a new folder with given name
     *
     * @param string $name
     * @return Folder
     */
    public static function createNewFolder(string $name): Folder
    {
        if(strpos($name, ' ') !== false
            || strpos($name, '\\') !== false
            || strpos($name, '/') !== false){
            throw new InvalidArgumentException($name . ' is not a valid input.');
        }

        $folder = new Folder([
            'name' => $name,
        ]);
        $folder->save();

        // TODO Create the actual folder on disk

        return $folder;
    }

    /**
     * Creates a new folder with a random name
     *
     * @return Folder
     */
    public static function createNewRandomFolder():Folder
    {
        $name = '';
        $counter = 0;
        do {
            $name = Str::random(20 + $counter++);
        } while (Folder::where("name", $name)->first() != null);

        return Folder::createNewFolder($name);
    }

    public function setNameAttribute($value)
    {
        if(isset($this->attributes['name'])){
            throw new Exception('A folder\'s name is not editable');
        } else {
            $this->attributes['name'] = $value;
        }
    }


    //TODO Add an option to add the full file path here or smth
    public function getListOfFiles(): array
    {
        $path = storage_path('app/public/folders/' . $this->name);
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));

        return array_values($files);
    }

    public function uploadFiles(Request $request): void
    {
        $files = $request->file('files');
        foreach ($files as $key => $file) {
            $file->storeAs('public/folders/' . $this->name . '/', $file->getClientOriginalName());
        }
    }

    public function removeFile(Request $request)
    {
        $docName = $request->input('doc');

        $exists = Storage::disk('public')->exists('folders/' . $this->name . '/' . $docName);
        if ($exists) {
            Storage::disk('public')->delete('folders/' . $this->name . '/' .  $docName);
        } else {
            return 'doesNotExist';
        }
    }
}
