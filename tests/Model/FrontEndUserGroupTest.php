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
 * @author Niels Pardon <mail@niels-pardon.de>
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class tx_seminars_Model_FrontEndUserGroupTest extends tx_phpunit_testcase {
	/**
	 * @var tx_seminars_Model_FrontEndUserGroup the object to test
	 */
	private $fixture;

	protected function setUp() {
		$this->fixture = new tx_seminars_Model_FrontEndUserGroup();
	}

	///////////////////////////////////////
	// Tests concerning getPublishSetting
	///////////////////////////////////////

	/**
	 * @test
	 */
	public function getPublishSettingWithoutPublishSettingReturnsPublishAll() {
		$this->fixture->setData(array());

		$this->assertEquals(
			tx_seminars_Model_FrontEndUserGroup::PUBLISH_IMMEDIATELY,
			$this->fixture->getPublishSetting()
		);
	}

	/**
	 * @test
	 */
	public function getPublishSettingWithPublishSettingSetToZeroReturnsPublishAll() {
		$this->fixture->setData(array('tx_seminars_publish_events' => 0));

		$this->assertEquals(
			tx_seminars_Model_FrontEndUserGroup::PUBLISH_IMMEDIATELY,
			$this->fixture->getPublishSetting()
		);
	}

	/**
	 * @test
	 */
	public function getPublishSettingWithPublishSettingSetToOneReturnsHideNew() {
		$this->fixture->setData(array('tx_seminars_publish_events' => 1));

		$this->assertEquals(
			tx_seminars_Model_FrontEndUserGroup::PUBLISH_HIDE_NEW,
			$this->fixture->getPublishSetting()
		);
	}

	/**
	 * @test
	 */
	public function getPublishSettingWithPublishSettingSetToTwoReturnsHideEdited() {
		$this->fixture->setData(array('tx_seminars_publish_events' => 2));

		$this->assertEquals(
			tx_seminars_Model_FrontEndUserGroup::PUBLISH_HIDE_EDITED,
			$this->fixture->getPublishSetting()
		);
	}


	///////////////////////////////////////////////
	// Tests concerning getAuxiliaryRecordsPid().
	///////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getAuxiliaryRecordsPidWithoutPidReturnsZero() {
		$this->fixture->setData(array());

		$this->assertEquals(
			0,
			$this->fixture->getAuxiliaryRecordsPid()
		);
	}

	/**
	 * @test
	 */
	public function getAuxiliaryRecordsPidWithPidReturnsPid() {
		$this->fixture->setData(array('tx_seminars_auxiliary_records_pid' => 42));

		$this->assertEquals(
			42,
			$this->fixture->getAuxiliaryRecordsPid()
		);
	}


	///////////////////////////////////////////////
	// Tests concerning hasAuxiliaryRecordsPid().
	///////////////////////////////////////////////

	/**
	 * @test
	 */
	public function hasAuxiliaryRecordsPidWithoutPidReturnsFalse() {
		$this->fixture->setData(array());

		$this->assertFalse(
			$this->fixture->hasAuxiliaryRecordsPid()
		);
	}

	/**
	 * @test
	 */
	public function hasAuxiliaryRecordsPidWithPidReturnsTrue() {
		$this->fixture->setData(array('tx_seminars_auxiliary_records_pid' => 42));

		$this->assertTrue(
			$this->fixture->hasAuxiliaryRecordsPid()
		);
	}


	//////////////////////////////////
	// Tests concerning the reviewer
	//////////////////////////////////

	/**
	 * @test
	 */
	public function hasReviewerForGroupWithoutReviewerReturnsFalse() {
		$this->fixture->setData(array('tx_seminars_reviewer' => NULL));

		$this->assertFalse(
			$this->fixture->hasReviewer()
		);
	}

	/**
	 * @test
	 */
	public function hasReviewerForGroupWithReviewerReturnsTrue() {
		$backEndUser = new tx_oelib_Model_BackEndUser();

		$this->fixture->setData(array('tx_seminars_reviewer' => $backEndUser));

		$this->assertTrue(
			$this->fixture->hasReviewer()
		);
	}

	/**
	 * @test
	 */
	public function getReviewerForGroupWithoutReviewerReturnsNull() {
		$this->fixture->setData(array('tx_seminars_reviewer' => NULL));

		$this->assertNull(
			$this->fixture->getReviewer()
		);
	}

	/**
	 * @test
	 */
	public function getReviewerForGroupWithReviewerReturnsReviewer() {
		$backEndUser = new tx_oelib_Model_BackEndUser();

		$this->fixture->setData(array('tx_seminars_reviewer' => $backEndUser));

		$this->assertSame(
			$backEndUser,
			$this->fixture->getReviewer()
		);
	}


	//////////////////////////////////////////////////
	// Tests concerning the event record storage PID
	//////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function hasEventRecordPidForNoPidSetReturnsFalse() {
		$this->fixture->setData(array());

		$this->assertFalse(
			$this->fixture->hasEventRecordPid()
		);
	}

	/**
	 * @test
	 */
	public function hasEventRecordPidForPidSetReturnsTrue() {
		$this->fixture->setData(array('tx_seminars_events_pid' => 42));

		$this->assertTrue(
			$this->fixture->hasEventRecordPid()
		);
	}

	/**
	 * @test
	 */
	public function getEventRecordPidForNoPidSetReturnsZero() {
		$this->fixture->setData(array());

		$this->assertEquals(
			0,
			$this->fixture->getEventRecordPid()
		);
	}

	/**
	 * @test
	 */
	public function getEventRecordPidForPidSetReturnsThisPid() {
		$this->fixture->setData(array('tx_seminars_events_pid' => 42));

		$this->assertEquals(
			42,
			$this->fixture->getEventRecordPid()
		);
	}

	//////////////////////////////////////////
	// Tests concerning getDefaultCategories
	//////////////////////////////////////////

	/**
	 * @test
	 */
	public function getDefaultCategoriesForNoCategoriesReturnsAList() {
		$this->fixture->setData(array('tx_seminars_default_categories' => new tx_oelib_List()));

		$this->assertTrue(
			$this->fixture->getDefaultCategories() instanceOf tx_oelib_List
		);
	}

	/**
	 * @test
	 */
	public function getDefaultCategoriesForOneAssignedCategoryReturnsThisCategoryInList() {
		$list = new tx_oelib_List();
		$category = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Category')
			->getNewGhost();

		$list->add($category);
		$this->fixture->setData(array('tx_seminars_default_categories' => $list));

		$this->assertSame(
			$category,
			$this->fixture->getDefaultCategories()->first()
		);
	}


	//////////////////////////////////////////
	// Tests concerning hasDefaultCategories
	//////////////////////////////////////////

	/**
	 * @test
	 */
	public function hasDefaultCategoriesForNoAssignedCategoriesReturnsFalse() {
		$this->fixture->setData(array('tx_seminars_default_categories' => new tx_oelib_List()));

		$this->assertFalse(
			$this->fixture->hasDefaultCategories()
		);
	}

	/**
	 * @test
	 */
	public function hasDefaultCategoriesForOneAssignedCategoryReturnsTrue() {
		$list = new tx_oelib_List();
		$list->add(
			tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Category')
				->getNewGhost()
		);

		$this->fixture->setData(array('tx_seminars_default_categories' => $list));

		$this->assertTrue(
			$this->fixture->hasDefaultCategories()
		);
	}


	/////////////////////////////////////////////////////////////////
	// Tests concerning getDefaultOrganizer and hasDefaultOrganizer
	/////////////////////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getDefaultOrganizerForSetOrganizerReturnsIt() {
		$organizer = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Organizer')
			->getNewGhost();
		$this->fixture->setData(array('tx_seminars_default_organizer' => $organizer));

		$this->assertSame(
			$organizer,
			$this->fixture->getDefaultOrganizer()
		);
	}

	/**
	 * @test
	 */
	public function hasDefaultOrganizerForSetOrganizerReturnsTrue() {
		$organizer = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Organizer')
			->getNewGhost();
		$this->fixture->setData(array('tx_seminars_default_organizer' => $organizer));

		$this->assertTrue(
			$this->fixture->hasDefaultOrganizer()
		);
	}

	/**
	 * @test
	 */
	public function hasDefaultOrganizerForNotSetOrganizerReturnsFalse() {
		$this->fixture->setData(array('tx_seminars_default_organizer' => NULL));

		$this->assertFalse(
			$this->fixture->hasDefaultOrganizer()
		);
	}
}