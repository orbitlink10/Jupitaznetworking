<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogueTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;
    private Brand $brand;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->brand = Brand::create(['name' => 'MikroTik', 'slug' => 'mikrotik']);
        $this->category = Category::create(['name' => 'Routers', 'slug' => 'routers']);
        $this->product = Product::create([
            'brand_id' => $this->brand->id,
            'sku' => 'RB5009UG+S+IN',
            'name' => 'MikroTik RB5009UG+S+IN Router',
            'slug' => 'mikrotik-rb5009ug-s-in',
            'short_description' => 'A compact high-performance router.',
            'price' => null,
            'stock_quantity' => 10,
            'stock_status' => 'in_stock',
        ]);
        $this->product->categories()->attach($this->category->id);
    }

    public function test_homepage_renders(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_product_page_renders(): void
    {
        $this->get('/product/mikrotik-rb5009ug-s-in')
            ->assertOk()
            ->assertSee('MikroTik RB5009UG+S+IN Router')
            ->assertSee('In Stock');
    }

    public function test_category_page_renders(): void
    {
        $this->get('/routers')->assertOk()->assertSee('MikroTik RB5009UG+S+IN Router');
    }

    public function test_category_page_shows_products_attached_to_children(): void
    {
        $root = Category::create(['name' => 'Fibre Optic', 'slug' => 'fibre-optic']);
        $child = Category::create(['name' => 'Patch Cords', 'slug' => 'patch-cords', 'parent_id' => $root->id]);
        $this->product->categories()->sync([$child->id]);

        $this->get('/fibre-optic/patch-cords')
            ->assertOk()
            ->assertSee('MikroTik RB5009UG+S+IN Router');

        $this->get('/fibre-optic')
            ->assertOk()
            ->assertSee('MikroTik RB5009UG+S+IN Router');
    }

    public function test_brand_page_renders(): void
    {
        $this->get('/brands/mikrotik')->assertOk();
    }

    public function test_search_finds_product_by_model(): void
    {
        $this->get('/products?q=RB5009')->assertOk()->assertSee('MikroTik RB5009UG+S+IN Router');
    }

    public function test_cart_checkout_flow(): void
    {
        $this->post('/cart/add', ['product_id' => $this->product->id, 'quantity' => 2])
            ->assertRedirect();

        $this->get('/cart')->assertOk()->assertSee('MikroTik RB5009UG+S+IN Router');

        $this->post('/checkout', [
            'name' => 'Test Buyer',
            'phone' => '0712345678',
            'email' => 'buyer@example.com',
        ])->assertRedirect();

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('order_items', 1);
    }

    public function test_sitemap_renders(): void
    {
        $this->get('/sitemap.xml')->assertOk()->assertSee('/product/mikrotik-rb5009ug-s-in');
    }
}
