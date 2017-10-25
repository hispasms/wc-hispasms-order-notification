<?php

namespace hispaSMS\models\two_factor_authentication;

use hispaSMS\Models;
use hispaSMS\models\AbstractObject;

class TfaRequest extends AbstractObject {

    public $applicationId;
    public $messageId;

    public $senderId;
    public $phoneNumber;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register('hispaSMS\models\two_factor_authentication\TfaRequest');

?>
