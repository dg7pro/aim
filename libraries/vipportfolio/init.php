<?php
/**
 * @package      ITPrism Components
 * @subpackage   Vip Portfolio
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * Vip Portfolio is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined('_JEXEC') or die;

if(!defined("VIPPORTFOLIO_PATH_COMPONENT_ADMINISTRATOR")) {
    define("VIPPORTFOLIO_PATH_COMPONENT_ADMINISTRATOR", JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . "components" . DIRECTORY_SEPARATOR ."com_vipportfolio");
}

if(!defined("VIPPORTFOLIO_PATH_LIBRARY")) {
    define("VIPPORTFOLIO_PATH_LIBRARY", JPATH_LIBRARIES . DIRECTORY_SEPARATOR. "vipportfolio");
}

if(!defined("ITPRISM_PATH_LIBRARY")) {
    define("ITPRISM_PATH_LIBRARY", JPATH_LIBRARIES . DIRECTORY_SEPARATOR. "itprism");
}

// Import libraries
jimport('joomla.utilities.arrayhelper');

// Register libraries and helpers
JLoader::register("ITPrismErrors",       ITPRISM_PATH_LIBRARY. DIRECTORY_SEPARATOR ."errors.php");
JLoader::register("VipPortfolioHelper",  VIPPORTFOLIO_PATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . "helpers" . DIRECTORY_SEPARATOR . "vipportfolio.php");
//JLoader::register("VipPortfolioHelperRoute", VIPPORTFOLIO_PATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . "helpers" . DIRECTORY_SEPARATOR . "route.php");
JLoader::register("Facebook",            VIPPORTFOLIO_PATH_LIBRARY . DIRECTORY_SEPARATOR . "facebook".DIRECTORY_SEPARATOR."facebook.php");