<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use App\Support\CatalogueImporter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->resetCatalogue();

        $roles = collect([
            ['name' => 'admin', 'label' => 'Admin'],
            ['name' => 'customer', 'label' => 'Customer'],
            ['name' => 'dispatcher', 'label' => 'Staff'],
        ])->mapWithKeys(fn ($role) => [$role['name'] => Role::updateOrCreate(['name' => $role['name']], $role)]);

        User::updateOrCreate(['email' => 'admin@jupitaz.co.ke'], [
            'role_id' => $roles['admin']->id,
            'name' => 'Jupitaz Admin',
            'phone' => '',
            'password' => Hash::make('password'),
        ]);

        User::updateOrCreate(['email' => 'customer@example.com'], [
            'role_id' => $roles['customer']->id,
            'name' => 'Customer',
            'password' => Hash::make('password'),
        ]);

        // Clear any placeholder contact data from the legacy seed.
        Setting::whereIn('key', ['support_phone', 'support_whatsapp', 'support_email', 'support_address', 'service_areas'])->delete();

        Setting::putValue('delivery_fee', '0');

        app(CatalogueImporter::class)->run();
    }

    private function resetCatalogue(): void
    {
        Schema::disableForeignKeyConstraints();

        Product::query()->delete();
        Category::query()->delete();
        Brand::query()->delete();

        Schema::enableForeignKeyConstraints();
    }
}
