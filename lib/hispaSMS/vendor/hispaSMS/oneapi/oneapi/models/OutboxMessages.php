<?php

namespace hispaSMS\models;

use hispaSMS\Models;
use hispaSMS\ObjectArrayConversionRule;

class OutboxMessages extends AbstractObject
{

    public $logs;
    public $from;
    public $to;
    public $hasMoreLogs;

    public function __construct($array = null, $success = true)
    {
        parent::__construct($array, $success);
    }

    public function isMoreAvailable()
    {
        return $this->hasMoreLogs;
    }

}

Models::register(
    'hispaSMS\models\OutboxMessages',
    new ObjectArrayConversionRule('hispaSMS\models\OutboxMessage', 'logs')
);

?>
