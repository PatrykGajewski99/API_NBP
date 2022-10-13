<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;

class CurrencyController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $response= Http::get("http://api.nbp.pl/api/exchangerates/tables/A/");
            if($response->status() === 200)
            {
                $collection = json_decode($response);
                for( $i = 0 ; $i < sizeof($collection[0]->rates) ; $i++)
                {
                    $data = [
                    'name' => $collection[0]->rates[$i]->currency,
                    'currency_code' => $collection[0]->rates[$i]->code,
                    'exchange_rate' => $collection[0]->rates[$i]->mid,
                ];

                }

                return response()->json([
                    'message' => 'Records created'
                ], 201);
            }
            else
            {
                return response()->json([
                    'message' => 'no content'
                ], 404);
            }
        }catch(\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

    }

}