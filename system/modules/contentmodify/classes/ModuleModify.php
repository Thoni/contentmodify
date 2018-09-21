<?php

 /**
  * Namespace
  */


if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Frank Thonak www.thomkit.de
 * @author     Frank Thonak
 * @package    contentmodify
 * @license    GPL
 * @filesource
 */



/**
 * Class ModuleModify
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Frank Thonak www.thomkit.de
 * @author     Frank Thonak
 * @package    contentmodify
 */


class ModuleModify extends System
{

	public $escArray = array(
			'rk' => array(
					'0' => array('&#40;','&#41;'),
					'1' => array('\(','\)')
			),
			'ek' => array(
					'0' => array('[',']'),
					'1' => array('\[','\]')
			),
			'sk' => array(
					'0' => array('<','>'),
					'1' => array('\<','\>')
			),
			'-' => array(
					'0' => '-',
					'1' => '\-'
			),
			'+' => array(
					'0' => '+',
					'1' => '\+'
			),
			'.' => array(
					'0' => '.',
					'1' => '\.'
			),
			'*' => array(
					'0' => '*',
					'1' => '\*'
			),
			'?' => array(
					'0' => '?',
					'1' => '\?'
			)
	);


	public function doModify($objElement,$strBuffer)
	{
		global $objPage;

		$retValue = $strBuffer;
		$this->import('Database');

// STRONG
		$sql = $this->Database->prepare("SELECT * FROM tl_contentmodify WHERE published=? AND type=?")
								->execute('1','s');
		while($sql->next())
		{
			if(strpos($GLOBALS['TL_CONFIG']['cm_elements'],'"'.$objElement->type.'"'))
			{
				$search = $this->escapeLetter($sql);
				$in = $retValue;
				$new1 = "<strong>";
				$new2 = "</strong>";
				$retValue = $this->doNow($objElement,$search,$in,$new1,$new2);
			}
		}

// HIGHLIGHT
		$sql = $this->Database->prepare("SELECT * FROM tl_contentmodify WHERE published=? AND type=?")
								->execute('1','h');
		while($sql->next())
		{
			if(strpos($GLOBALS['TL_CONFIG']['cm_elements'],'"'.$objElement->type.'"'))
			{
				$search = $this->escapeLetter($sql);
				$in = $retValue;
				$new1 = "<span class=\"$sql->class\">";
				$new2 = "</span>";
				$retValue = $this->doNow($objElement,$search,$in,$new1,$new2);
			}
		}

// ACRONYM
		$sql = $this->Database->prepare("SELECT * FROM tl_contentmodify WHERE published=? AND type=?")
								->execute('1','a');
		while($sql->next())
		{
			if(strpos($GLOBALS['TL_CONFIG']['cm_elements'],'"'.$objElement->type.'"'))
			{
				$search = $this->escapeLetter($sql);
				$in = $retValue;
				$new1 = "<acronym title=\"$sql->class\">";
				$new2 = "</acronym>";
				$retValue = $this->doNow($objElement,$search,$in,$new1,$new2);
			}
		}

// ABBREVIATION
		$sql = $this->Database->prepare("SELECT * FROM tl_contentmodify WHERE published=? AND type=?")
								->execute('1','b');
		while($sql->next())
		{
			if(strpos($GLOBALS['TL_CONFIG']['cm_elements'],'"'.$objElement->type.'"'))
			{
				$search = $this->escapeLetter($sql);
				$in = $retValue;
				$new1 = "<abbr title=\"$sql->class\">";
				$new2 = "</abbr>";
				$retValue = $this->doNow($objElement,$search,$in,$new1,$new2);
			}
		}

// LANGUAGE
		$sql = $this->Database->prepare("SELECT * FROM tl_contentmodify WHERE published=? AND type=?")
								->execute('1','l');
		while($sql->next())
		{
			if(strpos($GLOBALS['TL_CONFIG']['cm_elements'],'"'.$objElement->type.'"') && $objPage->language != $sql->class)
			{
				$search = $this->escapeLetter($sql);
				$in = $retValue;
				$new1 = "<span lang=\"$sql->class\" xml:lang=\"$sql->class\">";
				$new2 = "</span>";
				$retValue = $this->doNow($objElement,$search,$in,$new1,$new2);
			}
		}

		return $retValue;
	}

	public function doNow($objElement,$search,$in,$new1,$new2)
	{
		$retValue = $in;
		$retValue = str_replace("'","###thomkit###",$retValue); // bugfix  "'" escapeproblem
		$retValue = preg_replace("/((<[^>]*)|$search)/ie", '"\2"=="\1"? "\1":$new1."\1".$new2',$retValue);
		$search2 = htmlentities($search);
		if ($search2 != $search) $retValue = preg_replace("/((<[^>]*)|$search2)/ie", '"\2"=="\1"? "\1":$new1."\1".$new2',$retValue);
		$retValue = str_replace("###thomkit###","'",$retValue); // bugfix  "'" escapeproblem
		return $retValue;
	}

	public function escapeLetter ($sql)
	{

		$retValue = $sql->text;
		$tmpArray = deserialize($GLOBALS['TL_CONFIG']['no_regex']);
		$wildCard = $GLOBALS['TL_CONFIG']['wildcard'];
		if($GLOBALS['TL_CONFIG']['no_regex_2'])
		{
			$tmpArray = deserialize($sql->no_regex);
			$wildCard = $sql->wildcard;
		}
		if(is_array($tmpArray))
		{
			foreach($tmpArray as $tmp)
			{
				$retValue = str_replace($this->escArray[$tmp][0],$this->escArray[$tmp][1],$retValue);
			}
		}
		if($wildCard != '') $retValue = str_replace($wildCard,'.?',$retValue);
		return $retValue;
	}
}
?>