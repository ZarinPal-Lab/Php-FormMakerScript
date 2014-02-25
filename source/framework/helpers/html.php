<?php
namespace framework\helpers;
use framework\helpers\exception\HtmlException;
use framework\log\Log;
use framework\request\Request;
/**
 * Html Class
 * helper class for easy create html elements
 *
 * @use Html::anchor(); for a create anchor
 * @use Html::escape(); escape data with htmlspecialchars , xss
 * @use Html::title(); for a create page title
 * @use Html::label(); create label for inputs
 * @use Html::inputField(); create input
 * @use Html::textField(); create input with text field
 * @use Html::numberField() create input with number field
 * @use Html::passwordField(); create input with password field
 * @use Html::textArea(); create textarea field
 * @use Html::checkBox(); create checkbox
 * @use Html::dropDownList(); create drop down list (select,option)
 * @use Html::submitButton(); create submit button for form
 *
 * @author		saeed johary <foreach@live.com
 * @since		1.0
 * @package		helper
 * @copyright	(c) 2014 all rights reserved
 */
class Html
{
	/**
	 * open html tag
	 *
	 * @param string $tag, tag name
	 * @param array $htmlOptions, html options
	 * @access public static
	 * @return string
	 */
	public static function tag($tag,$htmlOptions = [])
	{
		if(!is_array($htmlOptions))
			throw new HtmlException('Html::tag argument 2 must be an array');
		$htmlOptions = self::htmlOptions($htmlOptions);
		return "<{$tag}{$htmlOptions}>".PHP_EOL;
	}

	/**
	 * close html tag
	 *
	 * @param string $tag , tag name
	 * @access public static
	 * @return string
	 */
	public static function closeTag($tag)
	{
		return "</{$tag}>".PHP_EOL;
	}
	
	/**
	 * parse html options for tags
	 *
	 * @param array $options, html options
	 * @access public static
	 * @return string
	 */
	public static function htmlOptions($options)
	{
		if(!is_array($options))
			throw new HtmlException('Html::htmlOptions argument must be an array');
		$output = '';
		foreach($options as $tag => $tagValue)
			$output .= " {$tag}='{$tagValue}'";
		return $output;
	}
	
	/**
	 * create anchor 
	 *
	 * @param string $url , anchor url
	 * @param string $text, anchor text
	 * @param array $htmlOptions , html options
	 * @access public static
	 * @return string
	 */
	public static function anchor($url,$text,$htmlOptions = [])
	{
		if(!is_array($htmlOptions))
			throw new HtmlException('Html::anchor argument 3 must be an array');
		$htmlOptions['href'] = $url;
		$htmlOptions = array_reverse($htmlOptions);
		return self::tag('a',$htmlOptions).$text.self::closeTag('a');
	}
	
	/**
	 * escape html for security
	 *
	 * @param string $data , data
	 * @param string $flag, escape flag
	 * @param string $encoding , escape encoding
	 * @param boolean $double_encode , double encode
	 * @access public static
	 * @return string
	 */
	public static function escape($data,$flag = ENT_QUOTES,$encoding = 'UTF-8',$double_encode = true)
	{
		return htmlspecialchars($data,$flag,$encoding,$double_encode);
	}
	
	/**
	 * create html title tag
	 *
	 * @param string $title, title
	 * @access public static
	 * @return string
	 */
	public static function title($title)
	{
		return self::tag('title').$title.self::closeTag('title');
	}
	
	/**
	 * create label for inputs
	 *
	 * @param string $text , label text
	 * @param string $for, input name
	 * @param array $htmlOptions , html options
	 * @access public static
	 * @return string
	 */
	public static function label($text,$for = '',$htmlOptions = [])
	{
		$htmlOptions['for'] = $for;
		$htmlOptions = array_reverse($htmlOptions);
		return self::tag('label',$htmlOptions).$text.self::closeTag('label');
	}

	/**
	 * create input field
	 *
	 * @param string $name, input name
	 * @param string $type, input type
	 * @param array $htmlOptions, html options
	 * @access public static
	 * @return string
	 */
	public static function inputField($name,$type = 'text',$htmlOptions = [],$setValue = true)
	{
		if($setValue and Request::isPost($name))
			$htmlOptions['value'] = Request::getPost($name);
		$htmlOptions['name'] = $name;
		$htmlOptions['type'] = $type;
		$htmlOptions = array_reverse($htmlOptions);
		return self::tag('input',$htmlOptions);
	}

