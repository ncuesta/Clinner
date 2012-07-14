# Clinner

[![Build Status](https://secure.travis-ci.org/ncuesta/Clinner.png)](http://travis-ci.org/ncuesta/Clinner)

`Clinner` is a PHP 5.3+ Command-Line Interface commands execution abstraction.

## Advantages

`Clinner` has the following benefits:

  * Minimalistic.
  * Simple and easy to use.
  * `Clinner` uses [Composer](http://getcomposer.org). You can use it as a dependency on your project and have it autoloaded.
  * Fluent API.
  * Higher-level and object oriented interface to commands.
  * Command pipes, **regardless of the underlying OS**.
  * Commands might be actual command-line executables or PHP code.
  * *Yes, you can mix commands and PHP code in an OO way!*
  * Easily extendable through Interface implementation.
  * MIT Licensed.

## Usage

### Simple usage

The most basic use of `Clinner` consists of including [the PHAR file](https://github.com/ncuesta/Clinner/blob/master/clinner.phar?raw=true)
and using its `Command` class:

```php
<?php

    // List current working directory's files and store the list as a string
    require_once 'phar://clinner.phar/autoload.php';

    $command = new \Clinner\Command\Command('ls');
    $files = $command
        ->run()
        ->getOutput();
    // Or get them as an array
    $filesArray = $command->getOutputAsArray();

    if ($command->getExitCode() === 0) {
        echo 'Everything went fine.';
    } else {
        echo 'Something didn\'t work as expected...';
    }

    // There's also a factory method that allows to make best use of the fluent API
    echo \Clinner\Command\Command::create('ls')
        ->run()
        ->getOutput();
```

### Passing arguments

Commands crave for arguments, so `Clinner` offers a way to satisfying them.
By passing in a second argument to the factory method or the constructor, or using the dedicated setter
method `setArguments()`.

```php
<?php

    // Commands will most certainly take arguments, so let's try something with them
    $command = new \Clinner\Command\Command('cat', array('/etc/hosts'));
    // This will run `cat /etc/hosts`
    $command->run();

    // You might also use its factory method to take even more advantage of the fluent API
    echo \Clinner\Command\Command::create('cat', array('/etc/hosts'))
        ->run()
        ->getOutput();
```

Arguments can either be key-value pairs or just values. Key value pairs will be joined using a
`delimiter` (see **Options** section for more information).

### Options

Options allow customization of different `Command` behaviors. They can be passed in as a third
argument for the factory method or constructor, or set via the `setOptions()` method.

Currently there's only one thing that can be customized for the `Command` class, but it's worth
noting it: you might specify the delimiter, a `string` that will be used to join key-value pairs
of arguments. If not specified, it will default to the equals sign (`=`).

Let's see an example:

```php
<?php

    // `cut` command won't work if key-value pairs of arguments are joined with '=':
    $command = \Clinner\Command\Command::create(
        'cut',
        array(
            '-d' => ':',
            '-f' => 1,
            '/etc/passwd',
        )
    );

    $command->run(); // => will run `cut -d=: -f=1 /etc/passwd` (WRONG)

    $command->setOptions(array('delimiter' => ''));

    $command->run(); // => will run `cut -d: -f1 /etc/passwd` (CORRECT)
```

### Advanced usage: Commands pipes

Commands can be piped just like in any Unix shell. The basics of command pipes is that the output
of a command is sent to the one that is piped to it.

For example, if you want to run `ls -a | grep -i clinner`, you can:

```php
<?php

    $grepCommand = \Clinner\Command\Command::create('grep', array('-i', 'clinner'));
    $lsCommand   = \Clinner\Command\Command::create('ls', array('-a'));

    $lsCommand
        ->pipe($grepCommand)
        ->run();

    $pipeOutput = $lsCommand->getOutput();

    // Or the same thing in an uglier but more pro way
    use \Clinner\Command\Command;

    $pipeOutput = Command::create('ls', array('-a'))
        ->pipe(Command::create('grep', array('-i', 'clinner')))
        ->run()
        ->getOutput();
```

Command pipes are not limited to a number of commands, you only need *at least* two commands.

See next section for a more complex example involving 3 commands in a pipeline.

### Advanced usage: Mixing PHP with commands

Apart from `Command` class, `Clinner` ships with a `Callback` command class that enables to
mix both commands and PHP code in a command pipe. *Pretty cool, huh?*

`Callback` class only takes a `Closure` or a function reference in its constructor and then
is ready to run. That `Closure` function will receive the command's input as its first argument
and is expected to return an exit code. Any information output by the function (either via `echo`
or `print` or any other output method) will be considered as the command output and will be sent
to the next command in the pipe, if any.

```php
<?php

    // Get all the usernames in the system that contain an 'a' in them
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
        )
        ->pipe(
            Command::create('cut', array('-d' => ':', '-f' => 1), array('delimiter' => ''))
        )
        ->pipe($callbackCommand)
        ->run()
        ->getOutputAsArray("\n");
```

## Requirements

The only requirement for `Clinner` is PHP version >= 5.3.

## Contributing

Please, feel free to fork this repo and improve it in any way you consider useful
 -- Pull Requests are welcome!
