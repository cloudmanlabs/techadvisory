<?php

namespace Tests\Feature;

use App\Folder;
use App\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use InvalidArgumentException;
use Tests\TestCase;

class FolderTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateFolder()
    {
        $this->assertCount(0, Folder::all());

        Folder::createNewFolder('someFolderName');

        $this->assertCount(1, Folder::all());
    }

    public function testCanCreateRandomFolder()
    {
        $this->assertCount(0, Folder::all());

        Folder::createNewRandomFolder();

        $this->assertCount(1, Folder::all());
    }

    public function testCantCreateFolderWithRepeatedName()
    {
        Folder::createNewFolder('someFolderName');


        $this->expectException(\Illuminate\Database\QueryException::class);

        Folder::createNewFolder('someFolderName');

        $this->assertCount(1, Folder::all());
    }

    public function testCantCreateFolderWithSpacesInName()
    {
        $this->expectException(InvalidArgumentException::class);

        Folder::createNewFolder('invalid name');
        $this->assertCount(0, Folder::all());
    }

    public function testCantChangeFolderName()
    {
        $folder = Folder::createNewFolder('name');

        $this->expectException(Exception::class);
        $folder->name = 'other';
    }
}
