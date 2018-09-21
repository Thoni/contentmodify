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

/*
 * -------------------------------------------------------------------------
 * BACK END MODULES
 * -------------------------------------------------------------------------
 *
 */

array_insert(
    $GLOBALS['BE_MOD'], 1, array(
        'ContentModify' => array(
            'cmLang' => array(
                'icon'   => 'system/modules/contentmodify/assets/images/extension.gif',
                'tables' => array('tl_contentmodify')
            )
        )
    )
);
array_insert(
    $GLOBALS['BE_MOD'], 1, array(
        'ContentModify' => array(
            'cmAbbr' => array(
                'icon'   => 'system/modules/contentmodify/assets/images/extension.gif',
                'tables' => array('tl_contentmodify')
            )
        )
    )
);
array_insert(
    $GLOBALS['BE_MOD'], 1, array(
        'ContentModify' => array(
            'cmAcronym' => array(
                'icon'   => 'system/modules/contentmodify/assets/images/extension.gif',
                'tables' => array('tl_contentmodify')
            )
        )
    )
);
array_insert(
    $GLOBALS['BE_MOD'], 1, array(
        'ContentModify' => array(
            'cmStrong' => array(
                'icon'   => 'system/modules/contentmodify/assets/images/extension.gif',
                'tables' => array('tl_contentmodify')
            )
        )
    )
);
array_insert(
    $GLOBALS['BE_MOD'], 1, array(
        'ContentModify' => array(
            'cmHighlight' => array(
                'icon'   => 'system/modules/contentmodify/assets/images/extension.gif',
                'tables' => array('tl_contentmodify')
            )
        )
    )
);
array_insert(
    $GLOBALS['BE_MOD'], 1, array(
        'ContentModify' => array(
            'cmSettings' => array(
                'icon'   => 'system/modules/contentmodify/assets/images/extension.gif',
                'tables' => array('tl_contentmodify_settings')
            )
        )
    )
);

/*
 * -------------------------------------------------------------------------
 * HOOKS
 * -------------------------------------------------------------------------
 *
 */


if (TL_MODE == 'FE') $GLOBALS['TL_HOOKS']['getContentElement'][] = array('ModuleModify','doModify');


/*
 * -------------------------------------------------------------------------
 * CSS
 * -------------------------------------------------------------------------
 *
 */

$GLOBALS['TL_CSS']['contentmodify'] = 'system/modules/contentmodify/style/stylesheet.css';

?>