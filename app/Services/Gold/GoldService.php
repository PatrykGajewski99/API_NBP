<?php

namespace App\Services\Gold;

use App\Http\Requests\GoldRequest;
use App\Models\Gold;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;
use RealRashid\SweetAlert\Facades\Alert;

class GoldService
{

    private function getGoldExchangeRate() : float
    {
        $currency = Gold::select('exchange_rate')
            ->first();
        return $currency->exchange_rate;
    }

    private function getCurrencyExchangeRate(string $currencyCode) : float
    {
        $currency = Currency::select('exchange_rate')
            ->where('currency_code',$currencyCode)
            ->first();
        return $currency->exchange_rate;
    }

    public function convertGoldToCurrency(GoldRequest $request) : float
    {
            $exchangeGoldRate = self::getGoldExchangeRate();
            $exchangeCurrencyRate = self::getCurrencyExchangeRate($request->currency);

            $totalValue = $request->amount * ($exchangeGoldRate / $exchangeCurrencyRate);

            $result = $request->amount." [g]"." = ".round($totalValue,2)." ".$request->currency;
            Alert::success('Gold conversion to currency ',$result);

            return $totalValue;

    }

    public function convertCurrencyToGold(GoldRequest $request) : float
    {
        $exchangeGoldRate = self::getGoldExchangeRate();
        $exchangeCurrencyRate = self::getCurrencyExchangeRate($request->currency);

        $totalValue = ($request->amount *  $exchangeCurrencyRate)/$exchangeGoldRate;

        $result = $request->amount . " ".$request->currency." = ".round($totalValue,2)." [g]";
        Alert::success('Currency conversion to gold',$result);

        return $totalValue;

    }

}
