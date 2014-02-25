<?php
namespace framework\validator;
use framework\validator\exception\ValidatorException;
use framework\captcha\Captcha;
/**
 * Validator Class
 * easy email validator and required validator
 *
 * @use Validator::addRules(); add rules
 * @use Validator::validate(); validate rules
 * @use Validator::emailValidator(); use email validator
 * @use Validator::requiredValidator(); use required validator
 * @use Validator::getMessages(); get rules messages if not valid item
 *
 * @author		saeed johary <foreach@live.com>
 * @since		1.0
 * @package		validator
 * @copyright	(c) 2014 all rights reserved
 */
class Validator
{	

	/**
	 * validator rules
	 *
	 * @access protected
	 * @var array
	 */
	protected $rules = [];

	/**
	 * error messages
	 *
	 * @access protected
	 * @var array
	 */
	protected $messages = [];

	/**
	 * class constructor
	 *
	 * @param array $rules, rules
	 * @access public
	 * @return void
	 */
	public function __construct($rules = [])
	{
		$this->rules = $rules;
	}

	/**
	 * add rules for validate
	 *
	 * @param array $rules, rules
	 * @access public
	 * @return object
	 */
	public function addRules($rules)
	{
		if(!is_array($rules) or count($rules) == 0)
			throw new ValidatorException('Validator::addRules Method first argument must be an array');
		$this->rules = array_merge($this->rules,$rules);
	}

	/**
	 * validate rules and set messages
	 *
	 * @access public
	 * @return array
	 */
	public function validate()
	{
		foreach($this->rules as $rule => $ruleContent)
		{
			$validator = lcfirst($rule).'Validator';
			foreach($ruleContent as $item => $itemContent)
			{
				if(!method_exists($this,$validator))
					throw new ValidatorException("404 not found validator method {$validator}");
				if($this->{$validator}($itemContent) === false)
				{
					if(!isset($this->messages[$item]))
						$this->messages[$item] = $itemContent['itemMessage'];
				}
			}
		}
		return (empty($this->messages) ? true : false);
	}

	/**
	 * email validator
	 *
	 * @param array $itemContent
	 * @access public
	 * @return boolean
	 */
	public function emailValidator($itemContent)
	{
		if(filter_var($itemContent['itemValue'],FILTER_VALIDATE_EMAIL)
              or $this->requiredValidator($itemContent) === false)
			return true;
		return false;
	}

	/**
	 * required validator
	 *
	 * @param array $itemContent
	 * @access public
	 * @return boolean
	 */
	public function requiredValidator($itemContent)
	{
		$itemContent['itemValue'] = trim($itemContent['itemValue']);
		if($itemContent['itemValue'] === '')
			return false;
		return true;
	}

	/**
	 * url validator
	 *
	 * @param array $itemContent
	 * @access public
	 * @return boolean
	 */
	public function urlValidator($itemContent)
	{
		if(filter_var($itemContent['itemValue'],FILTER_VALIDATE_URL)
              or $this->requiredValidator($itemContent) === false)
			return true;
		return false;
	}

	/**
	 * numerical validator
	 *
	 * @param array $itemContent
	 * @access public
	 * @return boolean
	 */
	public function numericalValidator($itemContent)
	{
		if(is_numeric($itemContent['itemValue'])
              or $this->requiredValidator($itemContent) === false)
			return true;
		return false;
	}

	/**
	 * length validator
	 *
	 * @param array $itemContent
	 * @access public
	 * @return boolean
	 */
	public function lengthValidator($itemContent)
	{
	       if($this->requiredValidator($itemContent) === false)
                     return true;

		$length = strlen(trim($itemContent['itemValue']));
		
		if(isset($itemContent['min']))
		{
			if($length < $itemContent['min'])
				return false;
		}
		if(isset($itemContent['max']))
		{
			if($length > $itemContent['max'])
				return false;
		}
		return true;
	}

	/**
        * regex validator
        *
        * @param array $itemContent
	 * @access public
	 * @return boolean
	 */
	public function regexValidator($itemContent)
	{
		if(preg_match_all($itemContent['regex'],$itemContent['itemValue'])
              or $this->requiredValidator($itemContent) === false)
			  return true;
		return false;
	}

       /**
	 * captcha validator
	 *
	 * @param array $itemContent
	 * @access public
	 * @return boolean
	 */
       public function captchaValidator($itemContent)
       {
              $c = new Captcha();
              return $c->validate($itemContent['itemInput']);
       }

	/**
	 * get rules messages
	 *
	 * @access public
	 * @return array
	 */
	public function getMessages()
	{
		return $this->messages;
	}
}