<?php

namespace App\Services;

use App\Models\Gold;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GoldService
{
    protected function read(): JsonResponse
    {

        try {
            $response = Http::get("http://api.nbp.pl/api/cenyzlota");
            $collection = json_decode($response);
            return response()->json([
                $collection[0]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }

    }

    public function store(): JsonResponse
    {
        $data = self::read();
        if ($data->status() === 201) {
            $content = $data->getOriginalContent();
                Gold::updateOrCreate(
                    ['name' => 'gold'],
                    ['exchange_rate' => $content[0]->cena]
                );
            return response()->json([
                'message' => 'Records created'
            ], 201);
        } else {
            return response()->json([
                'message' => 'no content'
            ], 404);
        }
    }
}
