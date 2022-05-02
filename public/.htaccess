DirectoryIndex index.php

RewriteEngine on
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond $1 !^(index\.php|robots\.txt)

RewriteRule ^(.*)$ index.php?/$1 [L]
