<?php

/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

/**
 * Adminhtml reviews grid
 *
 * @method int getProductId() getProductId()
 * @method \Magefan\Blog\Block\Adminhtml\Grid setProductId() setProductId(int $productId)
 * @method int getCustomerId() getCustomerId()
 * @method \Magefan\Blog\Block\Adminhtml\Grid setCustomerId() setCustomerId(int $customerId)
 * @method \Magefan\Blog\Block\Adminhtml\Grid setMassactionIdFieldOnlyIndexValue() setMassactionIdFieldOnlyIndexValue(bool $onlyIndex)
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace Magefan\Blog\Block\Adminhtml;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{     

    protected $_commentFactory;

      public function __construct(
         \Magento\Backend\Block\Template\Context $context,
         \Magefan\Blog\Model\CommentFactory $commentFactory,
        array $data = []
    ) {
        $this->_commentFactory = $commentFactory;
        parent::__construct($context, $data);
    }

}