<?php

namespace Earthlite\Canonical\Plugin;

use Magento\Framework\App\Request\Http;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Page\Config as PageConfig;

class CanonicalTag
{
    /**
     * @var \Magento\Framework\View\Page\Config
     */
    protected $pageConfig;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @param PageConfig $pageConfig
     * @param Http $request
     * @param UrlInterface $url
     */

    public function __construct(
        PageConfig $pageConfig,
        Http $request,
        UrlInterface $url
    ) {
        $this->pageConfig   = $pageConfig;
        $this->request      = $request;
        $this->url          = $url;
    }

    /**
     * @param \Magento\Framework\View\Page\Config\Renderer $subject
     * @param $result
     * @return mixed
     */
    public function afterRenderMetadata(\Magento\Framework\View\Page\Config\Renderer $subject, $result)
    {
        try {
            $queryParam = explode('?', $this->url->getCurrentUrl())[0];
            if (($this->request->getFullActionName() != 'catalog_product_view' && $this->request->getFullActionName() != 'catalog_category_view')) {
                $this->pageConfig->addRemotePageAsset(
                    $queryParam,
                    'canonical',
                    ['attributes' => ['rel' => 'canonical']]
                );
            }
        } catch (Exception $ex) {
        }
        return $result;
    }
}
