<?php

namespace Magefan\Blog\Model;

use \Magento\Framework\Model\AbstractModel;
 
class Comment extends AbstractModel
{   
     /**
     * @var \Magefan\Blog\Model\AuthorFactory
     */
    protected $_postFactory;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        Url $url,
        \Magefan\Blog\Model\ImageFactory $imageFactory,
        \Magefan\Blog\Model\PostFactory $postFactory,
        \Magefan\Blog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magefan\Blog\Model\ResourceModel\Tag\CollectionFactory $tagCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);

        $this->filterProvider = $filterProvider;
        $this->_url = $url;
        $this->imageFactory = $imageFactory;
        $this->_postFactory = $postFactory;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_tagCollectionFactory = $tagCollectionFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_relatedPostsCollection = clone($this->getCollection());
    }

    protected function _construct()
    {   
        $this->_init('Magefan\Blog\Model\ResourceModel\Comment');
    }

    /**
     * Retrieve model title
     * @param  boolean $plural
     * @return string
     */
    public function getOwnTitle($plural = false)
    {
        return $plural ? 'Comments' : 'Comment';
    }

    /**
     * Retrieve post author
     * @return \Magefan\Blog\Model\Post | false
     */
    public function getPost()
    {
        if (!$this->hasData('post')) {
            $post = false;
            if ($postId = $this->getData('post_id')) {
                $_post = $this->_postFactory->create();
                $_post->load($postId);
                if ($_post->getId()) {
                    $post = $_post;
                }
            }
            $this->setData('post', $post);
        }
        return $this->getData('post');
    }
 
}