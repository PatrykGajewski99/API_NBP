@if (Route::has('login'))
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        <a href="{{ route('welcome') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline" style="margin-right: 10px">Currency Exchange</a>
        @auth
        @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
            @endif
        @endauth
        <a href="{{ route('gold.exchange') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Gold Exchange</a>
        <a href="{{ route('currency.rate') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Check Currency Rate</a>
    </div>
@endif
