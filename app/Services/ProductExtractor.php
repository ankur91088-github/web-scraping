<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;
use App\Http\Resources\ProductResource;
use App\Helpers\CommonUtility;

class ProductExtractor
{
    /**
     * Extracts product information from the current page.
     *
     * @param Crawler $crawler
     * @param array $products
     * @param array $productKeys
     */
    public function extractProducts(Crawler $crawler, array &$products, array &$productKeys): void
    {
        $crawler->filter('.product')->each(function (Crawler $node) use (&$products, &$productKeys) {
            try {
                // Extract product data except color
                $productData = $this->extractProductData($node);

                // If color variants exist, create separate products for each color
                $colorNodes = $node->filter('span[data-colour]');
                if ($colorNodes->count() > 0) {
                    $colorNodes->each(function (Crawler $colorNode) use (&$products, &$productKeys, $productData) {
                        $color = $colorNode->attr('data-colour') ?: 'Unknown Color';
                        $productData['color'] = $color; // Assign color to the product data
                        $this->addProduct($productData, $products, $productKeys);
                    });
                } else {
                    // If no color variants, just add the product with color as 'Unknown'
                    $productData['color'] = 'Unknown Color';
                    $this->addProduct($productData, $products, $productKeys);
                }
            } catch (\Exception $e) {
                echo "Error extracting product data: " . $e->getMessage();
            }
        });
    }

    /**
     * Extracts data for a single product.
     *
     * @param Crawler $node
     * @return array
     */
    private function extractProductData(Crawler $node): array
    {
        $imageBaseUrl = config('constants.IMAGE_BASE_URL');
        $title = $node->filter('.product-name')->text() ?: 'Unknown Product';
        $priceText = $node->filter('div.my-8.block.text-center.text-lg')->text();
        $price = (float) filter_var($priceText, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?: 0.0;
        $currencySymbol = CommonUtility::getCurrencySymbol($node->filter('div.my-8.block.text-center.text-lg')->text());
        $currencyText =  CommonUtility::convertCurrencySymbolToString($currencySymbol);
        $imageUrl = $node->filter('img')->attr('src') ?: '';
        $fullImageUrl = CommonUtility::resolveImageUrl($imageUrl, $imageBaseUrl);
        $capacityText = $node->filter('.product-capacity')->text() ?: '0GB';
        $availabilityText = $node->filter('.my-4.text-sm.block.text-center')->first()->text() ?: 'Unavailable';
        $isAvailable = stripos($availabilityText, 'In Stock') !== false;
        $shippingText = $node->filter('div.my-4.text-sm.block.text-center')->last()->text() ?: 'No shipping information';
        $shippingDate = CommonUtility::extractShippingDate($shippingText);
        $capacityMB = CommonUtility::convertCapacityToMB($capacityText) ?: 0;

        return [
            'title' => $title,
            'price' => $price,
            'imageUrl' => $fullImageUrl,
            'capacityMB' => $capacityMB,
            'availabilityText' => $availabilityText,
            'isAvailable' => $isAvailable,
            'shippingText' => $shippingText,
            'shippingDate' => $shippingDate,
            'currencySymbol' => $currencySymbol,
            'currencyText' =>  $currencyText 
        ];
    }

    /**
     * Adds a product to the products array, checking for duplicates.
     *
     * @param array $productData
     * @param array $products
     * @param array $productKeys
     */
    private function addProduct(array $productData, array &$products, array &$productKeys): void
    {
        $productKey = "{$productData['title']}_{$productData['capacityMB']}_{$productData['color']}"; // Unique key for this product
        if (!in_array($productKey, $productKeys)) { // Check for duplicates
            $products[] = new ProductResource((object)$productData); // Store each product in the products array
            $productKeys[] = $productKey; // Add to unique keys
        }
    }
}
