<?php
namespace Oakma\SeoRules\Api\Rule;

/**
 * Seo rule interface.
 * @api
 */
interface EntityManagementInterface
{
	/**
	 * Get page titile
	 *
	 * @return string
	 */
	public function fetchPageTitle();

	/**
	 * Fetch meta description
	 *
	 * @return string
	 */
	public function fetchMetaDescription();

	/**
	 * Fetch meta keywords
	 *
	 * @return string
	 */
	public function fetchMetaKeywords();

	/**
	 * Fetch seo tag h1
	 *
	 * @return string
	 */
	public function fetchSeoH1();

	/**
	 * Fetch seo text
	 *
	 * @return string
	 */
	public function fetchSeoText();
}
