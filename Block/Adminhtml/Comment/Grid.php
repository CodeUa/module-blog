<?php

namespace Magefan\Blog\Block\Adminhtml\Comment;
 
class Grid extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Magefan_Blog';
        $this->_controller = 'adminhtml_blog';
        $this->_headerText = __('Comment');
        $this->_addButtonLabel = __('Add New Comment');
        parent::_construct();      
    }
}