Учёт оргтехники в организации v4.X 2019-20XX

Система предназначена для учёта оргтехники в небольших организациях и будет полезна в основном инженерам IT отдела, ведущими учёт без фанатизма.

Внимание! Верcия в разработке. Пока не рабочая от слова "совсем". Пока используйте версию 3.x https://github.com/donpadlo/webuseorg3

Настройка apache для Ubuntu примерно такая:
```shell
<VirtualHost 127.0.0.129>
    DocumentRoot /var/www/webuserorg4/public
    <Directory /var/www/webuserorg4/public>
        AllowOverride all
        allow from all
        Options Indexes FollowSymLinks
        Require all granted
    </Directory>
    LogLevel debug
    ErrorLog /var/log/apache2/wo4.log
    TransferLog /var/log/apache2/wo4.log
</VirtualHost>
```