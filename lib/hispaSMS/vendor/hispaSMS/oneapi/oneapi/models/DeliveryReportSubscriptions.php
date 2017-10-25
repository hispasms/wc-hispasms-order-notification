<?php

namespace hispaSMS\models;

use hispaSMS\Models;
use hispaSMS\ObjectArrayConversionRule;

class DeliveryReportSubscriptions extends AbstractObject {

    public $subscriptionId;

    public function __construct() {
        parent::__construct();
    }

}

Models::register(
        'hispaSMS\models\DeliveryReportSubscriptions',
        new ObjectArrayConversionRule('hispaSMS\models\DeliveryReportSubscription', 'deliveryReceiptSubscriptions')
);
