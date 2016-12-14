<?php

echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']);

file_put_contents('results/hello', 'hello');
