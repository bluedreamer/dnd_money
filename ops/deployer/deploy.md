# New Install
Create `.env` from copy of `.env.example`
* Change logging to syslog
* Change mysql params
* Change MAIL_HOST
* Change MAIL to sendmail

### Check storage perms
    chmod -R g+w storage/
    chmod g+w database/
    chmod g+w database/

# New package unpacking
    composer install --optimize-autoloader --no-dev
    npm install
    npm run build

### Generate key if needed
    artisan key:generate

### Update database
    artisan migrate 

### Setup Caching
    artisan config:cache
    artisan event:cache
    artisan route:cache
    artisan view:cache

### Restart php-fpm
    systemctl restart php-fpm

