<?php

namespace hispaSMS\models;

use hispaSMS\Models;
use hispaSMS\SubFieldConversionRule;
use hispaSMS\SubObjectConversionRule;

class DeliveryInfoNotification extends AbstractObject {

    public $deliveryInfo;
    public $callbackData;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register(
        'hispaSMS\models\DeliveryInfoNotification',
        array(
            new SubObjectConversionRule('hispaSMS\models\DeliveryInfo', 'deliveryInfo', 'deliveryInfoNotification.deliveryInfo'),
            new SubFieldConversionRule('callbackData', 'deliveryInfoNotification.callbackData')
        )
);

?>
