<?php

namespace hispaSMS\models;

use hispaSMS\Models;
use hispaSMS\ObjectArrayConversionRule;

class Timezones extends AbstractObject {

    public $timezones;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register(
        'hispaSMS\models\Timezones',
        new ObjectArrayConversionRule('hispaSMS\models\Timezone', 'timeZones')
);


?>
