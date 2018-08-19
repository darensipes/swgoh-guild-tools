#!/bin/bash

sudo mysql -e "CREATE DATABASE IF NOT EXISTS swgoh DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;"
sudo mysql -e "CREATE USER 'swgoh'@'localhost' IDENTIFIED WITH mysql_native_password BY 'swgoh';"
sudo mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'swgoh'@'localhost' IDENTIFIED BY 'swgoh';"
sudo mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'swgoh';"
sudo mysql -e "flush PRIVILEGES;"
