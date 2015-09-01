<?php
/*
This is the entrypoint of the application.
Here we run all code that must be ran for every request to our site.
We could seperate this a little, eg by creating a config.php and routes.php file, and 'require' ing them
but for this example the code is short, so we can keep it in the index.php file.
This should be the ONLY file you use phps 'include' or 'require' in, (with the exception of including subtemplates, if you dont use f3 template engine)
everywhere else should rely on autoloading
*/
//include and initialize the framework
$f3=require('../lib/base.php');

//set some config settings, to tell f3 how to display errors, where to look for templates, and where to load classes from
$f3->set('DEBUG', 3);
$f3->set('UI', '../app/views');
$f3->set('AUTOLOAD', '../app/');
//create any objects we will need throughout our application.
//Here the only thing is the DB connection.
$f3->set('db',
        new \DB\SQL(
            'mysql:host=localhost;port=3306;dbname=davidfoy',
            'root',
            ''
        )
);
//create our routes
$f3->route('GET /', 'Controllers\Card->home');
$f3->route('GET /cards/@category', 'Controllers\Card->showList');
$f3->route('GET /card/@id', 'Controllers\Card->showSingle');

$f3->run();
