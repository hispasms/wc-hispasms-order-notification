<?php

namespace hispaSMS\models\iam;

use hispaSMS\Models;
use hispaSMS\models\AbstractObject;
use hispaSMS\SubObjectConversionRule;

class IamRequestError extends AbstractObject {

    public $serviceException;
    public $clientCorrelator;
    public $variables;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register('hispaSMS\models\iam\IamRequestError', array (
  new SubObjectConversionRule('hispaSMS\models\iam\IamServiceException', 'serviceException')
));

?>
