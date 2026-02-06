<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StorageController extends Controller
{
    /**
     * Serve files from storage/app/public
     * 
     * This route handles all storage files including:
     * - Product images: /storage/products/xxx.jpg
     * - Payment proofs: /storage/payments/xxx.pdf or xxx.jpg
     * - Any other files in storage/app/public/
     * 
     * @param Request $request
     * @param string $path
     * @return BinaryFileResponse|\Illuminate\Http\Response
     */
    public function serve(Request $request, string $path)
    {
        // Security: Prevent directory traversal attacks
        $path = str_replace('..', '', $path);
        $path = ltrim($path, '/');
        
        // Build full path to file
        $filePath = storage_path('app/public/' . $path);
        
        // Check if file exists
        if (!file_exists($filePath) || !is_file($filePath)) {
            abort(404, 'File not found');
        }
        
        // Get file mime type
        $mimeType = mime_content_type($filePath);
        
        // Return file response with proper headers
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=31536000', // Cache for 1 year
        ]);
    }
}
