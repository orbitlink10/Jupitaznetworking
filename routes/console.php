<?php

use App\Support\CatalogueImporter;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:import-catalogue', function (CatalogueImporter $importer) {
    $stats = $importer->run();

    $this->info('Catalogue import complete.');
    $this->table(['Type', 'Count'], [
        ['Brands', $stats['brands']],
        ['Categories', $stats['categories']],
        ['Products', $stats['products']],
    ]);
})->purpose('Idempotently import the Jupitaz networking catalogue from the bundled data file');
