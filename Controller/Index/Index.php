<?php
/**
 * @author Sachindra Awasthi
 * @copyright Copyright (c) 2022 Fahim (https://www.Fahimwebtechnology.com/)
 * @package Fahim_SiteMap
 */
namespace Fahim\SiteMap\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public $resultPageFactory;

    /**
     * @var \Magento\Framework\App\Response\Http
     */
    public $response;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    public $url;

    /**
     * @var \Fahim\SiteMap\Helper\Data
     */
    public $helper;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    /**
     * Index constructor.
     * @param Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Fahim\SiteMap\Helper\Data $helper
     */
    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\RequestInterface $request,
        \Fahim\SiteMap\Helper\Data $helper
    ) {
        $this->request = $request;
        $this->resultFactory = $context->getResultFactory();
        $this->helper = $helper;
        $this->resultPageFactory = $resultPageFactory;
        $this->url = $context->getUrl();
        parent::__construct($context);
    }

    /**
     * @return $this|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $redirectUrl= $this->url->getUrl('');
        $isEnabled = $this->helper->isEnable();
        $title = $this->helper->getTitleSiteMap();
        $description = $this->helper->getDescriptionSitemap();
        $keywords = $this->helper->getKeywordsSitemap();
        $metaTitle = $this->helper->getMetaTitleSitemap();
        if ($isEnabled) {
            $identifier = trim($this->request->getPathInfo(), '/');
            $route = $this->helper->getModuleRoute();

            if ($identifier !== $route) {
                $redirectUrl= $this->url->getUrl($route);
                return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($redirectUrl);
            }
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->set(__($title));
            $resultPage->getConfig()->setDescription($description);
            $resultPage->getConfig()->setKeywords($keywords);
            $resultPage->getConfig()->setMetaTitle($metaTitle);
            return $resultPage;
        } else {
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($redirectUrl);
        }
    }
}
