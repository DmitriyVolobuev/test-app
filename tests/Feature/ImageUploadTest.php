<?php

namespace Tests\Feature;

use App\Http\Controllers\ImageController;
use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
    public function test_index_method_returns_view_with_images()
    {
        $images = [
            new Image(['url' => 'image1.jpg', 'likes' => 10]),
            new Image(['url' => 'image2.jpg', 'likes' => 5]),
        ];

        $mockImageModel = $this->mock(Image::class);
        $mockImageModel->shouldReceive('latest->paginate')->andReturn($images);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewIs('index');
        $response->assertViewHas('images', $images);
    }

    public function test_upload_form_method_returns_upload_view()
    {
        $response = $this->get(route('upload'));

        $response->assertStatus(200);
        $response->assertViewIs('upload');
    }

    public function test_upload_method_uploads_images_and_redirects_to_home()
    {
        Storage::fake('public');

        $file1 = UploadedFile::fake()->image('image1.jpg');
        $file2 = UploadedFile::fake()->image('image2.jpg');

        $response = $this->post(route('image.upload'), [
            'images' => [$file1, $file2],
        ]);

        $response->assertRedirect(route('home'));
        $this->assertCount(2, Storage::disk('public')->files('images'));
    }

    public function test_show_method_returns_view_with_image()
    {
        $image = new Image(['url' => 'image.jpg', 'likes' => 10]);

        $mockImageModel = $this->mock(Image::class);
        $mockImageModel->shouldReceive('where->firstOrFail')->with('hash', 'test-hash')->andReturn($image);

        $response = $this->get(route('image.show', 'test-hash'));

        $response->assertStatus(200);
        $response->assertViewIs('show');
        $response->assertViewHas('image', $image);
    }

    public function test_like_method_increments_likes_and_returns_json_response()
    {
        $image = new Image(['url' => 'image.jpg', 'likes' => 10]);

        $mockImageModel = $this->mock(Image::class);
        $mockImageModel->shouldReceive('where->firstOrFail')->with('hash', 'test-hash')->andReturn($image);

        $response = $this->post(route('image.like', 'test-hash'));

        $response->assertJson(['likesCount' => 11, 'message' => 'Liked successfully.']);
    }

    public function test_dislike_method_decrements_likes_and_returns_json_response()
    {
        $image = new Image(['url' => 'image.jpg', 'likes' => 10]);

        $mockImageModel = $this->mock(Image::class);
        $mockImageModel->shouldReceive('where->firstOrFail')->with('hash', 'test-hash')->andReturn($image);

        $response = $this->post(route('image.dislike', 'test-hash'));

        $response->assertJson(['likesCount' => 9, 'message' => 'Disliked successfully.']);
    }
}
