<?php

namespace hispaSMS\models\iam;

use hispaSMS\Models;
use hispaSMS\models\AbstractObject;
use hispaSMS\SubObjectConversionRule;

class IamException extends AbstractObject {

    public $requestError;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register('hispaSMS\models\iam\IamException', array (
  new SubObjectConversionRule('hispaSMS\models\iam\IamRequestError', 'requestError')
));

?>
