<?php
class controller{
    var $vars= array();

    function charger($donnees){
        $this->vars=array_merge($this->vars,$donnees);
    }

    function  render($filename){
        extract($this->vars);
        ob_start();
        require(ROOT.'views/'.get_class($this).'/'.$filename.'.php');

    }

    /**
     *
     * fonction pour loader un model
     * params: nomModel
     */
    public function loadModel($name) {

        $path = ROOT.'/models/'.$name.'.php';
        if (file_exists($path)) {
            require_once $path;
            $this->$name = new $name();
        }
    }
}
?>