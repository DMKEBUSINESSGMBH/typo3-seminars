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
 * @subpackage seminars
 *
 * @author Bernd Schönbach <bernd@oliverklee.de>
 */
class tx_seminars_Model_BackEndUserTest extends tx_phpunit_testcase {
	/**
	 * @var tx_seminars_Model_BackEndUser
	 */
	private $fixture;

	protected function setUp() {
		$this->fixture = new tx_seminars_Model_BackEndUser();
	}

	/////////////////////////////////////////////
	// Tests concerning getEventFolderFromGroup
	/////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getEventFolderFromGroupForNoGroupsReturnsZero() {
		$this->fixture->setData(array('usergroup' => new tx_oelib_List()));

		$this->assertEquals(
			0,
			$this->fixture->getEventFolderFromGroup()
		);
	}

	/**
	 * @test
	 */
	public function getEventFolderFromGroupForOneGroupWithoutEventPidReturnsZero() {
		$group = tx_oelib_MapperRegistry::
			get('tx_seminars_Mapper_BackEndUserGroup')->getLoadedTestingModel(array());
		$groups = new tx_oelib_List();
		$groups->add($group);
		$this->fixture->setData(array('usergroup' => $groups));

		$this->assertEquals(
			0,
			$this->fixture->getEventFolderFromGroup()
		);
	}

	/**
	 * @test
	 */
	public function getEventFolderFromGroupForOneGroupWithEventPidReturnsThisPid() {
		$group = tx_oelib_MapperRegistry::
			get('tx_seminars_Mapper_BackEndUserGroup')->getLoadedTestingModel(
				array('tx_seminars_events_folder' => 42)
		);
		$groups = new tx_oelib_List();
		$groups->add($group);
		$this->fixture->setData(array('usergroup' => $groups));

		$this->assertEquals(
			42,
			$this->fixture->getEventFolderFromGroup()
		);
	}

	/**
	 * @test
	 */
	public function getEventFolderFromGroupForTwoGroupsBothWithDifferentEventPidsReturnsOnlyOneOfThePids() {
		$group1 = tx_oelib_MapperRegistry::
			get('tx_seminars_Mapper_BackEndUserGroup')->getLoadedTestingModel(
				array('tx_seminars_events_folder' => 23)
		);
		$group2 = tx_oelib_MapperRegistry::
			get('tx_seminars_Mapper_BackEndUserGroup')->getLoadedTestingModel(
				array('tx_seminars_events_folder' => 42)
		);
		$groups = new tx_oelib_List();
		$groups->add($group1);
		$groups->add($group2);
		$this->fixture->setData(array('usergroup' => $groups));
		$eventFolder = $this->fixture->getEventFolderFromGroup();

		$this->assertTrue(
			(($eventFolder == 23) || ($eventFolder == 42))
		);
	}


	////////////////////////////////////////////////////
	// Tests concerning getRegistrationFolderFromGroup
	////////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getRegistrationFolderFromGroupForNoGroupsReturnsZero() {
		$this->fixture->setData(array('usergroup' => new tx_oelib_List()));

		$this->assertEquals(
			0,
			$this->fixture->getRegistrationFolderFromGroup()
		);
	}

	/**
	 * @test
	 */
	public function getRegistrationFolderFromGroupForOneGroupWithoutRegistrationPidReturnsZero() {
		$group = tx_oelib_MapperRegistry::
			get('tx_seminars_Mapper_BackEndUserGroup')->getLoadedTestingModel(array());
		$groups = new tx_oelib_List();
		$groups->add($group);
		$this->fixture->setData(array('usergroup' => $groups));

		$this->assertEquals(
			0,
			$this->fixture->getRegistrationFolderFromGroup()
		);
	}

	/**
	 * @test
	 */
	public function getRegistrationFolderFromGroupForOneGroupWithRegistrationPidReturnsThisPid() {
		$group = tx_oelib_MapperRegistry::
			get('tx_seminars_Mapper_BackEndUserGroup')->getLoadedTestingModel(
				array('tx_seminars_registrations_folder' => 42)
		);
		$groups = new tx_oelib_List();
		$groups->add($group);
		$this->fixture->setData(array('usergroup' => $groups));

		$this->assertEquals(
			42,
			$this->fixture->getRegistrationFolderFromGroup()
		);
	}

	/**
	 * @test
	 */
	public function getRegistrationFolderFromGroupForTwoGroupsBothWithDifferentRegistrationPidsReturnsOnlyOneOfThePids() {
		$group1 = tx_oelib_MapperRegistry::
			get('tx_seminars_Mapper_BackEndUserGroup')->getLoadedTestingModel(
				array('tx_seminars_registrations_folder' => 23)
		);
		$group2 = tx_oelib_MapperRegistry::
			get('tx_seminars_Mapper_BackEndUserGroup')->getLoadedTestingModel(
				array('tx_seminars_registrations_folder' => 42)
		);
		$groups = new tx_oelib_List();
		$groups->add($group1);
		$groups->add($group2);
		$this->fixture->setData(array('usergroup' => $groups));
		$eventFolder = $this->fixture->getRegistrationFolderFromGroup();

		$this->assertTrue(
			(($eventFolder == 23) || ($eventFolder == 42))
		);
	}


	///////////////////////////////////////////////
	// Tests concerning getAuxiliaryRecordsFolder
	///////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getAuxiliaryRecordsFolderForNoGroupsReturnsZero() {
		$this->fixture->setData(array('usergroup' => new tx_oelib_List()));

		$this->assertEquals(
			0,
			$this->fixture->getAuxiliaryRecordsFolder()
		);
	}

	/**
	 * @test
	 */
	public function getAuxiliaryRecordsFolderForOneGroupWithoutAuxiliaryRecordPidReturnsZero() {
		$group = tx_oelib_MapperRegistry::
			get('tx_seminars_Mapper_BackEndUserGroup')->getLoadedTestingModel(array());
		$groups = new tx_oelib_List();
		$groups->add($group);
		$this->fixture->setData(array('usergroup' => $groups));

		$this->assertEquals(
			0,
			$this->fixture->getAuxiliaryRecordsFolder()
		);
	}

	/**
	 * @test
	 */
	public function getAuxiliaryRecordsFolderForOneGroupWithAuxiliaryRecordsPidReturnsThisPid() {
		$group = tx_oelib_MapperRegistry::
			get('tx_seminars_Mapper_BackEndUserGroup')->getLoadedTestingModel(
				array('tx_seminars_auxiliaries_folder' => 42)
		);
		$groups = new tx_oelib_List();
		$groups->add($group);
		$this->fixture->setData(array('usergroup' => $groups));

		$this->assertEquals(
			42,
			$this->fixture->getAuxiliaryRecordsFolder()
		);
	}

	/**
	 * @test
	 */
	public function getAuxiliaryRecordsFolderForTwoGroupsBothWithDifferentAuxiliaryRecordPidsReturnsOnlyOneOfThePids() {
		$group1 = tx_oelib_MapperRegistry::
			get('tx_seminars_Mapper_BackEndUserGroup')->getLoadedTestingModel(
				array('tx_seminars_auxiliaries_folder' => 23)
		);
		$group2 = tx_oelib_MapperRegistry::
			get('tx_seminars_Mapper_BackEndUserGroup')->getLoadedTestingModel(
				array('tx_seminars_auxiliaries_folder' => 42)
		);
		$groups = new tx_oelib_List();
		$groups->add($group1);
		$groups->add($group2);
		$this->fixture->setData(array('usergroup' => $groups));
		$eventFolder = $this->fixture->getAuxiliaryRecordsFolder();

		$this->assertTrue(
			(($eventFolder == 23) || ($eventFolder == 42))
		);
	}
}