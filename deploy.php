<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:bluedreamer/dnd_money.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('dndmoney.test')
    ->set('remote_user', 'dndmoney')
    ->set('deploy_path', '~/prod');

// Hooks

after('deploy:failed', 'deploy:unlock');
