<?php
/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Document
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */

/**
 * @see Hush_Document_Parser
 */
require_once __LIB . DIRECTORY_SEPARATOR . './Document/Parser.php';

/**
 * @package Hush_Document
 */
class Hush_Document
{
	/**
	 * @var Hush_Document_Parser 
	 */
	protected $_parser = null;
	
	/**
	 * Construct
	 * @param Hush_Debug_Writer $writer
	 */
	public function __construct($classFile, $parser = 'PhpDoc')
	{
		if (!file_exists($classFile)) {
			echo $classFile . '不存在';
			exit;
		}
		
		$this->_parser = Hush_Document_Parser::factory($parser);
		
		$this->_parser->parseCode($classFile);
	}
    
	/**
	 * Get annotations
	 * @param $classFile ClassName you want
	 * @param $methodName MethodName you want
	 * @return array
	 */
	public function getAnnotation($className = '', $methodName = '')
	{
		return $this->_parser->getAnnotation($className, $methodName);
	}
}