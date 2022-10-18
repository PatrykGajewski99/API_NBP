<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CurrencyService;


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

    public function store(Request $request)
    {
        $this->currencyService->store($request);

        return view("/welcome");
    }

    public function convertPLN(Request $request)
    {
        $this->currencyService->convertCurrency($request);
        return view("/welcome");
    }
}
