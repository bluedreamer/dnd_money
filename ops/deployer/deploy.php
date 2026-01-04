<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:bluedreamer/dnd_money.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('orion')
    ->set('remote_user', 'dnd_money')
    ->set('deploy_path', '~/dnd_money');

// Hooks

after('deploy:failed', 'deploy:unlock');
