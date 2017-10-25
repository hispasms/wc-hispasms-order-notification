<?php

namespace hispaSMS\models;
use hispaSMS\Models;
use hispaSMS\ObjectArrayConversionRule;

/**
 * The delivery status of an message.
 */
class DeliveryInfoList extends AbstractObject {

    public $deliveryInfo;

    public function __construct() {
        parent::__construct();
    }

}

Models::register(
    'hispaSMS\models\DeliveryInfoList',
    new ObjectArrayConversionRule('hispaSMS\models\DeliveryInfo', 'deliveryInfo', 'deliveryInfoList.deliveryInfo')
);

