# お問い合わせフォーム

## 環境構築

Dockerイメージのビルド

1.docker-compose up -d --build

*MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせて
docker-compose.ymlファイルを編集してください。

Laravel環境構築

1.docker-compose exec php bash
2.composer install
3..env.exampleファイルから.envを作成し、環境変数を変更
4.php artisan key:generate
5.php artisan migrate
6.php artisan db:seed

## 使用技術

- Laravel 10.x
- PHP 8.1
- MySQL 8.0

## ER図
まだ未作成です。

## URL
・開発環境：http://localhost/
・phpMyAdmin：http://localhost:8080/