<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Mockery\Exception;
use RealRashid\SweetAlert\Facades\Alert;

class CurrencyService
{
    private int $length;
    private float $amount,$exchangeRate,$totalValue;
    private string $currencyCodeFrom,$currencyCodeTo,$result;

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

    private function getExchangeRate(string $currencyCode) : float
    {
        $currency = Currency::select('exchange_rate')
            ->where('currency_code',$currencyCode)
            ->get();

        return $currency[0]->exchange_rate;
    }

    private function validateForm(Request $request): JsonResponse
    {
        try {
            $this->amount = $request->amount;
            $this->currencyCodeFrom = $request->from;
            $this->currencyCodeTo = $request->to;

            $request->validate([
                'amount' => 'required|numeric',
                'from' => 'required|string|min:3',
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

    public function convertCurrency(Request $request)
    {
            if(self::validateForm($request)->getStatusCode() === 201)
            {
                if($this->currencyCodeFrom === "PLN")
                {
                    $this->exchangeRate = self::getExchangeRate($this->currencyCodeTo);
                    $this->totalValue = $this->amount / $this->exchangeRate;
                }
                else
                {
                    $this->exchangeRate = self::getExchangeRate($this->currencyCodeFrom);
                    $this->totalValue = $this->amount * $this->exchangeRate;
                }
                $this->result = $request->amount." ".$request->from." = ".round($this->totalValue,2)." ".$request->to;

                Alert::success('Currency conversion amount',$this->result);
                return $this->result;
            }
    }

}
