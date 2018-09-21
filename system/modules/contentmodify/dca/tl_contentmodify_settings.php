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



/**
 * System configuration
 */
$GLOBALS['TL_DCA']['tl_contentmodify_settings'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'File',
		'closed'                      => true
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{label_start},cm_lang,cm_elements;{label_regex},wildcard,no_regex,no_regex_2;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		''                     => ''
	),

	// Fields
	'fields' => array
	(
		'cm_lang' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_contentmodify_settings']['cm_lang'],
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true),
			'default'				  => 'de,en,fr'
		),
		'cm_elements' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_contentmodify_settings']['cm_elements'],
			'inputType'               => 'checkbox',
			'options_callback'        => array('tl_contentmodify_settings', 'getContentElements'),
			'eval'                    => array('multiple'=>true)
		),
		'no_regex' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_contentmodify_settings']['no_regex'],
			'inputType'               => 'checkbox',
			'options_callback'        => array('tl_contentmodify_settings', 'getNoRegex'),
			'eval'                    => array('multiple'=>true)
		),
		'no_regex_2' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_contentmodify_settings']['no_regex_2'],
			'inputType'               => 'checkbox',
			'options'       		  => array('1'=>&$GLOBALS['TL_LANG']['tl_contentmodify_settings']['anzeigen'])
		),
		'wildcard' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_contentmodify_settings']['wildcard'],
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>1)
		)
	)
);


/**
 * Class tl_contentmodify_settings
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2011
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class tl_contentmodify_settings extends Backend
{


	/**
	 * Return all content elements as array
	 * @return array
	 */
	public function getContentElements()
	{
		$arrReturn = array();
		$blacklist = array('files','images');

		foreach ($GLOBALS['TL_CTE'] as $k=>$v)
		{
			foreach (array_keys($v) as $kk)
			{
				if(!in_array($k,$blacklist)) $arrReturn[$kk] = '<span style="color:#b3b3b3;">['. $k .']</span> ' . $kk;
			}
		}
		natcasesort($arrReturn);
		return $arrReturn;
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
	 * Return all modules except back end and front end as array
	 * @return array
	 */
	public function getModules()
	{
		$arrReturn = array();
		$arrModules = scan(TL_ROOT . '/system/modules');

		$arrInactiveModules = deserialize($GLOBALS['TL_CONFIG']['inactiveModules']);
		$blnCheckInactiveModules = is_array($arrInactiveModules);

		foreach ($arrModules as $strModule)
		{
			if (substr($strModule, 0, 1) == '.')
			{
				continue;
			}

			if ($strModule == 'backend' || $strModule == 'frontend' || !is_dir(TL_ROOT . '/system/modules/' . $strModule))
			{
				continue;
			}

			if ($blnCheckInactiveModules && in_array($strModule, $arrInactiveModules))
			{
				$strFile = sprintf('%s/system/modules/%s/languages/%s/modules.php', TL_ROOT, $strModule, $GLOBALS['TL_LANGUAGE']);

				if (file_exists($strFile))
				{
					include($strFile);
				}
			}

			$arrReturn[$strModule] = '<span style="color:#b3b3b3;">['. $strModule .']</span> ' . (is_array($GLOBALS['TL_LANG']['MOD'][$strModule]) ? $GLOBALS['TL_LANG']['MOD'][$strModule][0] : $GLOBALS['TL_LANG']['MOD'][$strModule]);
		}

		natcasesort($arrReturn);
		return $arrReturn;
	}


	/**
	 * Remove protected search results if the feature is being disabled
	 * @param mixed
	 * @return array
	 */
	public function clearSearchIndex($varValue)
	{
		if (!$varValue)
		{
			$this->Database->execute("DELETE FROM tl_search WHERE protected=1");
		}

		return $varValue;
	}


	/**
	 * Make sure that resultsPerPage > 0
	 * @param mixed
	 * @return array
	 */
	public function checkResultsPerPage($varValue)
	{
		if ($varValue < 1)
		{
			$varValue = 30;
		}

		return $varValue;
	}


	/**
	 * Check the upload path
	 * @param mixed
	 * @return array
	 */
	public function checkUploadPath($varValue)
	{
		$varValue = str_replace(array('../', '/..', '/.', './', '://'), '', $varValue);

		if ($varValue == '.' || $varValue == '..' || $varValue == '')
		{
			$varValue = 'tl_files';
		}

		return $varValue;
	}
}

?>