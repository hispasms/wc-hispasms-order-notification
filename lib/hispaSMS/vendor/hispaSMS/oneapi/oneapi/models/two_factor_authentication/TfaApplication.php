<?php

namespace hispaSMS\models\two_factor_authentication;

use hispaSMS\Models;
use hispaSMS\models\AbstractObject;
use hispaSMS\SubObjectConversionRule;

class TfaApplication extends AbstractObject {

    public $applicationId;
    public $name;
    public $enabled;
    public $processId;
    public $configuration;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register('hispaSMS\models\two_factor_authentication\TfaApplication', array (
  new SubObjectConversionRule('hispaSMS\models\two_factor_authentication\TfaApplicationConfiguration', 'configuration')
));

?>
