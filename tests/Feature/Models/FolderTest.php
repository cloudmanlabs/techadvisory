<?php

namespace Tests\Feature;

use App\User;
use Exception;
use Guimcaballero\LaravelFolders\Models\Folder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use InvalidArgumentException;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FolderTest extends TestCase
{
    use RefreshDatabase;

    public function testCanUploadFiles()
    {
        Storage::fake('public');

        $folder = Folder::createNewRandomFolder();

        $files = [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.jpg'),
            UploadedFile::fake()->image('image3.jpg'),
        ];

        $this->withoutExceptionHandling();

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
