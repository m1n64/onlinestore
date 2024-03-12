### Online File Store
*****

Stack: Laravel 11, Laravel Octane (swoole), Vue 3, Inertia.js, Vite

*****

### Requirements: 
1. PHP 8.2+
2. composer 2.x+
3. PgSQL 15
4. node 16+
5. npm 8+
6. Mailhog
7. Redis
8. minio
9. adminer
10. Docker & docker-compose (required)

******

### How to setup

```bash
git clone https://github.com/m1n64/onlinestore.git
```
```bash
cd onlinestore/
```
```bash
cp .env.example .env
```
First start:
```bash
./sail -f docker-compose.yml -f docker-compose.dev.yml -f docker-compose.bucket.yml up -d --build
```
Next launches:
```bash
./sail -f docker-compose.yml -f docker-compose.dev.yml up -d
```

Now, open in browser link [http://localhost/](http://localhost/)

******

### Demo


https://user-images.githubusercontent.com/24874264/210282812-ea4f5bc4-648c-4f62-8da2-f366ebe4d85a.mp4


******
