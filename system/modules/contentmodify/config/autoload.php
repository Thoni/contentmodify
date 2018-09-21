<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package Contentmodify
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'ModuleHighlight' => 'system/modules/contentmodify/classes/ModuleHighlight.php',
	'ModuleModify'    => 'system/modules/contentmodify/classes/ModuleModify.php',
));
