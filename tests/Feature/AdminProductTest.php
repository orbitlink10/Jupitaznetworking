<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $role = Role::create(['name' => 'admin', 'label' => 'Admin']);
        $this->actingAs(User::factory()->create(['role_id' => $role->id]));
    }

    public function test_product_forms_and_list_render(): void
    {
        $this->get('/admin/products/create')->assertOk()->assertSee('Marked Price (KES)')->assertSee('YouTube video URL')->assertSee('product-subcategory');
        $product = Product::create(['name' => 'Router', 'slug' => 'router']);
        $this->get('/admin/products/'.$product->id.'/edit')->assertOk()->assertSee('Edit Product');
        $this->get('/admin/products')->assertOk()->assertSee('Preview')->assertSee('Router');
        $this->get('/admin')->assertOk();
    }

    public function test_product_saves_new_fields_and_category_selection(): void
    {
        $parent = Category::create(['name' => 'Wireless', 'slug' => 'wireless']);
        $child = Category::create(['name' => 'Access Points', 'slug' => 'access-points', 'parent_id' => $parent->id]);
        $extra = Category::create(['name' => 'Featured', 'slug' => 'featured']);
        $data = [
            'name' => 'New Router', 'sku' => '', 'price' => 25000, 'marked_price' => 28000,
            'video_url' => 'https://www.youtube.com/watch?v=abcdefghijk',
            'stock_quantity' => 3, 'stock_status' => 'in_stock', 'is_active' => 1,
            'category_id' => $parent->id, 'subcategory_id' => $child->id, 'categories' => [$extra->id],
        ];
        $this->post('/admin/products', $data)->assertRedirect(route('admin.products.index'));
        $product = Product::firstOrFail();
        $this->assertEquals('28000.00', $product->marked_price);
        $this->assertEquals($data['video_url'], $product->video_url);
        $this->assertEqualsCanonicalizing([$parent->id, $child->id, $extra->id], $product->categories->pluck('id')->all());
        $data['marked_price'] = null;
        $data['video_url'] = null;
        $this->put('/admin/products/'.$product->id, $data)->assertRedirect(route('admin.products.index'));
        $this->assertNull($product->fresh()->marked_price);
        $this->assertNull($product->fresh()->video_url);
    }

    public function test_unrelated_subcategory_and_non_youtube_url_are_rejected(): void
    {
        $parent = Category::create(['name' => 'Wireless', 'slug' => 'wireless']);
        $other = Category::create(['name' => 'Other', 'slug' => 'other']);
        $child = Category::create(['name' => 'Cables', 'slug' => 'cables', 'parent_id' => $other->id]);
        $this->post('/admin/products', [
            'name' => 'Router', 'price' => 100, 'stock_quantity' => 0, 'stock_status' => 'in_stock',
            'category_id' => $parent->id, 'subcategory_id' => $child->id,
            'video_url' => 'https://example.com/watch?v=test',
        ])->assertSessionHasErrors(['subcategory_id', 'video_url']);
        $this->assertDatabaseCount('products', 0);
    }
}
