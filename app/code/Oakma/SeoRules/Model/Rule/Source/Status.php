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
        $options = [
	        [
	        	'value' => 1,
	            'label' => __('Enabled')
	        ],
	        [
		        'value' => 0,
		        'label' => __('Disabled')
	        ],
        ];

        return $options;
    }
}
