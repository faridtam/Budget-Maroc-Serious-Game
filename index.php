<?php
@session_start();
define('RACINE', str_ireplace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT', str_ireplace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
require (ROOT.'config.php');
require (ROOT.'core/database.php');
require (ROOT.'core/model.php');

$url = $_GET['url'];
$url = rtrim($url, '/');
$url = explode('/', $url);

$controller= $url[0];
$url[1] = isset($url[1]) ? $url[1] : 'jouer';

require (ROOT.'core/controller.php');
$file= ROOT.'controllers/' . $url[0] . '.php';
if(file_exists($file)){
    require $file;
}
else{
    throw new Exception('Le fichier: ' .$file. 'n\'existe pas');
}
$controller = new $controller();

if (isset($url[2])) {
    $controller->{$url[1]}($url[2]);
} else {
    if (isset($url[1])) {
        if(method_exists($controller,$url[1])){
            $controller-> $url[1]();
        }
        else{
            echo 'erreur 404';
        }
    }
}


/*$params=explode('/',$_GET['url']);
$controller= $params[0];
$action= isset($params[1]) ? $params[1] : 'index';

require('controllers/'.$controller.'.php');
$controller = new $controller();
*/
