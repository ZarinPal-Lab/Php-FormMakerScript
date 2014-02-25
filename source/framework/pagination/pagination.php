<?php
namespace framework\pagination;
use framework\pagination\exception\PaginationException;
use framework\helpers\Html;
use framework\request\Request;
/**
 * Pagination Class
 *
 * @use Pagination::initialize(); initialize properties
 * @use Pagination::text(); set text of first,last,prev,next
 * @use Pagination::fullRows; set full rows of database table
 * @use Pagination::itemLimit; set items per page
 * @use Pagination::pageLimit; set page limit
 * @use Pagination::pageVar; set page var $_GET[pagevar]
 * @use Pagination::htmlOptions; set html options for <ul>
 * @use Pagination::getInfo(); get page %s of %s page
 * @use Pagination::createPages(); create and show pages
 * 
 * @author		saeed johary <foreach@live.com>
 * @since		1.0
 * @package		pagination
 * @copyright	(c) 2014 all rights reserved
 */
class Pagination
{
	/**
	 * pagination text
	 *
	 * @access public
	 * @var array
	 */
	public $text = ['first','last','prev','next'];
	
	/**
	 * full rows of table
	 *
	 * @access public
	 * @var integer
	 */
	public $fullRows;
	
	/**
	 * items per page
	 *
	 * @access public
	 * @var integer
	 */
	public $itemLimit = 10;
	
	/**
	 * page button limit
	 *
	 * @access public
	 * @var integer
	 */
	public $pageLimit = 10;
	
	/**
	 * page var $_GET[var]
	 *
	 * @access public
	 * @var string
	 */
	public $pageVar = '?page=';
	
	/**
	 * html options for ul
	 *
	 * @access public
	 * @var array
	 */
	public $htmlOptions = [];
	
	/**
	 * current page
	 *
	 * @access protected
	 * @var integer
	 */
	protected $currentPage = 1;
	
	/**
	 * created pages (ceil)
	 *
	 * @access protected
	 * @var integer
	 */
	protected $createdPages;
	
	/**
	 * initialize properties
	 *
	 * @param array $config, properties array
	 * @access public
	 * @return void
	 */
	public function initialize($config = [])
	{
		if(isset($config['fullRows']))
			$this->fullRows = $config['fullRows'];
		if(isset($config['itemLimit']))
			$this->itemLimit = $config['itemLimit'];
		if(isset($config['pageLimit']))
			$this->pageLimit = $config['pageLimit'];
		if(isset($config['pageVar']))
			$this->pageVar = $config['pageVar'];
		if(isset($_GET[$this->getPageVar()]) and is_numeric($_GET[$this->getPageVar()]))
			$this->currentPage = (int)$_GET[$this->getPageVar()];
		$this->createdPages = ceil($this->fullRows/$this->itemLimit);
		if($this->currentPage > $this->createdPages or $this->currentPage <= 0)
			$this->currentPage = 1;
	}

	/**
	 * apply limit to your query
	 *
	 * @access public
	 * @return integer
	 */
	public function applyLimit()
	{
		return (($this->currentPage-1)*$this->itemLimit);
	}
	
	/**
	 * apply offset to your query
	 * 
	 * @access public
	 * @return integer
	 */
	public function applyOffset()
	{
		return $this->itemLimit;
	}
	
	/**
	 * get page %s of %s pages
	 *
	 * @param string $text, format
	 * @access public
	 * @return string
	 */
	public function getInfo($text = 'page %s of %s  ')
	{
		if($this->createdPages <= 1) return;
		return sprintf($text,$this->currentPage,$this->createdPages);
	}
	
	/**
	 * get page var convert ?page= to page
	 *
	 * @access public
	 * @return string
	 */
	public function getPageVar()
	{
		return substr($this->pageVar,1,-1);
	}
	
	/**
	 * check is current page
	 *
	 * @param integer $page
	 * @access public
	 * @return boolean
	 */
	public function isCurrentPage($page)
	{
		if($page === (int)$this->currentPage)
			return true;
		return false;
	}
	
	/**
	 * create pages <ul><li>......
	 *
	 * @access public
	 * @return string
	 */
	public function createPages()
	{
		if($this->createdPages <= 1) return;
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] = 'pagination';
		$output = Html::tag('ul',$this->htmlOptions);
		if($this->currentPage > 1)
		{
			$output .= Html::tag('li').$this->createAnchor($this->text[0]).Html::closeTag('li');
			$output .= Html::tag('li').$this->createAnchor($this->text[2],$this->currentPage-1).Html::closeTag('li');
		}
		$output .= $this->createButtons();
		if($this->currentPage < $this->createdPages)
		{
			$output .= Html::tag('li').$this->createAnchor($this->text[3],$this->currentPage+1).Html::closeTag('li');
			$output .= Html::tag('li').$this->createAnchor($this->text[1],$this->createdPages).Html::closeTag('li');
		}
		$output .= Html::closeTag('ul');
		return $output;
	}
	
	/**
	 * create page buttons
	 *
	 * @access protected
	 * @return string
	 */
	protected function createButtons()
	{
		$output = null; $start = 1;
		$limit = $this->pageLimit;
		$_start = intval($this->currentPage-($this->pageLimit/2));
		if($_start > 0)
		{
			$start = $_start;
			$limit = $limit+$start;
		}
		for($i=$start;$i<=$this->createdPages && $i<=$limit;$i++)
		{
			$htmlOptions = [];
			if($this->isCurrentPage($i))
				$htmlOptions['class'] = 'page-active';
			$output .= Html::tag('li',$htmlOptions).$this->createAnchor($i,$i).Html::closeTag('li');
		}
		return $output;
	}
	
	/**
	 * create anchor for page buttons
	 *
	 * @param string $text, anchor text
	 * @param boolean $pageNum, page number
	 * @access protected
	 * @return string
	 */
	protected function createAnchor($text,$pageNum = false)
	{
		$url = Html::escape(Request::getServer('PHP_SELF'));
		if($pageNum)
			$url .= $this->pageVar.$pageNum;
		return Html::anchor($url,$text);
	}
}