<?php
/**
 * Copyright © 2016 Ihor Vansach (ihor@magefan.com). All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Magefan\Blog\Ui\DataProvider\Comment\Form;

use Magefan\Blog\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class CommentDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magefan\Blog\Model\ResourceModel\comment\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $commentCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $commentCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $commentCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $comment \Magefan\Blog\Model\Comment */
        foreach ($items as $comment) {
            $comment = $comment->load($comment->getId()); //temporary fix
            $data = $comment->getData();

            /* Prepare Featured Image */
            $map = [
                'featured_img' => 'getFeaturedImage',
                'og_img' => 'getOgImage'
            ];
            foreach ($map as $key => $method) {
                if (isset($data[$key])) {
                    $name = $data[$key];
                    unset($data[$key]);
                    $data[$key][0] = [
                        'name' => $name,
                        'url' => $comment->$method(),
                    ];
                }
            }

            $data['data'] = ['links' => []];

            /* Prepare related comments */
            $collection = $comment->getRelatedcomments();
            $items = [];
            foreach($collection as $item) {
                $items[] = [
                    'id' => $item->getId(),
                    'title' => $item->getTitle(),
                ];
            }
            $data['data']['links']['comment'] = $items;

            /* Prepare related products */
            $collection = $comment->getRelatedProducts()->addAttributeToSelect('name');
            $items = [];
            foreach($collection as $item) {
                $items[] = [
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                ];
            }
            $data['data']['links']['product'] = $items;

            /* Set data */
            $this->loadedData[$comment->getId()] = $data;
        }

        return $this->loadedData;
    }
}
