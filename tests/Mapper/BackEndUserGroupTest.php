<?php
/***************************************************************
* Copyright notice
*
* (c) 2009-2013 Bernd Schönbach <bernd@oliverklee.de>
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
 * @author Bernd Schönbach <bernd@oliverklee.de>
 */
class tx_seminars_Mapper_BackEndUserGroupTest extends tx_phpunit_testcase {
	/**
	 * @var tx_oelib_testingFramework for creating dummy records
	 */
	private $testingFramework;
	/**
	 * @var tx_seminars_Mapper_BackEndUserGroup the object to test
	 */
	private $fixture;

	protected function setUp() {
		$this->testingFramework = new tx_oelib_testingFramework('tx_oelib');

		$this->fixture = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_BackEndUserGroup');
	}

	protected function tearDown() {
		$this->testingFramework->cleanUp();
	}


	/////////////////////////////////////////
	// Tests concerning the basic functions
	/////////////////////////////////////////

	/**
	 * @test
	 */
	public function findReturnsBackEndUserGroupInstance() {
		$uid = $this->fixture->getNewGhost()->getUid();

		$this->assertTrue(
			$this->fixture->find($uid)
				instanceof tx_seminars_Model_BackEndUserGroup
		);
	}

	/**
	 * @test
	 */
	public function loadForExistingUserGroupCanLoadUserGroupData() {
		/** @var tx_seminars_Model_BackEndUserGroup $userGroup */
		$userGroup = $this->fixture->find(
			$this->testingFramework->createBackEndUserGroup(
				array('title' => 'foo')
			)
		);

		$this->fixture->load($userGroup);

		$this->assertEquals(
			'foo',
			$userGroup->getTitle()
		);
	}
}