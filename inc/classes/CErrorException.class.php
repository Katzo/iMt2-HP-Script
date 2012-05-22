<?php
class CErrorException extends ErrorException{
    public function __construct($message, $code = 0, $severity = 1, $filename = __FILE__, $lineno = __LINE__, Exception $previous = null) {
        parent::__construct($message, $code, $severity, $filename, $lineno, $previous);
    }

    public function __toString() {
        return "A php error (".$this->getSeverity().") occurred in file ".$this->getFile()." on line ".$this->getLine().".\n\n".$this->getMessage()."\n\n<b>Trace:</b>\n".$this->getTraceAsString();
    }
}
?>