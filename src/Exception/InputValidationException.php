<?php
namespace Thant\DataTable\Exception;
use Exception;
/**
 * Created by PhpStorm.
 * User: kthant
 * Date: 6/20/2017
 * Time: 4:16 PM
 */
class InputValidationException extends Exception
{
	protected $errors = array();

	public function __construct(array $errors, $message = "", $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->errors = $errors;
	}

	public function getErrors()
	{
		return $this->errors;
	}
}