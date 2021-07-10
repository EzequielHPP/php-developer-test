# API Documentation
<sub><sup>by Ezequiel Pereira</sup></sub>


Simple API to retrieve a few articles list and get the actual full article.

---
## Framework 🛠
[Slim Framework](https://www.slimframework.com/) V4.7.1

---
## Dependencies 🔗
- [Composer](https://getcomposer.org/)
- [PHP 7.4.*](https://www.php.net/downloads.php)

## Extra dependencies ➕
#### (Installed with composer)
- [guzzlehttp](https://github.com/guzzle/guzzle) V1.8.1
- [http-factory-guzzle](https://github.com/http-interop/http-factory-guzzle) V1.0.0
- [paquettg/php-html-parser](https://github.com/paquettg/php-html-parser) V3.1.1

---
## Running 🚀
First run the following to install all the Extra Dependencies
```shell
composer install
```  

To start the server run on of the following commands:

```shell
composer start
```
or
```shell
php -S localhost:<port>
```  

---
## Routes 💻

| URL | Description |
|---|---|
|  [`/`](http://localhost:8888) | Homepage |
| [`/v1/`](http://localhost:8888/v1) | V1 Homepage |
| [`/v1/articles`](http://localhost:8888/v1/articles) | List all articles |
| [`/v1/articles/:id`](http://localhost:8888/v1/articles/1) | Single article <sub><sup>(replace :id with the id of the article)</sup></sub> |

Any invalid [url](http://localhost:8888/invalid-url) will result into the following `404` error:
```json
{"error":"Url does not exist"}
```

All routes <sub><sup>(except the homepages)</sup></sub> reply with a json response:
```http request
Content-Type: application/json
```

---
## Tests 📘

To run the tests, use the following command:
```shell
composer test
```

---
## Structure 📁

| Folder | Description |
|---|---|
| `/app` | Contains the `routes.php` file, where the application routes are defined. They are organized by [route groups](https://www.slimframework.com/docs/v4/objects/routing.html#route-groups) on versions. |
| `/assets` | Where the `Articles` table is defined. |
| `/src` | Where the application logic is stored. |
| `/src/Helpers` | Helper classes. Where static functions can be stored and reused throughout the platform |
| `/src/Http` | Controllers and Services are store here. This has a sub-folder with the version `v1` where we can separate the Controller and Services for each version|
| `/src/Model` | The model files are set here. These are the connection between the code and the Database / json files |
| `/src/System` | BaseModel extension file for all the models, Constants, Reply / send to view, Translator are defined here |
| `/src/System/Config` | All the required configurations are here |
| `/src/System/Exception` | System Exceptions defined here |
| `/tests` | All the phpunit tests are set here |
