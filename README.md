# PHP Quality Assurance Team Web Page

This site is hosted online at [qa.php.net](https://qa.php.net).

## Local installation

This repo depends on https://git.php.net/?p=web/shared.git;a=summary

Please clone that repo into this websites root directory.

```bash
git clone git://git.php.net/web/qa.git qa
cd qa
git clone git://git.php.net/web/shared.git shared
cp pulls/config.php.in pulls/config.php
php -S localhost:8080
```
