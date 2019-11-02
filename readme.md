# Chart
This code use Laravel 5.8 and consoletvs/charts to generate product charts 

## Generate products

With artisan command is possible to generate new faker register.

```bash
php artisan faker:products {int}
```

The int parameter defines how much thousands of products will be inserts. The script will insert jobs in a queue to process the inserts.

```bash
php artisan queue:work
```

## Route
The route to generate the chats is:


```bash
http://host/{minPrice?}/{maxPrice?}/{minReviews?}/{maxReviews?}/{dateFirstListedMin?}/{dateFirstListedMax?}
```

Ex:

```bash
http://host/%20/100/%20/500
```
### Whay?
The solution use queue to insert in an async way the products can run these inserts in different servers.

Using a cache layer is possible to render the charts avoiding access in each interaction in the database
