<?php

namespace Magefan\Blog\Model;

use \Magento\Framework\Model\AbstractModel;
 
class Comment extends AbstractModel
{
 
    protected function _construct()
    {
        $this->_init('Magefan\Blog\Model\ResourceModel\Comment');
    }
 
}