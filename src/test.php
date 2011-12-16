<?php

require_once __DIR__ .'/../autoload.php';

$c = new Clinner\Command\Command('ls');

$r = new Clinner\Runner();

$r->run($c);

$e = new \Clinner\Executor\Buffered();

$r = new \Clinner\Runner(null, $e);

$r->run($c);

var_dump($e->getBuffer());