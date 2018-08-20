<?php
namespace Oakma\SeoRules\Api;

/**
 * Seo rule fetcher interface.
 * @api
 */
interface RuleFetcherInterface
{
	/**
	 * Definition entity (page type) and its value
	 *
	 * @return array
	 */
	public function fetchEntity();

	/**
	 * Definition filters and its values
	 *
	 * @return array
	 */
	public function fetchFilters();

	/**
	 * Collect all variables
	 *
	 * @return array
	 */
	public function getVariables();
}
