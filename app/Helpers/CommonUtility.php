<?php 
namespace App\Helpers;

class CommonUtility
{

    /**
     * Helper function to converts capacity (e.g., "64GB") to MB.
     *
     * @param string $capacityText
     * @return int|null
     */
   public static function convertCapacityToMB(string $capacityText): ?int
    {
        if (stripos($capacityText, 'GB') !== false) {
            return (int)$capacityText * 1000; // Convert GB to MB
        } else if (stripos($capacityText, 'MB') !== false) {
            return (int)$capacityText;
        }
        return null;
    }


    /**
     * Helper function to resolve the full image URL.
     *
     * @param string $relativeImageUrl
     * @param string $baseUrl
     * @return string
     */
    public static function resolveImageUrl(string $relativeImageUrl, string $baseUrl): string
    {
        $parts = array_filter(explode('/images', $relativeImageUrl), function ($part) {
            return $part !== '';
        });
        $resolvedParts = [];
        foreach ($parts as $part) {
            if ($part === '..') {
                array_pop($resolvedParts);
            } elseif ($part !== '.') {
                $resolvedParts[] = $part;
            }
        }
        return $baseUrl . implode('/', $resolvedParts);
    }

    /**
     * Helper function to get Shipping Date from sipping text and convert it to Y-m-d format .
     *
     * @param string $shippingText
     * @return string|null
     */
     public static function extractShippingDate(string $shippingText): ?string
    {
        // 1. Check for date in 'YYYY-MM-DD' format (ISO)
        if (preg_match('/(\d{4}-\d{2}-\d{2})/', $shippingText, $isoDateMatches)) {
            return $isoDateMatches[1]; // Return ISO format date
        }

        // 2. Check for date in 'DD-MM-YYYY' format
        if (preg_match('/(\d{2}-\d{2}-\d{4})/', $shippingText, $ddmmyyyyMatches)) {
            $date = \DateTime::createFromFormat('d-m-Y', $ddmmyyyyMatches[1]);
            return $date ? $date->format('Y-m-d') : null; // Convert to ISO format
        }

        // 3. Check for date in 'DD-MM-YY' format
        if (preg_match('/(\d{2}-\d{2}-\d{2})/', $shippingText, $ddmmyyMatches)) {
            $date = \DateTime::createFromFormat('d-m-y', $ddmmyyMatches[1]);
            return $date ? $date->format('Y-m-d') : null; // Convert to ISO format
        }

        // 4. Check for date in 'Y-M-D' format (e.g., 24-8-3)
        if (preg_match('/(\d{1,4}-\d{1,2}-\d{1,2})/', $shippingText, $ymdMatches)) {
            $date = \DateTime::createFromFormat('Y-m-d', $ymdMatches[1]);
            return $date ? $date->format('Y-m-d') : null;
        }

        // 5. Check for date in 'D-M-Y' format (e.g., 3-8-2024)
        if (preg_match('/(\d{1,2}-\d{1,2}-\d{4})/', $shippingText, $dmyMatches)) {
            $date = \DateTime::createFromFormat('d-m-Y', $dmyMatches[1]);
            return $date ? $date->format('Y-m-d') : null;
        }

        // 6. Check for date in 'DD Mon YYYY' format (e.g., 26 Sep 2024)
        if (preg_match('/(\d{1,2} \w{3} \d{4})/', $shippingText, $humanDateMatches)) {
            $date = \DateTime::createFromFormat('d M Y', $humanDateMatches[1]);
            return $date ? $date->format('Y-m-d') : null;
        }

        // 7. Check for 'Thursday 26th Sep 2024' format
        if (preg_match('/(\w+ \d{1,2}(?:st|nd|rd|th) \w{3} \d{4})/', $shippingText, $fullHumanDateMatches)) {
            $date = \DateTime::createFromFormat('l jS M Y', $fullHumanDateMatches[1]);
            return $date ? $date->format('Y-m-d') : null;
        }

        // 8. Check for '2nd Oct 2024' format
        if (preg_match('/(\d{1,2}(?:st|nd|rd|th) \w{3} \d{4})/', $shippingText, $partialHumanDateMatches)) {
            $date = \DateTime::createFromFormat('jS M Y', $partialHumanDateMatches[1]);
            return $date ? $date->format('Y-m-d') : null;
        }

        return null; // Return null if no valid date is found
    }

    /**
     * Function to convert currency symbol to string
     * @param string $symbol
     * @return string
     */
    public static function getCurrencySymbol($price) {
        // Use regular expression to extract the currency symbol
        preg_match('/([^\d.,]+)/', $price, $matches);
        
        // Return the currency symbol or a default value if not found
        return !empty($matches) ? trim($matches[1]) : null;
    }

    /** 
     * Function to convert currency symbol to string
     * @param string $symbol
     * @return string
     */
    public static function convertCurrencySymbolToString($symbol): ?string {
        // Define a mapping of currency symbols to currency codes
        $currencyMap = [
            '$' => 'USD',
            '€' => 'EUR',
            '£' => 'GBP',
            '¥' => 'JPY',
            '₹' => 'INR',
            '₩' => 'KRW',
            '₽' => 'RUB',
            // Add more symbols and codes as needed
        ];
        // Check if the symbol exists in the mapping and return the corresponding currency code
        return array_key_exists($symbol, $currencyMap) ? $currencyMap[$symbol] : null;
    }
}