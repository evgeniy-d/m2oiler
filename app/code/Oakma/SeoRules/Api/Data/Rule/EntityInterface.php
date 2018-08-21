<?php
namespace Oakma\SeoRules\Api\Data\Rule;

/**
 * Seo entity interface.
 * @api
 */
interface EntityInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY_ID = 'id';
    const ENTITY_KEY = 'key';
    const ENTITY_NAME = 'name';
    /**#@-*/

	/**
	 * Entity 'default'
	 */
    const TYPE_DEFAULT_CODE     = 'default';

	/**
	 * Entity 'product category'
	 */
	const TYPE_CATEGORY_CODE     = 'category';

	/**
	 * Entity CMS page
	 */
	const TYPE_CMS_PAGE_CODE    = 'cms_page';

    /**
     * Get name of entity
     *
     * @return string
     */
    public function getName();

    /**
     * Get key of entity
     *
     * @return string
     */
    public function getKey();
}
