セットアップ方法
以下をターミナルで実行

git clone https://github.com/sho0109/retrek-ui.git

cd retrek-ui

git clone https://github.com/clinfo/ReTReKpy.git


以下のコマンドで.envファイルを.envexampleからコピーする

cp .env.example .env

上記のコマンドで作成した.envファイルの11～16行目を以下のように修正する
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=retrek_ui
DB_USERNAME=sail
DB_PASSWORD=password

また、.envファイルに以下の内容を追記する
WWWUSER=sail
WWWGROUP=sail



Dockerコンテナの反映（以下をターミナルで実行）
docker-compose down

docker-compose rm -f

docker volume prune -f

docker network prune -f

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate

./vendor/bin/sail artisan migrate
 
./vendor/bin/sail npm install

./vendor/bin/sail npm run build


使用方法（以下のコマンドをターミナルで実行したのち、localhost80に接続して使用する）
./vendor/bin/sail up
ブラウザで
http://localhost
に接続する
