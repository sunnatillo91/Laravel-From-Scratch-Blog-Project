<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Filesystem;

class PostTest extends TestCase
{

    public function test_can_create_post()
    {
        Storage::fake(disk: 'public');
        $file = UploadedFile::fake()->image('avatar.jpg');
        $admin = User::find(4);
        $slug = rand(123456, 9999999999999);

        $response = $this->actingAs($admin)->post('admin/posts', [
            'title' => 'new title',
            'thumbnail' => $file,
            'slug' => $slug,
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => 1
        ]);


        $this->assertDatabaseHas('posts', [
            // 'title' => 'new title',
            'slug' => $slug,
        ]);

        Storage::disk('public')->exists('thumbnails/' . $file->hashName());
        $response->assertRedirect('/');
    }

    public function test_can_view_post()
    {

        $post = Post::first();

        $response = $this->get('posts/' . $post->slug);

        $response->assertSee($post->title)
            ->assertStatus(200)
            ->assertSee('Back to Posts');
    }
}
