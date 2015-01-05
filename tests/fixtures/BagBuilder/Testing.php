<?php
/***************************************************************
* Copyright notice
*
* (c) 2007-2013 Oliver Klee (typo3-coding@oliverklee.de)
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
 * This builder class creates customized test bag objects.
 *
 * @package TYPO3
 * @subpackage tx_seminars
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class tx_seminars_tests_fixtures_BagBuilder_Testing extends tx_seminars_BagBuilder_Abstract {
	/**
	 * @var string class name of the bag class that will be built
	 */
	protected $bagClassName = 'tx_seminars_tests_fixtures_Bag_Testing';

	/**
	 * @var string the table name of the bag to build
	 */
	protected $tableName = 'tx_seminars_test';

	/**
	 * Limits the bag to records with a particular title.
	 *
	 * @param string $title title which the bag elements must match, may be empty, must already be SQL-safe
	 *
	 * @return void
	 */
	public function limitToTitle($title) {
		$this->whereClauseParts['title'] = 'title = "' . $title . '"';
	}

	/**
	 * Returns the additional table names.
	 *
	 * @return string[] the additional table names, may be empty
	 */
	public function getAdditionalTableNames() {
		return $this->additionalTableNames;
	}

	/**
	 * Returns the order by statement.
	 *
	 * @return string the order by statement, may be empty
	 */
	public function getOrderBy() {
		return $this->orderBy;
	}

	/**
	 * Returns the limit statement.
	 *
	 * @return string the limit statement, may be empty
	 */
	public function getLimit() {
		return $this->limit;
	}

	/**
	 * Sets $this->tableName with the value in the parameter $tableName.
	 *
	 * @param string $tableName the table name to set, may be empty for testing
	 *
	 * @return void
	 */
	public function setTableName($tableName) {
		$this->tableName = $tableName;
	}
}