<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ScraperService;
use App\Services\ExportJsonFile;
use Exception;

class ScrapeProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape product data and export to a JSON file';

    /**
     * Service objects.
     */
    protected $scraperService;
    protected $jsonService;

    /**
     * Create a new command instance.
     *
     * @param ScraperService $scraperService
     * @param ExportJsonFile $jsonService
     */
    public function __construct(ScraperService $scraperService, ExportJsonFile $jsonService)
    {
        parent::__construct();
        $this->scraperService = $scraperService;
        $this->jsonService = $jsonService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Starting the scraping process...');

            $productData = $this->scraperService->scrapeSmartphones();

            if (count($productData) > 0) {
                echo $this->jsonService->exportProductsToJsonFile('output.json', $productData);
                $this->info('Scraping completed successfully, data exported to output.json');
            } else {
                $this->warn('No data found on the provided URL.');
            }

        } catch (Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}
