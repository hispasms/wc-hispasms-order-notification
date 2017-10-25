<?php

namespace hispaSMS\models;

use hispaSMS\Models;
use hispaSMS\SubFieldConversionRule;
use hispaSMS\SubObjectConversionRule;

class TerminalRoamingStatusNotification extends AbstractObject {

    public $terminalRoamingStatus;
    public $callbackData;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register(
        'hispaSMS\models\TerminalRoamingStatusNotification',
        array(
            new SubObjectConversionRule('hispaSMS\models\TerminalRoamingStatus', 'terminalRoamingStatus', 'terminalRoamingStatusList.roaming'),
            new SubFieldConversionRule('callbackData', 'terminalRoamingStatusList.roaming.callbackData')
        )
);

?>
