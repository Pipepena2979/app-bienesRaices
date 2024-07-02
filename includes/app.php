<?php
use Model\ActiveRecord;

require __DIR__ . '/../vendor/autoload.php';

require 'funciones.php';
require 'config/database.php';

// Conectar a la base de datos
$db = conexionDB();

ActiveRecord::setDB($db);

// Continuar con el resto de tu aplicación
?>
