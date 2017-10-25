<?php

namespace hispaSMS\models\two_factor_authentication;

use hispaSMS\Models;
use hispaSMS\models\AbstractObject;

class TfaResponse extends AbstractObject {

    public $smsId;
    public $phoneNumber;

    public $hlrStatus;
    public $smsStatus;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register('hispaSMS\models\two_factor_authentication\TfaResponse');

?>
