Hello everyone. Currency Converter is an application which I was created step by step with using NBP Api, Laravel version 9, and PHP version 7.4. If we are not login into the system we can only convert currency but when we are registered we can also: convert gold to currency or currency to gold, check the currency rate on specific date. System update the currency rate and gold rate hourly.

How to use this app ?


1. We have to download this app and open the project in PhpStorm / Visual Studio Code etc

2. Upload this database file -> [nbp.zip](https://github.com/PatrykGajewski99/API_NBP/files/9830857/nbp.zip)

3. Open a terminal and write this command "php artisan schedule:work". ( we have to write this command because we use cron jobs. If we don't write it system can't update our currency and gold rate from NBP API) 

4. Open second terminal and write command "php artisan serv"

5.If you wanna use all functionalities you should create an account and after that log in to the system.

I will be very grateful for every suggestion about my code. Thank you in advance. If you wanna read more about my application , I put here my portfolio -> https://pgajewski.pl/
