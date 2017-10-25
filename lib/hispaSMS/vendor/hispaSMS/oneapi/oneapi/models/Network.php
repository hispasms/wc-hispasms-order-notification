<?php

namespace hispaSMS\models;

use hispaSMS\Models;
use hispaSMS\SubObjectConversionRule;

class Network extends AbstractObject {
    public $id;
    public $name;
    public $country;
    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }
}
Models::register(
    'hispaSMS\models\Network',
    new SubObjectConversionRule('hispaSMS\models\Country', 'country')
);
?>