<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use Illuminate\Http\Request;
use App\Services\Currency\CurrencyService;


class CurrencyController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    protected CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function convertCurrency(CurrencyRequest $request)
    {
        $this->currencyService->convertCurrency($request);
        return view("/welcome");
    }

}
