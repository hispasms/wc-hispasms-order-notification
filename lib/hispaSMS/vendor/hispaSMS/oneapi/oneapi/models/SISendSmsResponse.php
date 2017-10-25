<?php

namespace hispaSMS\models;

// require_once('SISendMessageResult');
use hispaSMS\Models;
use hispaSMS\ObjectArrayConversionRule;

/**
 * Send sms response (Social Invite) object.
 */
class SISendSmsResponse extends AbstractObject {

  public $bulkId;
  public $deliveryInfoUrl;
  public $responses;

  public function __construct($array=null, $success=true) {
      parent::__construct($array, $success);
  }
}

Models::register('hispaSMS\models\SISendSmsResponse', array (
  new ObjectArrayConversionRule('hispaSMS\models\SISendMessageResult', 'responses')
));

?>
