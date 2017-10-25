<?php

namespace hispaSMS\models;

use hispaSMS\Models;
use hispaSMS\ObjectArrayConversionRule;

class MoSubscriptions extends AbstractObject {

    public $subscriptions;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register(
        'hispaSMS\models\MoSubscriptions',
        new ObjectArrayConversionRule('hispaSMS\models\MoSubscription', 'subscriptions')
);

?>
