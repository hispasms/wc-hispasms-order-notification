<?php

namespace hispaSMS\models;

use hispaSMS\Models;

class Currency extends AbstractObject {

	public $id;
	public $currencyName;
	public $symbol;

    public function __construct() {
        parent::__construct();
    }

}

Models::register('hispaSMS\models\Currency');
