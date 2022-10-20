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


    public function convertCurrency(CurrencyRequest $request): void
    {
        try {
            $exchangeRateTo = self::getExchangeRate($request->to);
            $exchangeRateFrom = self::getExchangeRate($request->from);

            $totalValue = ($request->amount * $exchangeRateFrom) / $exchangeRateTo;
            $result = $request->amount . " " . $request->from . " = " . round($totalValue, 2) . " " . $request->to;

            Alert::success('Currency conversion amount', $result);
        } catch (\Exception $e) {
            Alert::error('Something was wrong', $e->getMessage());
        }
    }

    private function getExchangeRate(string $currencyCode): float
    {
        $currency = Currency::select('exchange_rate')
            ->where('currency_code', $currencyCode)
            ->first();;
        return $currency->exchange_rate;
    }

    public function checkCurrencyRate(Request $request)  : void
    {
        try {
            $data = $this->readAPI($request->date, $request->currency);
            $currencyRate = $data['mid'];
            Alert::success($request->currency . " rate on " . $request->date, $currencyRate . " " . $request->currency);
        } catch (\Exception $e) {
            Alert::error('Something was wrong', $e->getMessage());
        }
    }

    private function readAPI(string $date, string $currencyCode)
    {
        $response = Http::get("https://api.nbp.pl/api/exchangerates/rates/A/$currencyCode/$date/");
        $collection = $response->json();
        return $collection['rates'][0];

    }

}
