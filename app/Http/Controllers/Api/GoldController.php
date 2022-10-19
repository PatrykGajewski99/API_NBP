<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GoldService;
use Illuminate\Http\Request;

class GoldController extends Controller
{
    protected GoldService $goldService;

    public function __construct(GoldService $goldService)
    {
        $this->goldService = $goldService;
    }

    public function store()
    {
        $this->goldService->store();

        return view("/dashboard");
    }

    public function convertGoldToCurrency(Request $request)
    {
        $this->goldService->convertGoldToCurrency($request);

        return view("/dashboard");
    }
}
