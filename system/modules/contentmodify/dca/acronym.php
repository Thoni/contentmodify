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
 * Table tl_contentmodify
 */
$GLOBALS['TL_DCA']['tl_contentmodify']['config']['onsubmit_callback'] = array(array('tl_contentmodify', 'updateTypeA'));

$GLOBALS['TL_DCA']['tl_contentmodify']['list']['sorting']['filter'] = array(array('type=?','a'));

$GLOBALS['TL_DCA']['tl_contentmodify']['fields']['text']['label'] = &$GLOBALS['TL_LANG']['tl_contentmodify']['textA'];
$GLOBALS['TL_DCA']['tl_contentmodify']['fields']['text']['eval'] = array('tl_class'=>'w50', 'mandatory'=>true, 'maxlength'=>100);

$GLOBALS['TL_DCA']['tl_contentmodify']['fields']['class']['label'] = &$GLOBALS['TL_LANG']['tl_contentmodify']['beschreibung'];
$GLOBALS['TL_DCA']['tl_contentmodify']['fields']['class']['exclude'] = true;
$GLOBALS['TL_DCA']['tl_contentmodify']['fields']['class']['inputType'] = 'text';
$GLOBALS['TL_DCA']['tl_contentmodify']['fields']['class']['default'] = '';
$GLOBALS['TL_DCA']['tl_contentmodify']['fields']['class']['eval'] = array('mandatory'=>true, 'maxlength'=>100);

?>