<?php

namespace hispaSMS\models;
use hispaSMS\Models;
use hispaSMS\SubscriptionIdFieldConversionRule;

/**
 * Resulting object on message (HLR/LBS) send.
 */
class ResourceReference extends AbstractObject {

    /**
     * The client correlator for this message. This value may be used to query 
     * for message status later.
     */
    public $clientCorrelator;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register(
    'hispaSMS\models\ResourceReference',
    new SubscriptionIdFieldConversionRule('clientCorrelator', 'resourceReference.resourceURL')
);

?>
