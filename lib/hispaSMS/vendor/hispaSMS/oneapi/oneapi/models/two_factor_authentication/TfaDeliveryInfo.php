<?php

namespace hispaSMS\models\two_factor_authentication;

use hispaSMS\Models;
use hispaSMS\models\AbstractObject;

class TfaDeliveryInfo extends AbstractObject {

    public $status;
    public $finalStatus;
    public $description;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register('hispaSMS\models\two_factor_authentication\TfaDeliveryInfo');

?>
