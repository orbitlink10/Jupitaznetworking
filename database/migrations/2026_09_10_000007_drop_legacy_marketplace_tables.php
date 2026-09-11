<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('booking_images');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('provider_services');
        Schema::dropIfExists('providers');
        Schema::dropIfExists('services');
    }

    public function down(): void
    {
        // Intentionally not restored; legacy service-marketplace tables are retired.
    }
};
