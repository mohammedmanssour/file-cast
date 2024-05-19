<?php

namespace MohammedManssour\FileCast\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use MohammedManssour\FileCast\File as FileObject;
use MohammedManssour\FileCast\Tests\stubs\Models\File;
use PHPUnit\Framework\Attributes\Test;

class FileCastTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('fake_disk');
    }

    #[Test]
    public function it_saves_file()
    {
        $model = $this->makeModel();

        $this->assertNotNull($model->path);
        $this->assertInstanceOf(FileObject::class, $model->path);
        Storage::disk('fake_disk')->assertExists($model->path->path());

        $this->assertEquals(
            basename($model->path->path()),
            $model->path->name()
        );

        $this->assertTrue($model->path->exists());
    }

    #[Test]
    public function it_retrives_path_as_file_object()
    {
        $model = $this->makeModel();
        $this->assertInstanceOf(FileObject::class, $model->refresh()->path);
    }

    #[Test]
    public function it_removes_old_file_on_update()
    {
        $model = $this->makeModel();
        $previousFile = $model->path;

        $file = UploadedFile::fake()->create('some-2.png');
        $model->update([
            'path' => $file,
        ]);

        $this->assertNotSame($previousFile, $model->path);
        $this->assertFalse($previousFile->exists());
    }

    #[Test]
    public function it_does_not_remove_old_file_when_other_update_occurres()
    {
        $model = $this->makeModel();
        $previousFile = $model->path;
        $model->update(['id' => fake()->randomNumber()]);

        $this->assertEquals($previousFile->path(), $model->path->path());
        $this->assertTrue($previousFile->exists());
    }

    #[Test]
    public function it_does_not_remove_old_file_when_model_is_updated_to_the_same_path()
    {
        $model = $this->makeModel();
        $previousFile = $model->path;

        $model->update(['path' => $model->path->path()]);

        $this->assertEquals($previousFile->path(), $model->path->path());
        $this->assertTrue($previousFile->exists());
    }

    #[Test]
    public function it_does_not_remove_old_file_when_model_is_updated_to_null()
    {
        $model = $this->makeModel();
        $previousFile = $model->path;

        $model->update(['path' => null]);

        $this->assertNull($model->path);
        $this->assertFalse($previousFile->exists());
    }

    #[Test]
    public function it_removes_files_when_model_is_deleted()
    {
        $model = $this->makeModel();
        $previousFile = $model->path;

        $model->delete();
        $this->assertFalse($previousFile->exists());
    }

    private function makeModel(): File
    {
        $file = UploadedFile::fake()->create('some.csv');

        return File::create([
            'path' => $file,
        ]);
    }
}
