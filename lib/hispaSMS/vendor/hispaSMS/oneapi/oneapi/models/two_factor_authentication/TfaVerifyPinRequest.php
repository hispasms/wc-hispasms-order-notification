<?php

namespace hispaSMS\models\two_factor_authentication;

use hispaSMS\Models;
use hispaSMS\models\AbstractObject;

class TfaVerifyPinRequest extends AbstractObject {

    public $applicationId;
    public $phoneNumber;
    public $pin;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register('hispaSMS\models\two_factor_authentication\TfaVerifyPinRequest');

?>
