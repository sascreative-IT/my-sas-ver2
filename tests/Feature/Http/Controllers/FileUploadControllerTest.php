<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_properly()
    {
        $user = User::factory()->create();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('logo.jpg');

        $request = [
            'logo' => $file
        ];
        $this->actingAs($user);
        $this->post(route('logo.create'), $request);

        Storage::disk('public')->assertExists('uploads/'.$file->hashName());
        $this->assertEquals($file->hashName(), File::orderBy('id', 'desc')->first()->file_path);
    }

    public function test_it_gets_the_file_url()
    {
        $user = User::factory()->create();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('logo.jpg');

        $request = [
            'logo' => $file
        ];
        $this->actingAs($user);
        $this->post(route('logo.create'), $request);

        $fileId = File::orderBy('id', 'desc')->first()->id;
        $response = $this->get(route('logo.show',$fileId));

        $response->assertStatus(200);
        $this->assertEquals($file->hashName(), File::orderBy('id', 'desc')->first()->file_path);
    }
}
