<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class CurrencyService
{
    public int $length;

    protected function read(): JsonResponse
    {

        try {
            $response = Http::get("https://api.nbp.pl/api/exchangerates/tables/A");
            $collection = json_decode($response);
            return response()->json([
                $collection[0]->rates
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }

    }

    public function store(Request $request): JsonResponse
    {
        $data = self::read();
        if ($data->status() === 201) {
            $content = $data->getOriginalContent();
            $this->length = sizeof($content[0]);
            for ($i = 0; $i < $this->length; $i++) {
                Currency::updateOrCreate(
                    ['name' => $content[0][$i]->currency],
                    ['currency_code' => $content[0][$i]->code, 'exchange_rate' => $content[0][$i]->mid]
                );
            }
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
