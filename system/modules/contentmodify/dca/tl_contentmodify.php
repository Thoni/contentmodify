<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

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

$regex = deserialize($GLOBALS['TL_CONFIG']['no_regex']);

/**
 * Table tl_contentmodify
 */
if($regex == NULL) $regex = '';
if($GLOBALS['TL_CONFIG']['wildcard'] == NULL) $GLOBALS['TL_CONFIG']['wildcard'] = '';

$GLOBALS['TL_DCA']['tl_contentmodify'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'tables'                      => array('tl_contentmodify'),
		'onload_callback'             => array(),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		),
		'closed'                      => false,
		'switchToEdit'                => true,
		'enableVersioning'            => false
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('text'),
			'flag'                    => 1
		),
		'label' => array
		(
			'fields'                  => array('text','class','published'),
			'format'                  => '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_contentmodify']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_contentmodify']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_contentmodify']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this,%s);"',
				'button_callback'     => array('tl_contentmodify', 'toggleIcon')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('text'),
		'default'                     => '{label_start},text,class,published;{label_regex},wildcard,no_regex;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		''                            => ''
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'type' => array
		(
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'text' => array
		(
			'exclude'                 => true,
			'inputType'               => 'text',
			'unique'                  => true,
			'sql'                     => "varchar(256) NOT NULL default ''"
		),
		'class' => array
		(
			'sql'                     => "varchar(256) NOT NULL default ''"
		),
		'no_regex' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_contentmodify']['use_letter'],
			'inputType'               => 'checkbox',
			'options_callback'        => array('tl_contentmodify', 'getNoRegex'),
			'eval'                    => array('multiple'=>true),
			'default'				  => $regex,
			'sql'                     => "varchar(256) NOT NULL default ''"
		),
		'wildcard' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_contentmodify']['wildcard'],
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>1),
			'default'				  => $GLOBALS['TL_CONFIG']['wildcard'],
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_contentmodify']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'clr', 'doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		)
	)
);






switch ($this->Input->get('do')) {
    case 'cmHighlight':
		include('../system/modules/contentmodify/dca/highlight.php');
        break;
    case 'cmStrong':
		include('../system/modules/contentmodify/dca/strong.php');
        break;
    case 'cmAcronym':
		include('../system/modules/contentmodify/dca/acronym.php');
        break;
    case 'cmAbbr':
		include('../system/modules/contentmodify/dca/abbr.php');
        break;
    case 'cmLang':
		include('../system/modules/contentmodify/dca/lang.php');
        break;
}

if(!$GLOBALS['TL_CONFIG']['no_regex_2'])
{
	$repArray = array(
		',no_regex',
		',wildcard',
		'{label_start},',
		';{label_regex},'
	);
	$repArray2 = array(
		'',
		'',
		'',
		','
	);
	$GLOBALS['TL_DCA']['tl_contentmodify']['palettes']['default'] = str_replace ($repArray,$repArray2,$GLOBALS['TL_DCA']['tl_contentmodify']['palettes']['default']);

	$GLOBALS['TL_DCA']['tl_contentmodify']['fields']['no_regex']['eval']['doNotShow'] = true;
	$GLOBALS['TL_DCA']['tl_contentmodify']['fields']['wildcard']['eval']['doNotShow'] = true;
}




/**
 * Class tl_contentmodify
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Frank Thonak www.thomkit.de
 * @author     Frank Thonak
 * @package    contentmodify
 */
class tl_contentmodify extends Backend
{
	/**
	 * Import the back end user object
	 */
	public function generate()
	{

	}


	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(Input::get('tid')))
        {
	           $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1));
               $this->redirect($this->getReferer());
        }

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * Return all content elements as array
	 * @return array
	 */
	public function getNoRegex()
	{
		$arrReturn = array();

		$arrReturn['rk'] = ' ()';
		$arrReturn['ek'] = ' []';
//		$arrReturn['sk'] = ' <>';
		$arrReturn['-'] = ' -';
		$arrReturn['+'] = ' +';
		$arrReturn['.'] = ' .';
		$arrReturn['*'] = ' *';
		$arrReturn['?'] = ' ?';

//		natcasesort($arrReturn);
		return $arrReturn;
	}


	/**
	 * Update type
	 * @param dataContainer
	 */
	public function updateTypeH($dc)
	{
		// Update the database
		$this->Database->prepare("UPDATE tl_contentmodify SET type='h' WHERE id=?")
					   ->execute($this->Input->get('id'));
	}
	/**
	 * Update type
	 * @param dataContainer
	 */
	public function updateTypeS($dc)
	{
		// Update the database
		$this->Database->prepare("UPDATE tl_contentmodify SET type='s' WHERE id=?")
					   ->execute($this->Input->get('id'));
	}
	/**
	 * Update type
	 * @param dataContainer
	 */
	public function updateTypeA($dc)
	{
		// Update the database
		$this->Database->prepare("UPDATE tl_contentmodify SET type='a' WHERE id=?")
					   ->execute($this->Input->get('id'));
	}
	/**
	 * Update type
	 * @param dataContainer
	 */
	public function updateTypeB($dc)
	{
		// Update the database
		$this->Database->prepare("UPDATE tl_contentmodify SET type='b' WHERE id=?")
					   ->execute($this->Input->get('id'));
	}
	/**
	 * Update type
	 * @param dataContainer
	 */
	public function updateTypeL($dc)
	{
		// Update the database
		$this->Database->prepare("UPDATE tl_contentmodify SET type='l' WHERE id=?")
					   ->execute($this->Input->get('id'));
	}

	public function getLang()
	{
		return explode(',',$GLOBALS['TL_CONFIG']['cm_lang']);
	}

	/**
	 * Disable/enable
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Update the database
		$this->Database->prepare("UPDATE tl_contentmodify SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);
	}
}

