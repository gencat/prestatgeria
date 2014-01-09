<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2001, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: backend.php 24342 2008-06-06 12:03:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @deprecated
 * @note This file is only need for news module users upgrading from .7x
 * @note This file will be removed for the next major release
 */

include 'includes/pnAPI.php';
pnInit();

pnRedirect(pnModURL('News', 'user', 'view', array('theme' => 'rss')));
