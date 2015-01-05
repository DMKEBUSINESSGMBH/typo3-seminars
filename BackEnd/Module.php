<?php
/***************************************************************
* Copyright notice
*
* (c) 2008-2013 Oliver Klee (typo3-coding@oliverklee.de)
* All rights reserved
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * This class is the base class for a back-end module.
 *
 * @package TYPO3
 * @subpackage tx_seminars
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class tx_seminars_BackEnd_Module extends t3lib_SCbase {
	/**
	 * data of the current BE page
	 *
	 * @var string[]
	 */
	private $pageData = array();

	/**
	 * Frees as much memory used by this object as possible.
	 */
	public function __destruct() {
		unset($this->doc, $this->extObj, $this->pageData);
	}

	/**
	 * Returns the data of the current BE page.
	 *
	 * @return string[] the data of the current BE page, may be emtpy
	 */
	public function getPageData() {
		return $this->pageData;
	}

	/**
	 * Sets the data for the current BE page.
	 *
	 * @param string[] $pageData page data, may be empty
	 *
	 * @return void
	 */
	public function setPageData(array $pageData) {
		$this->pageData = $pageData;
	}
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/seminars/BackEnd/Module.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/seminars/BackEnd/Module.php']);
}