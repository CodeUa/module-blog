<?php

namespace Magefan\Blog\Model\ResourceModel\Comment\Collection;

use \Magefan\Blog\Model\ResourceModel\Comment\Collection;

class Grid extends Collection
{

	  /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;
    /**
     * @var int
     */
    protected $_storeId;

	    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_date = $date;
        $this->_storeManager = $storeManager;
    }


    /**
     * {@inheritdoc}
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()
            ->joinLeft(
                ["post"=>'magefan_blog_post'], 
                'main_table.post_id = post.post_id',
                ['title' => "title"]
            );

        return $this;
    }

	/**
     * Perform operations after collection load
     *
     * @return $this
     */
	protected function _afterLoad()
    {
        $items = $this->getColumnValues('post_id');// 1 
        if (count($items)) { //true
            $connection = $this->getConnection();// connect to database
            $tableName = $this->getTable('magefan_blog_post_store');// gettable
            $select = $connection->select()//selelct * ....
                ->from(['cps' => $tableName])
                ->where('cps.post_id IN (?)', $items);// беремо значення де post_id = 1
            $result = [];//empty array
            foreach ($connection->fetchAll($select) as $item) {
                if (!isset($result[$item['post_id']])) { //$result[$item['post_id']] = 1 // true
                    $result[$item['post_id']] = [];// двохвимірний массив
                }
                $result[$item['post_id']][] = $item['store_id'];//$result[1][0] = 0
            }
            if ($result) {
                foreach ($this as $item) {
                    $postId = $item->getData('post_id');
                    if (!isset($result[$postId])) {
                        continue;
                    }
                    if ($result[$postId] == 0) {
                        $stores = $this->_storeManager->getStores(false, true);
                        $storeId = current($stores)->getId();
                    } else {
                        $storeId = $result[$postId];
                    }

                    $item->setData('_first_store_id', $storeId);
                    $item->setData('store_ids', $result[$postId]);
                }
            }
            if ($this->_storeId) {
                foreach ($this as $item) {
                    $item->setStoreId($this->_storeId);
                }
            }
        }
        $this->_previewFlag = false;
        return parent::_afterLoad();
    }

     /**
     * Add store filter to collection
     * @param array|int|\Magento\Store\Model\Store  $store
     * @param boolean $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if ($store === null) {
            return $this;
        }
        if (!$this->getFlag('store_filter_added')) {
            if ($store instanceof \Magento\Store\Model\Store) {
                $this->_storeId = $store->getId();
                $store = [$store->getId()];
            }
            if (!is_array($store)) {
                $this->_storeId = $store;
                $store = [$store];
            }
            if (in_array(\Magento\Store\Model\Store::DEFAULT_STORE_ID, $store)) {
                return $this;
            }
            if ($withAdmin) {
                $store[] = \Magento\Store\Model\Store::DEFAULT_STORE_ID;
            }
            $this->addFilter('store', ['in' => $store], 'public');
        }
        return $this;
    }



}