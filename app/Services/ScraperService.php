<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use App\Http\Resources\ProductResource;
use App\Exceptions\ScrapingException;

class ScraperService
{
    private array $products = [];
    private array $productKeys = []; // To track unique product identifiers create using title_color_capacity

    /**
     * Scrapes the smartphone data and returns a list of products.
     *
     * @param int $pageNum
     * @return array
     * @throws ScrapingException
     */
    public function scrapeSmartphones(int $pageNum = 1): array
    {

        $baseUrl = config('constants.BASE_URL');
        $url = $baseUrl . 'smartphones/?page=' . $pageNum;
        $client = HttpClient::create();
        $response = $client->request('GET', $url);

        if ($response->getStatusCode() !== 200) {
            throw new ScrapingException("Failed to fetch the webpage.");
        }
        $html = $response->getContent();  // Get the html content from url
        $crawler = new Crawler($html);
        $productExtractor = new ProductExtractor();
        $productExtractor->extractProducts($crawler, $this->products, $this->productKeys);
        $this->handlePagination($crawler, $pageNum);
        return ProductResource::collection($this->products)->toArray(request());
    }

    /**
     * Handles pagination.
     *
     * @param Crawler $crawler
     * @param int $currentPage
     */
    private function handlePagination(Crawler $crawler, int $currentPage): void
    {
        $pageInfo = $crawler->filter('p.block.text-center.my-8')->text();
        preg_match('/Page (\d+) of (\d+)/', $pageInfo, $matches);
        $totalPages = isset($matches[2]) ? (int)$matches[2] : 1;

        if ($currentPage < $totalPages) {
            $this->scrapeSmartphones($currentPage + 1); // Recur for next page
        }
    }
}