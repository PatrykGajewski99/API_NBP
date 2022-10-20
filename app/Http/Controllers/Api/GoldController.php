<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GoldRequest;
use App\Services\Gold\GoldService;
use Illuminate\Http\Request;

class GoldController extends Controller
{
    protected GoldService $goldService;

    public function __construct(GoldService $goldService)
    {
        $this->goldService = $goldService;
    }

    public function convertGoldToCurrency(GoldRequest $request)
    {
        $this->goldService->convertGoldToCurrency($request);

        return view("/dashboard");
    }

    public function convertCurrencyToGold(GoldRequest $request)
    {
        $this->goldService->convertCurrencyToGold($request);

        return view("/dashboard");
    }

}
