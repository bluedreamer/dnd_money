# New Install
Create `.env` from copy of `.env.example`
* Change logging to syslog
* Change mysql params
* Change MAIL_HOST
* Change MAIL to sendmail

### Make sure apache is in server user group
`usermod -a -G deadpair apache`

### Check storage perms
    chmod -R g+w storage/

# New package unpacking
    composer install --optimize-autoloader --no-dev
    npm update
    npm run build

### Update database
    artisan migrate --seed
    artisan db:seed ReleaseSeeder
    artisan db:seed FeatureSeeder

### Setup Caching
    artisan config:cache
    artisan event:cache
    artisan route:cache
    artisan view:cache

### Restart php-fpm
    systemctl restart php-fpm

### Generate key if needed
    artisan key:generate

### New Database install
    artisan migrate:fresh --seed

