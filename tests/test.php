<?php

require 'phar://' . __DIR__ . '/../clinner.phar/autoload.php';


$callbackCommand = new \Clinner\Command\Callback(function($input) {
    foreach (explode("\n", $input) as $line) {
        if (false !== strchr($line, 'x')) {
            echo "$line\n";
        }
    }
});

$systemUsersCommand = \Clinner\Command\Command::create('cat', array('/etc/passwd'))
    ->pipe(\Clinner\Command\Command::create('grep', array('-v' => '^#'), array('delimiter' => ' ')))
    ->pipe(\Clinner\Command\Command::create('cut', array('-d' => ':', '-f' => 1), array('delimiter' => '')))
    ->pipe($callbackCommand);

echo $systemUsersCommand->toCommandString(true) . "\n";

$systemUsers = $systemUsersCommand
    ->run()
    ->getOutputAsArray("\n");

print_r($systemUsers);