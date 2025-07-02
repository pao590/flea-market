# 実践学習ターム模擬案件初級\_フリマアプリ

## 環境構築　

リポジトリをクローン
git clone https://github.com/your-repo.git

ディレクトリ移動
cd your-repo

.env ファイル作成
cp .env.example .env

コンテナ起動
docker compose up -d --build

マイグレーションと初期データ投入
docker exec -it app php artisan migrate --seed

## 使用技術

Laravel 10.x（PHP 8.x）

Laravel Fortify（認証機能）

MySQL 8.x

Docker / Docker Compose

Blade（テンプレートエンジン）

Tailwind CSS（スタイル）

Git / GitHub

## ER 図

## URL

http://localhost
