[ -e papertrail-for-wordpress.zip ] && rm papertrail-for-wordpress.zip

zip papertrail-for-wordpress.zip readme.txt
zip papertrail-for-wordpress.zip LICENSE
zip papertrail-for-wordpress.zip papertrail-for-wordpress.php
zip papertrail-for-wordpress.zip uninstall.php
zip papertrail-for-wordpress.zip screenshot-1.png
zip -r papertrail-for-wordpress.zip php