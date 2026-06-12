@echo off
cd /d C:\projetos\gameverse
C:\php\php-8.5.2\php.exe -d extension_dir=C:\php\php-8.5.2\ext -d extension=pdo_mysql -d extension=mysqli -S 127.0.0.1:8000 -t public
