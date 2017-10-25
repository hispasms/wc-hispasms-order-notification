<?php

namespace hispaSMS\models\two_factor_authentication;

use hispaSMS\Models;
use hispaSMS\models\AbstractObject;

class TfaIsVerifiedResponse extends AbstractObject {

    public $verified;
    public $verifiedAt;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register('hispaSMS\models\two_factor_authentication\TfaIsVerifiedResponse');

?>
