<?php

namespace hispaSMS\models;

use hispaSMS\Models;
use hispaSMS\SubObjectConversionRule;

class AccountBalance extends AbstractObject {

	public $balance;

	public $currency;

    public function __construct() {
        parent::__construct();
    }

}

Models::register(
        'hispaSMS\models\AccountBalance',
        new SubObjectConversionRule('hispaSMS\models\Currency', 'currency')
);
