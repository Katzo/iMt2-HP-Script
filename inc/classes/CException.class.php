<?php
class CException extends Exception{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return "An error occurred in file ".$this->getFile()." on line ".$this->getLine().".\n\n".$this->getMessage()."\n\n<b>Trace:</b>\n".$this->getTraceAsString();
    }
}
?>