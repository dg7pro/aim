<?php
/**
 * @package		 Vip Portfolio
 * @subpackage	 Library
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * Vip Portfolio is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('JPATH_PLATFORM') or die;

interface VipPortfolioInterfacePortfolio {
    
    public function addStyleSheets();
    public function addScripts();
    public function addScriptDeclaration();
    public function bind($params);
    public function render();
    
}
