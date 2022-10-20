<?php

namespace App\Console\Commands;

use App\Models\Gold;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GoldCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gold:cron';

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
        $response = Http::get("http://api.nbp.pl/api/cenyzlota");
        $collection = $response->json();
        Gold::updateOrCreate(
            ['name' => 'gold'],
            ['exchange_rate' => $collection[0]['cena']]
        );
        return 0;
    }
}
