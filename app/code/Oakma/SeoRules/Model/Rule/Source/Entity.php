<?php

namespace Oakma\SeoRules\Model\Rule\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Entity
 */
class Entity implements OptionSourceInterface
{
    /**
     * @var \Magento\Cms\Model\Page
     */
    protected $cmsPage;

    /**
     * Constructor
     *
     * @param \Magento\Cms\Model\Page $cmsPage
     */
    public function __construct(\Magento\Cms\Model\Page $entityRepository)
    {
        $this->cmsPage = $cmsPage;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->cmsPage->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
