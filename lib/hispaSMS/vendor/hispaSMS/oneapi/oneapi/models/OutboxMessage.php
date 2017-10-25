<?php

namespace hispaSMS\models;

use hispaSMS\Models;
use hispaSMS\SubObjectConversionRule;

class OutboxMessage extends AbstractObject {

    public $sendDateTime;
    public $messageId;
    public $smsCount;
    public $destinationAddress;
    public $sender;
    public $clientMetadata;
    public $messageText;
    public $status;
    public $bulkId;
    public $deliveryReportTime;
    public $ported;
    public $pricePerMessage;
    public $destinationNetwork;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}
Models::register(
    'hispaSMS\models\OutboxMessage',
    array(
        new SubObjectConversionRule('hispaSMS\models\Status', 'status'), 
        new SubObjectConversionRule('hispaSMS\models\Network', 'destinationNetwork'),
        new SubObjectConversionRule('hispaSMS\models\Price', 'pricePerMessage')
    )
);

?>
