<?php
namespace Oakma\SeoRules\Api\Data;

/**
 * Seo rule interface.
 * @api
 */
interface RuleInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const RULE_ID = 'id';
	const PARENT_RULE_ID = 'parent_rule_id';
	const RULE_NAME = 'rule_name';
	const ENTITY_ID = 'entity';
	const ENTITY_VALUE = 'entity_value';
	const FILTER = 'filter';
	const FILTER_VALUE = 'filter_value';
	const STATUS = 'status';
	const PAGE_TITLE = 'page_title';
	const META_KEYWORDS = 'meta_keywords';
	const META_DESCRIPTION = 'meta_description';
	const SEO_H1 = 'seo_h1';
	const SEO_TEXT = 'seo_text';
	const SORT_ORDER = 'sort_order';
	const STORE_IDS = 'store_ids';
	const CREATED_TIME = 'created_time';
	const UPDATED_TIME = 'updated_time';
    /**#@-*/

	/**
	 * @return string
	 */
    public function getPageTitle();

    /**
     * @return string
     */
    public function getMetaDescription();

    /**
     * @return string
     */
    public function getMetaKeywords();

    /**
     * @return string
     */
    public function getMetaKeywords();

    /**
     * @return string
     */
    public function getSeoH1();

    /**
     * @return string
     */
    public function getSeoText();

    /**
     * @return \Oakma\SeoRules\Model\Rule
     */
    public function getParentRule();
}
