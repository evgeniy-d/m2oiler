<?php

namespace Oakma\SeoRules\Model\Rule\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 */
class Status implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->cmsPage->getAvailableStatuses();

        $options = [
	        [
	        	'label' => 1,
	            'value' => __('Enabled')
	        ],
	        [
		        'label' => 0,
		        'value' => __('Disabled')
	        ],
        ];

        return $options;
    }
}
