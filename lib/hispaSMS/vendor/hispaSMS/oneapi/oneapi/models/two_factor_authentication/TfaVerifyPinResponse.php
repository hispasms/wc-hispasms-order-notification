<?php

namespace hispaSMS\models\two_factor_authentication;

use hispaSMS\Models;
use hispaSMS\models\AbstractObject;

class TfaVerifyPinResponse extends AbstractObject {

    public $applicationId;
    public $phoneNumber;
    public $verified;
    public $attemptsRemaining;
    public $pinError;
    
    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register('hispaSMS\models\two_factor_authentication\TfaVerifyPinResponse');

?>
