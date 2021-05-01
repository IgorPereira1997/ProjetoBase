Primeiro, dêem esse comando pra preparar amáquina para php

sudo apt-get install lamp-server^

Depois, digitem

sudo mysql

CREATE USER 'projetoSD'@'localhost' IDENTIFIED BY 'projetoSD2021';
GRANT ALL PRIVILEGES ON *.* TO 'projetoSD'@'localhost' WITH GRANT OPTION;
exit;

Depois, façam esses dois

sudo apt update
sudo apt install phpmyadmin php-mbstring php-gettext

Quando perguntar algum prompt, apertem ESPAÇO, TAB e depois ENTER
Quando perguntar alguma coisa dbconfig-common, selecione SIM
Na senha que pedir, digitem isso e repitam quando pedir de novo: projetoSD2021

Agora, digitem esse comando:

sudo chmod -R 777 /var/www/

Agora, deem o seguinte comando

cd /var/www/

Agora, deem o comando

git clone
