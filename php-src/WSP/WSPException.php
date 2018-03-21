<?php

namespace WSP;

/**
 * Class - Custom exception for plugin
 *
 * @author Joshua Grierson
 * @package WSP
*/

class WSPException extends Exception
{

  /**
  * Uses super class
  */
  public function __construct ($message, $code = 0, Exception $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }

  /**
  * Parent function
  */
  public function __toString ()
  {
    return __CLASS__.': [{$this->code}]: {$this->message}\n';
  }
}

?>