	/**
	 * create text field 
	 *
	 * @param string $name, input name
	 * @param array $htmlOptions, html options
	 */
	public static function textField($name,$htmlOptions = [],$setValue = true)
	{
		return self::inputField($name,'text',$htmlOptions,$setValue);
	}
	
	/**
	 * create number field
	 *
	 * @param string $name, input name
	 * @param array $htmlOptions , html options
	 * @access public static
	 * @return string
	 */
	public static function numberField($name,$htmlOptions = [],$setValue = true)
	{
		return self::inputField($name,'number',$htmlOptions,$setValue);
	}
	
	/**
	 * create password field
	 *
	 * @param string $name , input name
	 * @param array $htmlOptions, html options
	 * @access public static
	 * @return string
	 */
	public static function passwordField($name,$htmlOptions = [],$setValue = true)
	{
		return self::inputField($name,'password',$htmlOptions,$setValue);
	}
	
	/**
	 * create hidden field
	 *
	 * @param array $htmlOptions, html options
	 * @access public static
	 * @return string
	 */
	public static function hiddenField($name,$htmlOptions = [],$setValue = true)
	{
		return self::inputField($name,'hidden',$htmlOptions,$setValue);
	}

	/**
	 * create textarea field
	 *
	 * @param string $name, textarea name
	 * @param string $text, default text
	 * @param array $htmlOptions, html options
	 */
	public static function textArea($name,$text = '',$htmlOptions = [],$setValue = true)
	{
	      if($setValue and Request::isPost($name))
                  $text = Request::getPost($name);
		$htmlOptions['name'] = $name;
		$htmlOptions = array_reverse($htmlOptions);
		return self::tag('textarea',$htmlOptions).$text.self::closeTag('textarea');
	}
	
	/**
	 * create checkbox
	 *
	 * @param string $name, input name
	 * @param array $htmlOptions, html options
	 * @access public static
	 * @return string
	 */
	public static function checkBox($name,$htmlOptions = [],$setValue = true)
	{
		return self::inputField($name,'checkbox',$htmlOptions,$setValue);
	}

	/**
	 * create drop down list
	 *
	 * @param string $name, select name
	 * @param array $options, select options
	 * @param array $htmlOptions, html options
        * @param mixed $selected, selected option
	 * @access public static
	 * @return string
	 */
	public static function dropDownList($name,$options = [],$htmlOptions = [],$selected = 'none',$setValue = true)
	{
		$htmlOptions['name'] = $name;
		$htmlOptions = array_reverse($htmlOptions);
		$output = self::tag('select',$htmlOptions);
		unset($htmlOptions);
		foreach($options as $optionValue => $optionText)
		{
		      $htmlOptions = [];
			$htmlOptions['value'] = $optionValue;
                  if(($setValue and (Request::isPost($name) and Request::getPost($name) == (string)$optionValue))
                  or (!Request::isPost($name) and $selected === $optionValue))
                        $htmlOptions['selected'] = 'selected';
			$output .= self::tag('option',$htmlOptions).$optionText.self::closeTag('option').PHP_EOL;
		}
		$output .= self::closeTag('select');
		return $output;
	}

	/**
	 * create submit button
	 *
	 * @param string $text, button text
	 * @param string $name, button name
	 * @param array $htmlOptions, html options
	 * @access public static
	 * @return string
	 */
	public static function submitButton($text,$name = 'submit',$htmlOptions = [])
	{
		$htmlOptions['name'] = $name;
		$htmlOptions = array_reverse($htmlOptions);
		return self::tag('button',$htmlOptions).$text.self::closeTag('button');
	}

      /**
       * convert object to drop down list items
       *
       * @param object $object
       * @param string $objectName, field name
       * @param string $objectValue, field value
       * @access public static
       * @return array
       */
      public static function convertObjectToDropDownList($object,$objectName,$objectValue)
      {
            $output = [];
            foreach($object as $obj)
            {
                  $output[$obj->{$objectName}] = $obj->{$objectValue};
            }
            return $output;
      }
}