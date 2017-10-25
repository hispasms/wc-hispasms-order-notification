<?php

namespace hispaSMS\models;
use hispaSMS\Models;
use hispaSMS\SubObjectConversionRule;

/**
 * Social Invite response object.
 */
class SocialInviteResponse extends AbstractObject {

  public $sendSmsResponse;

  public function __construct($array=null, $success=true) {
      parent::__construct($array, $success);
  }
}

Models::register('hispaSMS\models\SocialInviteResponse', array (
  new SubObjectConversionRule('hispaSMS\models\SISendSmsResponse', 'sendSmsResponse')
));

?>
