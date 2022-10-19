<?php

namespace App\Services\Gold;

use App\Models\Gold;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;
use RealRashid\SweetAlert\Facades\Alert;

class GoldService
{
    private float $amount,$exchangeGoldRate,$exchangeCurrencyRate,$totalValue;
    private string $currencyCodeTo,$result;

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

    private function getGoldExchangeRate() : float
    {
        $currency = Gold::select('exchange_rate')
            ->get();

        return $currency[0]->exchange_rate;
    }

    private function getCurrencyExchangeRate(string $currencyCode) : float
    {
        $currency = Currency::select('exchange_rate')
            ->where('currency_code',$currencyCode)
            ->get();

        return $currency[0]->exchange_rate;
    }
    private function validateForm(Request $request): JsonResponse
    {
        try {
            $this->amount = $request->gold;
            $this->currencyCodeTo = $request->to;

            $request->validate([
                'gold' => 'required|numeric',
                'to' => 'required|string|min:3',
            ]);
            return response()->json([
                'message' => "success"
            ], 201);

        }catch (Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

    }

    public function convertGoldToCurrency(Request $request)
    {
        if(self::validateForm($request)->getStatusCode() === 201)
        {
            $this->exchangeGoldRate = self::getGoldExchangeRate();
            $this->exchangeCurrencyRate = self::getCurrencyExchangeRate($this->currencyCodeTo);
            $this->totalValue = $this->amount * $this->exchangeGoldRate * $this->exchangeCurrencyRate;

            $this->result = $this->amount." [g]"." = ".round($this->totalValue,2)." ".$request->to;
            Alert::success('Gold conversion amount',$this->result);
            return $this->result;
        }
    }
}
