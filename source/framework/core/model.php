<?php
namespace framework\core;
use framework\core\exception\ModelException;
use framework\validator\Validator;
use framework\helpers\Html;
/**
 * Model Class
 * default method is for validator
 *
 * 1: create new object of your model and new class extends of model
 * 2: create new method with rules() name and return your rules
 * 3: $model->validate(); if rules is valid return true
 * and else $model->getMessages(); get error messages  
 *
 * @author		saeed johary <foreach@live.com>
 * @since		1.0
 * @package		core
 * @copyright	(c) 2014 all rights reserved
 */
abstract class Model
{
	/**
	 * save error messages
	 *
	 * @access protected
	 * @var array
	 */
	protected $messages = [];
	
	/**
	 * abstract rules method
	 *
	 * @access public abstract
	 * @return array
	 */
	public abstract function rules();
	
	/**
	 * validate rules
	 *
	 * @access public
	 * @return boolean
	 */
	public function validate()
	{
		$validate = new Validator();
		$rules = $this->rules();
		if(empty($rules))
			throw new ModelException('Model::rules() not valid');
		$validate->addRules($rules);
		if($validate->validate()) return true;
		else {
			$this->messages = $validate->getMessages();
			return false;
		}
	}
	
	/**
	 * get error messages
	 *
	 * @access public
	 * @return array
	 */
	public function getMessages()
	{
		return $this->messages;
	}
	
	/**
	 * get error message
	 *
	 * @param string $key, messages key
	 * @access public
	 * @return array
	 */
	public function getMessage($key,$class = 'errorMessage')
	{
		if(isset($this->messages[$key]))
			return Html::tag('p',['class' => $class]).$this->messages[$key].Html::closeTag('p');
	}
}