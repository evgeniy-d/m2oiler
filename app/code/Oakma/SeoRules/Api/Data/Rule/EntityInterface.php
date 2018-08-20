<?php
namespace Oakma\SeoRules\Api\Data\Rule;

/**
 * Seo entity interface.
 * @api
 */
interface EtityInterface
{
	/**
	 * Entity 'default'
	 */
    const TYPE_DEFAULT_CODE     = 'default';

	/**
	 * Entity 'product category'
	 */
	const TYPE_DEFAULT_CODE     = 'category';

	/**
	 * Entity CMS page
	 */
	const TYPE_CMS_PAGE_CODE    = 'cms_page';
}
