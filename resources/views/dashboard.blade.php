<x-app-layout>
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet" type="text/css">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gold Exchange') }}
        </h2>
    </x-slot>
    @include('sweetalert::alert')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                        <form method="get" name="conversion" id="conversion" action="{{route('convert.gold.to.currency')}}">
                            @csrf
                            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                                <div class="grid grid-cols-3 md:grid-cols-2">
                                    <div class="p-6">
                                        <div class="flex items-center">
                                            <img src="https://pixsector.com/cache/1549118e/av70a149d5d0f534e7ab0.png" class="img" alt="curreency"/>
                                            <div class="ml-4 text-lg leading-7 font-semibold">Gold [g]</div>
                                        </div>

                                        <div class="ml-12">
                                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                                <input type="number" id="amount" name="amount" class="field" step="0.01" required>
                                                <a class="swap" id="swap" href="{{route('convertGoldToCurrency')}}"><></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                                        <div class="flex items-center">
                                            <img src="https://pixsector.com/cache/1549118e/av70a149d5d0f534e7ab0.png" class="img" alt="curreency"/>
                                            <div class="ml-4 text-lg leading-7 font-semibold"><a href="https://laracasts.com" class="underline text-gray-900 dark:text-white">To</a></div>
                                        </div>

                                        <div class="ml-12">
                                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                                <select id="currency" name="currency" class="field">
                                                    <option value="PLN">polski złoty</option>
                                                    <option value="UAH">hrywna (Ukraina)</option>
                                                    <option value="USD">dolar amerykański</option>
                                                    <option value="THB">bat (Tajlandia)</option>
                                                    <option value="AUD">dolar australijski</option>
                                                    <option value="PHP">peso filipińskie</option>
                                                    <option value="HRK">kuna (Chorwacja)</option>
                                                    <option value="CZK">yuan renminbi (Chiny)</option>
                                                    <option value="CNY">lira turecka</option>
                                                    <option value="TRY">dolar kanadyjski</option>
                                                    <option value="TRY">dolar kanadyjski</option>
                                                    <option value="CAD">dolar kanadyjski</option>
                                                    <option value="BGN">lew (Bułgaria)</option>
                                                    <option value="MYR">ringgit (Malezja)</option>
                                                    <option value="HKD">dolar Hongkongu </option>
                                                    <option value="ISK">korona islandzka </option>
                                                    <option value="HUF">forint (Węgry)</option>
                                                    <option value="BRL">real (Brazylia)</option>
                                                    <option value="GBP">funt szterling</option>
                                                    <option value="MXN">peso meksykańskie</option>
                                                    <option value="CLP">peso chilijskie </option>
                                                    <option value="INR">rupia indyjska</option>
                                                    <option value="DKK">korona duńska</option>
                                                    <option value="SGD">dolar singapurski</option>
                                                    <option value="CHF">frank szwajcarski</option>
                                                    <option value="XDR">SDR (MFW)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="convert" name="convert" id="convert" >CONVERT</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
