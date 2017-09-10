<?php
/**
 * Copyright © 2016 Ihor Vansach (ihor@magefan.com). All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magefan\Blog\Model\Config\Source;

/**
 * Select list
 *
 */
class Select implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magento\User\Model\ResourceModel\User\CollectionFactory
     */
    protected $selectCollectionFactory;

    /**
     * @var array
     */
    protected $options;

    /**
     * Initialize dependencies.
     *
     * @param \Magento\User\Model\ResourceModel\User\CollectionFactory $selectCollectionFactory
     * @param void
     */
    public function __construct(
        \Magento\User\Model\ResourceModel\User\CollectionFactory $selectCollectionFactory
    ) {
        $this->selectCollectionFactory = $selectCollectionFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            $this->options = [

            ['label' => __('Approved'), 'value' => 1],
            ['label' => __('Pending'), 'value' => 0],
            ['label' => __('Not Approved'), 'value' => -1]

            ];

            $collection = $this->selectCollectionFactory->create();
        }

        return $this->options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->toOptionArray() as $item) {
            $array[$item['value']] = $item['label'];
        }
        return $array;
    }


}
