<?php

namespace hispaSMS\models;

use hispaSMS\Models;

class SmsMessageSubscription extends AbstractObject {

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register('hispaSMS\models\SmsMessageSubscription');


?>
