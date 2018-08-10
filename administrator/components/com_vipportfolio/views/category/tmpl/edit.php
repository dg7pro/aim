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
?>
<form enctype="multipart/form-data"  action="<?php echo JRoute::_('index.php?option=com_vipportfolio&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="category-form" class="form-validate">
    <div class="width-40 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_("COM_VIPPORTFOLIO_CATEGORY_INFORMATION"); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getLabel('name'); ?>
                <?php echo $this->form->getInput('name'); ?></li>
    
                <li><?php echo $this->form->getLabel('alias'); ?>
                <?php echo $this->form->getInput('alias'); ?></li>
    
                <li><?php echo $this->form->getLabel('published'); ?>
                <?php echo $this->form->getInput('published'); ?></li>   
                
                <li><?php echo $this->form->getLabel('id'); ?>
                <?php echo $this->form->getInput('id'); ?></li>
                
                <li><?php echo $this->form->getLabel('image'); ?>
                    <?php echo $this->form->getInput('image'); ?></li> 
                    
            </ul>
            
            <div class="clr"></div>
            <?php echo $this->form->getLabel('desc'); ?>
            <div class="clr"></div>
            <?php echo $this->form->getInput('desc'); ?>
            <div class="clr"></div>
        </fieldset>
        
        <fieldset class="adminform">
            <legend><?php echo JText::_("COM_VIPPORTFOLIO_SEARCH_ENGINE_OPTIMIZATION"); ?></legend>
            
            <ul class="adminformlist">
                <li><?php echo $this->form->getLabel('spacer'); ?></li>
                <li><?php echo $this->form->getLabel('meta_title'); ?>
                <?php echo $this->form->getInput('meta_title'); ?></li>
    
                <li><?php echo $this->form->getLabel('meta_keywords'); ?>
                <?php echo $this->form->getInput('meta_keywords'); ?></li>
    
                <li><?php echo $this->form->getLabel('meta_desc'); ?>
                <?php echo $this->form->getInput('meta_desc'); ?></li>   
    
                <li><?php echo $this->form->getLabel('meta_canonical'); ?>
                <?php echo $this->form->getInput('meta_canonical'); ?></li>   
            </ul>
            
        </fieldset>
        
        <fieldset class="adminform">
            <legend><?php echo JText::_("COM_VIPPORTFOLIO_RESIZE_OPTIONS"); ?></legend>
            <ul class="adminformlist">
            	<li>
            		<label class="hasTip" for="resize_image" title="<?php echo JText::_("COM_VIPPORTFOLIO_IMAGE_RESIZE_DESC");?>"><?php echo JText::_("COM_VIPPORTFOLIO_IMAGE_RESIZE");?></label>  
            		<input type="checkbox" name="resize_image" value="1" class="inputbox" id="resize_image" <?php echo (!$this->state->get("resize_image", 0)) ? "" : 'checked="checked"'; ?> />
        		</li>
        		
        		<li>
            		<label class="hasTip" for="image_width" title="<?php echo JText::_("COM_VIPPORTFOLIO_IMAGE_RESIZE_WIDTH_DESC");?>"><?php echo JText::_("COM_VIPPORTFOLIO_IMAGE_WIDTH");?></label>  
            		<input type="text" name="image_width" value="<?php echo $this->state->get("image_width", "");?>" class="inputbox" id="image_width" />
        		</li>
        		
        		<li>
            		<label class="hasTip" for="image_height" title="<?php echo JText::_("COM_VIPPORTFOLIO_IMAGE_RESIZE_HEIGHT_DESC");?>"><?php echo JText::_("COM_VIPPORTFOLIO_IMAGE_HEIGHT");?></label>  
            		<input type="text" name="image_height" value="<?php echo $this->state->get("image_height", "");?>" class="inputbox" id="image_height" />
        		</li>
            </ul>
        </fieldset>
        
    </div>
    
    <div class="clr"></div>
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>
<?php if (!empty($this->item->image)) {?>
<img src="<?php echo "../" . $this->params->get("images_directory", "images/vipportfolio") . "/". $this->item->image; ?>" />
<div>
    <img src="../media/com_vipportfolio/images/remove_image.png" />
    <a href="<?php echo JRoute::_("index.php?option=com_vipportfolio&task=category.removeImage&id=" . $this->item->id); ?>" ><?php echo JText::_("COM_VIPPORTFOLIO_DELETE_IMAGE")?></a>
</div>
<?php }?>