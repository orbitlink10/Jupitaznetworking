<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $role = Role::create(['name' => 'admin', 'label' => 'Admin']);
        $this->actingAs(User::factory()->create(['role_id' => $role->id]));
    }

    public function test_category_pages_render_roots_and_subcategories(): void
    {
        $root = Category::create(['name' => 'Routers', 'slug' => 'routers']);
        $child = Category::create(['name' => 'Wireless Routers', 'slug' => 'wireless', 'parent_id' => $root->id]);
        $this->get('/admin/categories')->assertOk()->assertSee('Create New Category')->assertSee('No Image')->assertSee('Preview')->assertSee(route('categories.show', 'routers/wireless'), false);
        $this->get('/admin/categories/create')->assertOk()->assertSee('Create Category')->assertSee('Description (Optional)');
        $this->get('/admin/categories/'.$child->id.'/edit')->assertOk()->assertSee('Edit Category')->assertSee('Wireless Routers');
    }

    public function test_category_photo_and_content_save_and_photo_survives_edits(): void
    {
        Storage::fake('public');
        $data = [
            'name' => 'Routers', 'meta_description' => 'Networking routers',
            'content' => '<p>Choose a router.</p>', 'is_active' => 1,
            'image' => UploadedFile::fake()->image('routers.png'),
        ];
        $this->post('/admin/categories', $data)->assertRedirect(route('admin.categories.index'));
        $category = Category::firstOrFail();
        Storage::disk('public')->assertExists($category->image);
        $this->assertEquals($data['content'], $category->content);
        $image = $category->image;
        unset($data['image']);
        $data['name'] = 'Network Routers';
        $this->put('/admin/categories/'.$category->id, $data)->assertRedirect(route('admin.categories.index'));
        $this->assertEquals($image, $category->fresh()->image);
        $this->get('/admin/categories')->assertOk()->assertSee($category->fresh()->imageUrl(), false);
    }
}
