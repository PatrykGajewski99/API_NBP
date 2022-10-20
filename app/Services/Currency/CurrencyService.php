<?php

namespace App\Services\Currency;

use App\Http\Requests\CurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Mockery\Exception;
use RealRashid\SweetAlert\Facades\Alert;

class CurrencyService
{

    public function store(Request $request): JsonResponse
    {
        $data = self::read();
        if ($data->status() === 201) {
            $content = $data->getOriginalContent();
            $length = sizeof($content[0]);
            for ($i = 0; $i < $length; $i++) {
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

    protected function read(): JsonResponse
    {

        try {
            $response = Http::get("https://api.nbp.pl/api/exchangerates/tables/A");
            $collection = json_decode($response);
            dd($collection->fi);
            return response()->json([
                $collection[0]->rates
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }

    }

    private function getExchangeRate(string $currencyCode): float
    {
        $currency = Currency::select('exchange_rate')
            ->where('currency_code', $currencyCode)
            ->first();;
        return $currency->exchange_rate;
    }

    public function convertCurrency(CurrencyRequest $request)
    {

        $exchangeRateTo = self::getExchangeRate($request->to);
        $exchangeRateFrom = self::getExchangeRate($request->from);
        $totalValue = ($request->amount * $exchangeRateFrom) / $exchangeRateTo;

        $result = $request->amount . " " . $request->from . " = " . round($totalValue, 2) . " " . $request->to;

        Alert::success('Currency conversion amount', $result);
        return $result;

    }


}
