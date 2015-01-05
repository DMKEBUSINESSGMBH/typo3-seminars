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
 * Test case.
 *
 * @package TYPO3
 * @subpackage tx_seminars
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class tx_seminars_OldModel_CategoryTest extends tx_phpunit_testcase {
	/**
	 * @var tx_seminars_OldModel_Category
	 */
	private $fixture;
	/**
	 * @var tx_oelib_testingFramework
	 */
	private $testingFramework;
	/**
	 * UID of the fixture's data in the DB
	 *
	 * @var int
	 */
	private $fixtureUid = 0;

	protected function setUp() {
		$this->testingFramework = new tx_oelib_testingFramework('tx_seminars');
		$this->fixtureUid = $this->testingFramework->createRecord(
			'tx_seminars_categories',
			array('title' => 'Test category')
		);
	}

	protected function tearDown() {
		$this->testingFramework->cleanUp();
	}

	public function testCreateFromUid() {
		$this->fixture = new tx_seminars_OldModel_Category($this->fixtureUid);

		$this->assertTrue(
			$this->fixture->isOk()
		);
	}

	public function testCreateFromUidFailsForInvalidUid() {
		$this->fixture = new tx_seminars_OldModel_Category($this->fixtureUid + 99);

		$this->assertFalse(
			$this->fixture->isOk()
		);
	}

	public function testCreateFromUidFailsForZeroUid() {
		$this->fixture = new tx_seminars_OldModel_Category(0);

		$this->assertFalse(
			$this->fixture->isOk()
		);
	}

	public function testCreateFromDbResult() {
		$dbResult = tx_oelib_db::select(
			'*',
			'tx_seminars_categories',
			'uid = '.$this->fixtureUid
		);

		$this->fixture = new tx_seminars_OldModel_Category(0, $dbResult);

		$this->assertTrue(
			$this->fixture->isOk()
		);
	}

	public function testCreateFromDbResultFailsForNull() {
		$this->fixture = new tx_seminars_OldModel_Category(0, NULL);

		$this->assertFalse(
			$this->fixture->isOk()
		);
	}

	public function testGetTitle() {
		$this->fixture = new tx_seminars_OldModel_Category($this->fixtureUid);

		$this->assertEquals(
			'Test category',
			$this->fixture->getTitle()
		);
	}

	public function testGetIconReturnsIcon() {
		$this->fixture = new tx_seminars_OldModel_Category(
			$this->testingFramework->createRecord(
				'tx_seminars_categories',
				array(
					'title' => 'Test category',
					'icon' => 'foo.gif',
				)
			)
		);

		$this->assertEquals(
			'foo.gif',
			$this->fixture->getIcon()
		);
	}

	public function testGetIconReturnsEmptyStringIfCategoryHasNoIcon() {
		$this->fixture = new tx_seminars_OldModel_Category($this->fixtureUid);

		$this->assertEquals(
			'',
			$this->fixture->getIcon()
		);
	}
}