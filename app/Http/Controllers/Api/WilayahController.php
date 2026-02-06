<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    protected string $baseUrl = 'https://emsifa.github.io/api-wilayah-indonesia/api';

    /**
     * Get provinces list
     */
    public function provinces()
    {
        $response = Http::get($this->baseUrl . '/provinces.json');
        return response()->json($response->successful() ? $response->json() : []);
    }

    /**
     * Get regencies (kota/kabupaten) by province ID
     */
    public function regencies(string $provinceId)
    {
        $response = Http::get($this->baseUrl . '/regencies/' . $provinceId . '.json');
        return response()->json($response->successful() ? $response->json() : []);
    }

    /**
     * Get districts (kecamatan) by regency ID
     */
    public function districts(string $regencyId)
    {
        $response = Http::get($this->baseUrl . '/districts/' . $regencyId . '.json');
        return response()->json($response->successful() ? $response->json() : []);
    }
}
