<?php

namespace hispaSMS\models;

use hispaSMS\Models;
use hispaSMS\SubObjectConversionRule;

class TerminalRoamingStatus extends AbstractObject {

    public $servingMccMnc;
    public $address;
    public $currentRoaming;
    public $resourceURL;
    public $retrievalStatus;
    public $callbackData;
    public $extendedData;

    public function __construct() {
        parent::__construct();
    }

}

Models::register(
        'hispaSMS\models\TerminalRoamingStatus',
        array(
                new SubObjectConversionRule('hispaSMS\models\ServingMccMnc', 'servingMccMnc'),
                new SubObjectConversionRule('hispaSMS\models\TerminalRoamingExtendedData', 'extendedData'),
        )
);

