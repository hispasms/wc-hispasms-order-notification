<?php

namespace hispaSMS\models;

use hispaSMS\Models;
use hispaSMS\ObjectArrayConversionRule;

class Countries extends AbstractObject {

    public $countries;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register(
        'hispaSMS\models\Countries',
        new ObjectArrayConversionRule('hispaSMS\models\Country', 'countries')
);

?>
