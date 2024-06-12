セットアップ方法
以下をターミナルで実行
git clone https://github.com/sho0109/retrek-ui.git

cd retrek-ui

git clone https://github.com/clinfo/ReTReKpy.git

Dockerコンテナの反映（以下をターミナルで実行）
docker-compose down

docker-compose rm -f

docker volume prune -f

docker network prune -f


./vendor/bin/sail up -d

./vendor/bin/sail composer install

./vendor/bin/sail artisan key:generate

./vendor/bin/sail artisan migrate
 
sudo chown -R $USER:$USER /var/www/html

sudo chmod -R 755 /var/www/html

使用方法（以下のコマンドをターミナルで実行したのち、localhost80に接続して使用する）
./vendor/bin/sail up
ブラウザで http://localhostに接続する
