<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CurrencyCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $response = Http::get("https://api.nbp.pl/api/exchangerates/tables/A");
        $collection = $response->json();
        $rates = $collection[0]['rates'];
        $length = sizeof($rates);
        for ($i = 0; $i < $length; $i++) {
            Currency::updateOrCreate(
                ['name' => $rates[$i]['currency']],
                ['currency_code' => $rates[$i]['code'], 'exchange_rate' => $rates[$i]['mid']]
            );
        }
        return 0;
    }
}
