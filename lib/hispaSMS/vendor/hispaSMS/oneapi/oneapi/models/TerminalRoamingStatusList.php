<?php

namespace hispaSMS\models;

// TODO: Remove this object and use only TerminalRoamingStatus !
use hispaSMS\Models;
use hispaSMS\SubObjectConversionRule;

class TerminalRoamingStatusList extends AbstractObject {

    public $terminalRoamingStatus;

    public function __construct() {
        parent::__construct();
    }

}

Models::register(
        'hispaSMS\models\TerminalRoamingStatusList',
        new SubObjectConversionRule('hispaSMS\models\TerminalRoamingStatus', 'terminalRoamingStatus', 'terminalRoamingStatusList.roaming')
);

