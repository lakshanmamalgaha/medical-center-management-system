<?php 
class Validation{
	private $_passed = false,
			$_errors = array(),
			$_db	 = null;

	public function __construct()
	{
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array())
	{
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				
				$value = trim($source[$item]);
				
				$item = escape($item);

				if($rule === 'required' && empty($value))
				{
					$this->addError("{$item} is required");
				}
				else if(!empty($value))
				{
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value)
							{
								$this->addError("{$item} must be minimum of {$rule_value} character.");
							}
							break;

						case 'max':
							if(strlen($value) > $rule_value)
							{
								$this->addError("{$item} must be maximum of {$rule_value} character.");
							}
							break;

						case 'matches':
							if($value != $source[$rule_value])
							{
								$this->addError("{$rule_value} must match {$item}.");
							} 
							break;

						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count())
							{
								$this->addError("{$item} already exists.");
							}
							break;
						case 'characters':
							$string_exp="/^[A-Za-z ]+$/";
					      	if(!preg_match($string_exp,$item)){
					        	$this->addError("{$item} should contain only characters!");
					      }
					      break;
					      case 'integer':
							$string_exp="/^[0-9]+$/";
					      	if(!preg_match($string_exp,$item)){
					        	$this->addError("{$item} should contain only numbers!");
					      }
					      break;
					      case 'strong':

						      if (!preg_match("#[0-9]+#", $item)) {
	        						$this->addError("Password must include at least one number!");
	   						 	}

						    if (!preg_match("#[a-zA-Z]+#", $item)) {
						        $this->addError("Password must include at least one letter!");
						    } 
						    break;    

					}
				}
			}
		}

		if(empty($this->_errors))
		{
			$this->_passed = true;
		}

		return $this; 
	}

	private function addError($error)
	{
		$this->_errors[] = $error;
	}

	public function errors()
	{
		return $this->_errors;
	}

	public function passed()
	{
		return $this->_passed;
	}
}