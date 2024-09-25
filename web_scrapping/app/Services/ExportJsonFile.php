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
    public function exportProductsToJsonFile(string $filename, array $data): Response
    {
        // Save the JSON data to the storage
        Storage::disk('local')->put($filename, json_encode($data, JSON_PRETTY_PRINT));

        // Prepare the file path for download
        $filePath = storage_path('app/' . $filename);
        
        // Check if the file exists before attempting to download
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'The file does not exist.'], 404);
        }

        // Create a response for file download with forced download
        return response()->download($filePath, $filename, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ])->deleteFileAfterSend(true);
    }
}
