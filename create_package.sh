[ -e logging-with-papertrail.zip ] && rm logging-with-papertrail.zip

zip logging-with-papertrail.zip readme.txt
zip logging-with-papertrail.zip LICENSE
zip logging-with-papertrail.zip logging-with-papertrail.php
zip logging-with-papertrail.zip uninstall.php
zip -r logging-with-papertrail.zip php
zip -r logging-with-papertrail.zip assets 