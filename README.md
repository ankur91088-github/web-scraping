# web-scrapping-test
**Note** This code is specific for 'https://www.magpiehq.com/developer-challenge/'


**Requirements**

PHP 8+

Laravel

Composer

Symfony DomCrawler component

**Setup**
```bash
git clone https://github.com/ankur91088-github/web-scrapping-test.git
```
```bash
cd web-scrapping-test
```

**Install dependencies**
```bash
 composer install
```

**To run the scrape you can use below command**
```bash
php artisan serve
```

copy and paste url that display on screen example http://127.0.0.1:8000

change url to  https://YOUR-URL/scrape

example http://127.0.0.1:8000/scrape

once run **output.json** file is created in **storage\app\private** folder

**Output**
The final output will be array of object of different product
```bash
[
    {
        "title": "iPhone 11 Pro",
        "price": 799.99,
        "imageUrl": "https:\/\/www.magpiehq.com\/developer-challenge\/images\/iphone-11-pro.png",
        "capacityMB": 64000,
        "colour": "Green",
        "availabilityText": "Availability: Out of Stock",
        "isAvailable": false,
        "shippingText": "Availability: Out of Stock",
        "shippingDate": null
    },
     {
        "title": "iPhone 12 Pro Max",
        "price": 1099.99,
        "imageUrl": "https:\/\/www.magpiehq.com\/developer-challenge\/images\/iphone-12-pro.png",
        "capacityMB": 128000,
        "colour": "Sky Blue",
        "availabilityText": "Availability: In Stock Online",
        "isAvailable": true,
        "shippingText": "Delivery by 26 Sep 2024",
        "shippingDate": "2024-09-26"
    }
]
```
**Additional data**

for adding currency symbol and currency name (like USD,EURO etc) uncomment the code in App\Http\Resources\ProductResource.php file 
