<?php
namespace F5\CatFacts\Block;

use F5\CatFacts\Api\CatFactsApi;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class CatFact extends Template
{

    public function __construct(
        public readonly CatFactsApi $catFactsApi,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @throws \JsonException
     */
    public function getCatFact($method = null): string
    {
        return $this->catFactsApi->getCatFact($method);
    }
}
