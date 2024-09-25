# Web-scraping
This is a web scraping project built using Laravel, designed to extract product data (such as name, price, color variants, availability, shipping information, and images) from a target website and export the results into a JSON file. The scraper handles products with multiple color variants and saves the data in an easily consumable JSON format for later use.

**Note** This code is specific for 'https://www.magpiehq.com/developer-challenge/'


# Prerequisites

Before you begin, ensure you have the following installed:

PHP (>= 7.4)

Composer (for managing PHP dependencies)

Laravel (>= 8.x)

SQLite (or your preferred database system we use sqlite)

XAMPP (optional for local development environment)

Symfony DomCrawler and Guzzle for scraping

Git (for version control)

Enable the SQLite Extension
Edit php.ini file and enable extension 
```bash
extension=sqlite3
extension=pdo_sqlite
```

# Project Setup
1. **Clone the Repository**
First, clone the project repository to your local machine:
```bash
git clone https://github.com/ankur91088-github/web-scraping.git
```
```bash
cd web-scraping
```
2. **Install dependencies**
```bash
 composer install
```
3. **Setup Environment**

Edit the .env file and modify according to your environment (for localhost all variable is set)

For SQLite, ensure you configure it properly in .env like this:
```bash
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```
# Running the Web Scraper
**To run the scrape you can use below command**
```bash
php artisan serve
```

copy and paste url that display on screen example http://127.0.0.1:8000

change url to  https://YOUR-URL/scrape 
(replace YOUR-URL with the url display on screen when run command)
example http://127.0.0.1:8000/scrape

once run **output.json** file is created and automatically downloaded on your system .If there is no data available then message display on screen "No Data found on this url."

# Output

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
