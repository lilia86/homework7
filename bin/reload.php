<?php


function show_run($text, $command, $canFail = false)
{
    echo "\n* $text\n$command\n";
    passthru($command, $return);
    if (0 !== $return && !$canFail) {
        echo "\n/!\\ The command returned $return\n";
        exit(1);
    }
}
show_run('export env', 'export SYMFONY_ENV=prod');
show_run('composer install', 'composer install --no-dev --optimize-autoloader');
show_run('clear cash', 'php bin/console cache:clear --env=prod --no-debug');

exit(0);
