# The source code of ryutahamasaki.com
~~This repo contains the source code of my Laravel powered blog at [ryutahamasaki.com](https://ryutahamasaki.com).
It's exported as a static site and deployed to Netlify.~~

[ryutahamasaki.com](https://ryutahamasaki.com) has been migrated to a JAMstack Nuxt.js app and hosted on Netlify. You can find the source code at https://github.com/avosalmon/blog-nuxt.

## Setup local environment
Install dependencies.
```sh
$ composer install
$ npm install
```

Run docker containers.
```sh
$ docker-compose up -d
```

Migrate database.
```sh
$ docker-compose exec php php artisan migrate
```

Build assets.
```sh
$ npm run dev
```

If you use `public` disc, make sure to create a symbolic link by runnning `storage:link` Artisan command.
https://laravel.com/docs/6.x/filesystem#the-public-disk
```sh
$ docker-compose exec php php artisan storage:link
```

If you want to upload images to S3 with cache-control header, add `CacheControl` option in `filesystems.php` config file. Also, you can specify CDN base url such as CloudFront.

```php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('CDN_URL'),
    'options' => [
        'CacheControl' => 'public, max-age=315360000'
    ],
],
```

Now you can access your site with http://localhost:8080.
Admin panel is powered by [Wink](https://github.com/writingink/wink) and accessible with http://localhost:8080/wink.

## Deploy to Netlify as a static site
You can export the entire site as a static site using [spatie/laravel-export](https://github.com/spatie/laravel-export) package and deploy to Netlify. That's blazing fast and scalable 🚀.
```sh
$ npm run prod
$ docker-compose exec php php artisan export
```

Install [Netlify CLI](https://docs.netlify.com/cli/get-started/) if you don't have it.
```sh
$ npm install netlify-cli -g
```

Deploy!
```sh
$ netlify deploy --prod
```

## Roadmap
- [x] Setup local environment with Docker
- [x] Add admin CMS with [Wink](https://wink.themsaid.com/)
- [x] Implement a theme
- [x] Remove unused CSS by [PurgeCSS](https://www.purgecss.com/)
- [x] Export as a static site and deploy to Netlify with [Laravel Export](https://github.com/spatie/laravel-export)
- [x] Add to Google Search Console
- [x] Add GA or GTM
- [ ] Add sitemap
