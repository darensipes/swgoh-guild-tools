#!/bin/bash

OUTPUT="/var/www/swgoh/archive/mysql"

databases=`sudo mysql -e "SHOW DATABASES;" | tr -d "| " | grep -v Database`

for db in $databases; do
    if [[ "$db" != "information_schema" ]] && [[ "$db" != "performance_schema" ]] && [[ "$db" != "mysql" ]] && [[ "$db" != "test" ]] && [[ "$db" != "sys" ]] && [[ "$db" != _* ]] ; then
        echo "Dumping database: $db"
        sudo mysqldump --force --opt --databases $db | gzip -9 -c > $OUTPUT/`date +%Y%m%d%H%M%S`.$db.sql.gz
    fi
done
