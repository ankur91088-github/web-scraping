<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ExportJsonFile
{

    /**
     * Write products to a JSON file.
     *
     * @param string $filename
     */
    public function exportProductsToJsonFile(string $filename, array $productData): Response
    {
        // Define the path where the JSON data will be saved
        $storagePath = storage_path('app/' . $filename);

        // Save the JSON data to the specified path
        file_put_contents($storagePath, json_encode($productData, JSON_PRETTY_PRINT));

        $filePath = $storagePath; // Use the storage path if no download path is specified

        // Create a response for file download
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
