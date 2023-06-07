<?php
spl_autoload_register(function ($class) {
  $class_file = __DIR__ . '/classes/' . str_replace('\\', '/', $class) . '.php';
  if (file_exists($class_file)) {
    require_once $class_file;
  }
});

require_once __DIR__.'/functions/utils.php';