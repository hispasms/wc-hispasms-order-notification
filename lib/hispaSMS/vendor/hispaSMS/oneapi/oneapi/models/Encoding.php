<?php

namespace hispaSMS\models;


use hispaSMS\Models;

class Encoding  extends AbstractObject {
    public $name;
    
    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}    
Models::register('hispaSMS\models\Encoding');


?>
