<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 IllusionFACTORY (info@illusion-factory.de)
 *  All rights reserved
 *
 *  You may not remove or change the name of the author above. See:
 *  http://www.gnu.org/licenses/gpl-faq.html#IWantCredit
 *
 *  This script is part of the Typo3 project. The Typo3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace IllusionFACTORY\ABTestPages;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class detects which page version (either by cookie or by random) and sets the page ID accordingly. 
 * Random means original ID or "B" version ID.
 *
 * @package IllusionFACTORY\ABTestPages
 * @author IllusionFACTORY <info@illusion-factory.de>
 */
class ShowPage {

	/** @var int|null */
	protected $currentPageId = null;

	/** @var int|null */
	protected $rootpage_id = null;	

	/** @var int|null */
	protected $selectBSite = null;

	/** @var int|null */
	protected $cookieLifeTime = null;

	/** @var int|null */
	protected $randomAbPageId = null;

	/** @var string */
	protected $additionalHeaderData;

	/**
	 * This function detects which page version (either by cookie or by random) and sets the page ID accordingly. 
	 * Random means original ID or "B" version ID.
	 * This function is called from \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::checkAlternativeIdMethods()
	 *
	 * @param array $params
	 * @return void
	 */
	public function SelectId(array $params) {
		$this->currentPageId = $params['pObj']->id;
		// Get the rootpage_id from realurl config.
		$this->rootpage_id = $params['pObj']->TYPO3_CONF_VARS['EXTCONF']['realurl'];
		$this->rootpage_id = reset($this->rootpage_id);
		$this->rootpage_id = $this->rootpage_id['pagePath']['rootpage_id'];
		
		// If the ID is NULL, then we set this value to the rootpage_id. NULL is the "Home"page, ID is a specific sub-page, e.g. www.domain.de (NULL) - www.domain.de/page.html (ID)
		if(!$this->currentPageId) {
			if($this->rootpage_id) {
				$this->currentPageId = $this->rootpage_id;
			} else {
				// Leave the function because we can not determine the ID.
				return;
			}
		}

		$pageRepository = GeneralUtility::makeInstance('TYPO3\\CMS\Frontend\\Page\\PageRepository');
		$currentPagePropertiesArray = $pageRepository->getPage($this->currentPageId);

		$this->selectBSite = $currentPagePropertiesArray['tx_abtestpages_b_id'];
		$this->cookieLifeTime = $currentPagePropertiesArray['tx_abtestpages_cookie_time'];

		// If a "B" version is specified we start looking for cookies.
		// If a cookie for current page exists the ID in the cookie is our preferred page ID.
		// If a cookie does not exist we select the page version by random. 
		if($this->selectBSite) {
			if($_COOKIE["abtestpages-".$this->currentPageId]) {
				$this->randomAbPageId = $_COOKIE["abtestpages-".$this->currentPageId];
			} else {
				$randomPage = rand(0,1); // 0 = original ID; 1 = "B" site.
				if($randomPage) {
					$this->randomAbPageId = $this->selectBSite;
				} else {
					$this->randomAbPageId = $this->currentPageId;
				}
				setcookie("abtestpages-".$this->currentPageId,$this->randomAbPageId,time()+$this->cookieLifeTime);
			}

			// If current page ID is different from the random page ID we set the correct page ID. 
			if($this->currentPageId != $this->randomAbPageId) {
				$params['pObj']->id = $this->randomAbPageId;
			} 
		}

		// If additional headerdata is present then we specify additionalHeaderData. 
		$randomPagePropertiesArray = $pageRepository->getPage($this->randomAbPageId);
		$this->additionalHeaderData = $randomPagePropertiesArray['tx_abtestpages_header'];
		if($this->additionalHeaderData) {
			$GLOBALS['TSFE']->additionalHeaderData['abtestpages'] = $this->additionalHeaderData;
		} 
	}
}




