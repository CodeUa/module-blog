<?php

namespace Magefan\Blog\Controller\Adminhtml\Comment;

class Index extends \Magento\Backend\App\Action
{
	protected $resultPageFactory;

	public function __construct(
		 \Magento\Backend\App\Action\Context $context,
          \Magento\Framework\View\Result\PageFactory $resultPageFactory
	) { 
        	parent::__construct($context);
             $this->resultPageFactory = $resultPageFactory;	

        }

	public function execute()
	{
        
     $resultPage = $this->resultPageFactory->create();
     $resultPage->setActiveMenu('Magefan_Blog::comment');
     $resultPage->getConfig()->getTitle()->prepend(__('Comments'));
     // $this->_view->loadLayout();
     // $this->_view->renderLayout();

     return $resultPage;
    }
}