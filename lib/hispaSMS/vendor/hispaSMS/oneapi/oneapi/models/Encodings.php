<?php

namespace hispaSMS\models;
use hispaSMS\Models;
use hispaSMS\ObjectArrayConversionRule;

/**
 * Description of Encodings
 *
 * @author rbelusic
 */
class Encodings extends AbstractObject {

    public $encodings;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register(
        'hispaSMS\models\Encodings',
        new ObjectArrayConversionRule('hispaSMS\models\Encoding', 'encodings')
);
        


?>
