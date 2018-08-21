<?php
namespace Oakma\SeoRules\Api\Rule;

/**
 * Seo rule interface.
 * @api
 */
interface EntityManagementInterface
{
    /**
     * Get available seo rule's entities
     *
     * @return \Oakma\SeoRules\Api\Data\Rule\EntityInterface[]
     */
    public function getAvailableEntities();
}
