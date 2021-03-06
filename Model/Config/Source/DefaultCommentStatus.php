<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Used in creating options for Approved|Pennding config value selection
 *
 */
namespace app\code\Magefan\Blog\Model\Config\Source;


class DefaultCommentStatus implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 1, 'label' => __('Approved')], ['value' => 0, 'label' => __('Pennding')]];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [0 => __('Pennding'), 1 => __('Approved')];
    }
}

