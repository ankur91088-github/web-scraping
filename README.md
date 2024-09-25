# web-scrapping-test
Note this code is specific for 'https://www.magpiehq.com/developer-challenge/'

**Requirements**
PHP 7.4+
Laravel
Composer

**Setup**
git clone https://github.com/ankur91088-github/web-scrapping-test.git
cd web-scrapping-test
composer install

**To run the scrape you can use below command**
php artisan serve
copy and paste url that display on screen example http://127.0.0.1:8000
change url to  https://YOUR-URL/scrape
example http://127.0.0.1:8000/scrape

once run output.json file is created in storage\app\private\ folder

additional data
for adding currency symbol and currency name (like USD,EURO etc) uncomment the code in App\Http\Resources\ProductResource.php file 
