<?php

namespace Database\Seeders;

use App\Models\Currency;
use Database\Factories\CurrencyFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::factory()->create([
            'name' => 'Polish Zloty',
            'currency_code' => 'PLN',
            'exchange_rate' => '1.00']);
    }
}
