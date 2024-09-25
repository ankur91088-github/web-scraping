<?php
namespace App\Http\Controllers;
use App\Services\ScraperService;
use App\Services\ExportJsonFile;
use Illuminate\Http\JsonResponse;
use Exception;

class ScrapeController extends Controller
{
   
    protected $scraperServiceObj;
    protected $jsonServiceObj;

    public function __construct(ScraperService $scraperService,ExportJsonFile $jsonServiceObj)
    {
        $this->scraperServiceObj = $scraperService;
        $this->jsonServiceObj =$jsonServiceObj;
    }

    /**
     * Scrapes the smartphone page and returns the formatted product data.
     *
     * @return JsonResponse
     */
    public function scrape()
    {
        try {
            $productData = $this->scraperServiceObj->scrapeSmartphones();
            $this->jsonServiceObj->exportProductsToJsonFile('product.json', $productData);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}