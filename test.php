<?php

require_once __DIR__ .'/clinner.phar';

use \Clinner\Command\Command;
use \Clinner\Command\Callback;

/*
$pc = new Clinner\Command\Command('cat', array('/etc/passwd'));

$pc->pipe(new Clinner\Command\Command('cut', array('-d' => ':', '-f' => 1), array('delimiter' => '')));

echo "Running `{$pc->toCommandString(true)}`\n";
echo $pc
    ->run()
    ->getOutput();
echo 'Exit code: ' . $pc->getExitCode();


$callbackCommand = new Callback(function($input) {
    foreach (explode("\n", $input) as $line) {
        if (false !== strchr($line, 'a')) {
            echo "$line\n";
        }
    }
});

$systemUsers = Command::create('cat', array('/etc/passwd'))
    ->pipe(
        Command::create('grep', array('-v' => '^#'), array('delimiter' => ' '))
            ->pipe(Command::create('cut', array('-d' => ':', '-f' => 1), array('delimiter' => ''))
                ->pipe($callbackCommand)
            )
    )
    ->run()
    ->getOutputAsArray("\n");

die(var_dump($systemUsers));
*/

echo "\n\n--------\n\n";

$pc = new Clinner\Command\Command('cat', array('/etc/passwd'));

$pc->pipe(new Clinner\Command\Command('cut', array('-d' => ':', '-f' => 1), array('delimiter' => '')));

echo "Running `{$pc->toCommandString(true)}`\n";

echo $pc->run()->getOutput();
echo 'Exit code: ' . $c->getExitCode();

echo "\n\n--------\n\n";

$pc = new Clinner\Command\Command('cut', array('/etc/passwd'));

echo "Running `{$pc->toCommandString(true)}`\n";

echo $pc->run()->getOutput();
echo 'Exit code: ' . $c->getExitCode();
