<?php

namespace hispaSMS\models;

use hispaSMS\Models;

class DeliveryInfo extends AbstractObject {

    public $deliveryStatus;
    public $address;
    public $messageId;
    public $clientCorrelator;

    public function __construct() {
        parent::__construct();
    }

}

Models::register('hispaSMS\models\DeliveryInfo');
