<?php

namespace Magefan\Blog\Model\ResourceModel\Comment;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
 

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init('Magefan\Blog\Model\Comment', 'Magefan\Blog\Model\ResourceModel\Comment');
    }
}