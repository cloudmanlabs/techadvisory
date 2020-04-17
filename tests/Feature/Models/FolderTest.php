<?php

namespace Tests\Feature;

use App\Folder;
use App\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use InvalidArgumentException;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

    public function testCanUploadFiles()
    {
        Storage::fake('public');

        $folder = Folder::createNewRandomFolder();

        $files = [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.jpg'),
            UploadedFile::fake()->image('image3.jpg'),
        ];

        $response = $this
                    ->actingAs(factory(User::class)->create())
                    ->post('folder/uploadFilesToFolder', [
                        'files' => $files,
                        'folder_id' => $folder->id,
                    ]);
        $response->assertOk();

        $list = $folder->getListOfFiles();
        $this->assertCount(3, $list);
    }

    public function testCanUploadTwice()
    {
        Storage::fake('public');

        $folder = Folder::createNewRandomFolder();

        $user = factory(User::class)->create();

        $response = $this
            ->actingAs($user)
            ->post('folder/uploadFilesToFolder', [
                'files' => [
                    UploadedFile::fake()->image('image1.jpg'),
                    UploadedFile::fake()->image('image2.jpg'),
                    UploadedFile::fake()->image('image3.jpg'),
                ],
                'folder_id' => $folder->id,
            ]);
        $response->assertOk();

        $response = $this
            ->actingAs($user)
            ->post('folder/uploadFilesToFolder', [
                'files' => [
                    UploadedFile::fake()->image('image4.jpg'),
                    UploadedFile::fake()->image('image5.jpg'),
                ],
                'folder_id' => $folder->id,
            ]);
        $response->assertOk();

        $list = $folder->getListOfFiles();
        $this->assertCount(5, $list);
    }

    public function testCanRemvoeFiles()
    {
        Storage::fake('public');

        $folder = Folder::createNewRandomFolder();

        $user = factory(User::class)->create();

        $response = $this
            ->actingAs($user)
            ->post('folder/uploadFilesToFolder', [
                'files' => [
                    UploadedFile::fake()->image('image1.jpg'),
                    UploadedFile::fake()->image('image2.jpg'),
                    UploadedFile::fake()->image('image3.jpg'),
                ],
                'folder_id' => $folder->id,
            ]);
        $response->assertOk();

        $response = $this
            ->actingAs($user)
            ->post('folder/removeFile', [
                'file' => 'image1.jpg',
                'folder_id' => $folder->id,
            ]);
        $response->assertOk();

        $list = $folder->getListOfFiles();
        $this->assertCount(2, $list);
    }
}
