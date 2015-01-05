<?php
/***************************************************************
* Copyright notice
*
* (c) 2009-2013 Niels Pardon (mail@niels-pardon.de)
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
 * @author Niels Pardon <mail@niels-pardon.de>
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class tx_seminars_Mapper_EventTest extends tx_phpunit_testcase {
	/**
	 * @var tx_oelib_testingFramework
	 */
	private $testingFramework;

	/**
	 * @var tx_seminars_Mapper_Event
	 */
	private $fixture;

	protected function setUp() {
		$this->testingFramework = new tx_oelib_testingFramework('tx_seminars');
		tx_oelib_MapperRegistry::getInstance()->activateTestingMode($this->testingFramework);

		$this->fixture = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Event');
	}

	protected function tearDown() {
		$this->testingFramework->cleanUp();
	}


	//////////////////////////
	// Tests regarding find
	//////////////////////////

	/**
	 * @test
	 */
	public function findWithUidReturnsEventInstance() {
		$this->assertTrue(
			$this->fixture->find(1) instanceof tx_seminars_Model_Event
		);
	}

	/**
	 * @test
	 */
	public function findWithUidOfExistingRecordReturnsRecordAsModel() {
		$uid = $this->testingFramework->createRecord(
			'tx_seminars_seminars', array('title' => 'Big event')
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertEquals(
			'Big event',
			$model->getTitle()
		);
	}


	////////////////////////////////////
	// Tests regarding getTimeSlots().
	////////////////////////////////////

	/**
	 * @test
	 */
	public function getTimeSlotsReturnsListInstance() {
		$this->assertTrue(
			$this->fixture->getLoadedTestingModel(array())->getTimeSlots()
			instanceof tx_oelib_List
		);
	}

	/**
	 * @test
	 */
	public function getTimeSlotsWithOneTimeSlotReturnsListOfTimeSlots() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$timeSlotUid = $this->testingFramework->createRecord(
			'tx_seminars_timeslots', array('seminar' => $uid)
		);
		$this->testingFramework->changeRecord(
			'tx_seminars_seminars', $uid, array('timeslots' => $timeSlotUid)
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertTrue(
			$model->getTimeSlots()->first() instanceof tx_seminars_Model_TimeSlot
		);
	}

	/**
	 * @test
	 */
	public function getTimeSlotsWithOneTimeSlotReturnsOneTimeSlot() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$timeSlotUid = $this->testingFramework->createRecord(
			'tx_seminars_timeslots', array('seminar' => $uid)
		);
		$this->testingFramework->changeRecord(
			'tx_seminars_seminars', $uid, array('timeslots' => $timeSlotUid)
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertEquals(
			$timeSlotUid,
			$model->getTimeSlots()->getUids()
		);
	}


	/////////////////////////////////
	// Tests regarding getPlaces().
	/////////////////////////////////

	/**
	 * @test
	 */
	public function getPlacesReturnsListInstance() {
		$this->assertTrue(
			$this->fixture->getLoadedTestingModel(array())->getPlaces()
			instanceof tx_oelib_List
		);
	}

	/**
	 * @test
	 */
	public function getPlacesWithOnePlaceReturnsListOfPlaces() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$place = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Place')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $place->getUid(), 'place'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertTrue(
			$model->getPlaces()->first() instanceof tx_seminars_Model_Place
		);
	}

	/**
	 * @test
	 */
	public function getPlacesWithOnePlaceReturnsOnePlace() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$place = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Place')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $place->getUid(), 'place'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertEquals(
			$place->getUid(),
			$model->getPlaces()->getUids()
		);
	}


	///////////////////////////////////
	// Tests regarding getLodgings().
	///////////////////////////////////

	/**
	 * @test
	 */
	public function getLodgingsReturnsListInstance() {
		$this->assertTrue(
			$this->fixture->getLoadedTestingModel(array())->getLodgings()
			instanceof tx_oelib_List
		);
	}

	/**
	 * @test
	 */
	public function getLodgingsWithOneLodgingReturnsListOfLodgings() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$lodging = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Lodging')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $lodging->getUid(), 'lodgings'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertTrue(
			$model->getLodgings()->first() instanceof tx_seminars_Model_Lodging
		);
	}

	/**
	 * @test
	 */
	public function getLodgingsWithOneLodgingReturnsOneLodging() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$lodging = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Lodging')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $lodging->getUid(), 'lodgings'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertEquals(
			$lodging->getUid(),
			$model->getLodgings()->getUids()
		);
	}


	////////////////////////////////
	// Tests regarding getFoods().
	////////////////////////////////

	/**
	 * @test
	 */
	public function getFoodsReturnsListInstance() {
		$this->assertTrue(
			$this->fixture->getLoadedTestingModel(array())->getFoods()
			instanceof tx_oelib_List
		);
	}

	/**
	 * @test
	 */
	public function getFoodsWithOneFoodReturnsListOfFoods() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$food = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Food')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $food->getUid(), 'foods'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertTrue(
			$model->getFoods()->first() instanceof tx_seminars_Model_Food
		);
	}

	/**
	 * @test
	 */
	public function getFoodsWithOneFoodReturnsOneFood() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$food = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Food')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $food->getUid(), 'foods'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertEquals(
			$food->getUid(),
			$model->getFoods()->getUids()
		);
	}


	///////////////////////////////////
	// Tests regarding getSpeakers().
	///////////////////////////////////

	/**
	 * @test
	 */
	public function getSpeakersReturnsListInstance() {
		$this->assertTrue(
			$this->fixture->getLoadedTestingModel(array())->getSpeakers()
			instanceof tx_oelib_List
		);
	}

	/**
	 * @test
	 */
	public function getSpeakersWithOneSpeakerReturnsListOfSpeakers() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$speaker = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Speaker')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $speaker->getUid(), 'speakers'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertTrue(
			$model->getSpeakers()->first() instanceof tx_seminars_Model_Speaker
		);
	}

	/**
	 * @test
	 */
	public function getSpeakersWithOneSpeakerReturnsOneSpeaker() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$speaker = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Speaker')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $speaker->getUid(), 'speakers'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertEquals(
			$speaker->getUid(),
			$model->getSpeakers()->getUids()
		);
	}


	///////////////////////////////////
	// Tests regarding getPartners().
	///////////////////////////////////

	/**
	 * @test
	 */
	public function getPartnersReturnsListInstance() {
		$this->assertTrue(
			$this->fixture->getLoadedTestingModel(array())->getPartners()
			instanceof tx_oelib_List
		);
	}

	/**
	 * @test
	 */
	public function getPartnersWithOnePartnerReturnsListOfSpeakers() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$speaker = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Speaker')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $speaker->getUid(), 'partners'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertTrue(
			$model->getPartners()->first() instanceof tx_seminars_Model_Speaker
		);
	}

	/**
	 * @test
	 */
	public function getPartnersWithOnePartnerReturnsOnePartner() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$speaker = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Speaker')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $speaker->getUid(), 'partners'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertEquals(
			$speaker->getUid(),
			$model->getPartners()->getUids()
		);
	}


	///////////////////////////////////
	// Tests regarding getTutors().
	///////////////////////////////////

	/**
	 * @test
	 */
	public function getTutorsReturnsListInstance() {
		$this->assertTrue(
			$this->fixture->getLoadedTestingModel(array())->getTutors()
			instanceof tx_oelib_List
		);
	}

	/**
	 * @test
	 */
	public function getTutorsWithOneTutorReturnsListOfSpeakers() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$speaker = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Speaker')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $speaker->getUid(), 'tutors'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertTrue(
			$model->getTutors()->first() instanceof tx_seminars_Model_Speaker
		);
	}

	/**
	 * @test
	 */
	public function getTutorsWithOneTutorReturnsOneTutor() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$speaker = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Speaker')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $speaker->getUid(), 'tutors'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertEquals(
			$speaker->getUid(),
			$model->getTutors()->getUids()
		);
	}


	///////////////////////////////////
	// Tests regarding getLeaders().
	///////////////////////////////////

	/**
	 * @test
	 */
	public function getLeadersReturnsListInstance() {
		$this->assertTrue(
			$this->fixture->getLoadedTestingModel(array())->getLeaders()
			instanceof tx_oelib_List
		);
	}

	/**
	 * @test
	 */
	public function getLeadersWithOneLeaderReturnsListOfSpeakers() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$speaker = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Speaker')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $speaker->getUid(), 'leaders'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertTrue(
			$model->getLeaders()->first() instanceof tx_seminars_Model_Speaker
		);
	}

	/**
	 * @test
	 */
	public function getLeadersWithOneLeaderReturnsOneLeader() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$speaker = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Speaker')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $speaker->getUid(), 'leaders'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertEquals(
			$speaker->getUid(),
			$model->getLeaders()->getUids()
		);
	}


	/////////////////////////////////////
	// Tests regarding getOrganizers().
	/////////////////////////////////////

	/**
	 * @test
	 */
	public function getOrganizersReturnsListInstance() {
		$this->assertTrue(
			$this->fixture->getLoadedTestingModel(array())->getOrganizers()
			instanceof tx_oelib_List
		);
	}

	/**
	 * @test
	 */
	public function getOrganizersWithOneOrganizerReturnsListOfOrganizers() {
		$uid = $this->testingFramework->createRecord(
			'tx_seminars_seminars', array('organizers' => 1)
		);
		$organizer = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Organizer')
			->getNewGhost();
		$this->testingFramework->createRelation(
			'tx_seminars_seminars_organizers_mm', $uid, $organizer->getUid()
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertTrue(
			$model->getOrganizers()->first() instanceof tx_seminars_Model_Organizer
		);
	}

	/**
	 * @test
	 */
	public function getOrganizersWithOneOrganizerReturnsOneOrganizer() {
		$uid = $this->testingFramework->createRecord(
			'tx_seminars_seminars', array('organizers' => 1)
		);
		$organizer = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Organizer')
			->getNewGhost();
		$this->testingFramework->createRelation(
			'tx_seminars_seminars_organizers_mm', $uid, $organizer->getUid()
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertEquals(
			$organizer->getUid(),
			$model->getOrganizers()->getUids()
		);
	}


	/////////////////////////////////////////////
	// Tests regarding getOrganizingPartners().
	/////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getOrganizingPartnersReturnsListInstance() {
		$this->assertTrue(
			$this->fixture->getLoadedTestingModel(array())->getOrganizingPartners()
				instanceof tx_oelib_List
		);
	}

	/**
	 * @test
	 */
	public function getOrganizingPartnersWithOneOrganizingReturnsListOfOrganizers() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$organizer = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Organizer')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $organizer->getUid(), 'organizing_partners'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertTrue(
			$model->getOrganizingPartners()->first() instanceof tx_seminars_Model_Organizer
		);
	}

	/**
	 * @test
	 */
	public function getOrganizingPartnersWithOneOrganizingPartnersReturnsOneOrganizingPartner() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$organizer = tx_oelib_MapperRegistry::get('tx_seminars_Mapper_Organizer')
			->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $organizer->getUid(), 'organizing_partners'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertEquals(
			$organizer->getUid(),
			$model->getOrganizingPartners()->getUids()
		);
	}



	////////////////////////////////
	// Tests regarding getOwner().
	////////////////////////////////

	/**
	 * @test
	 */
	public function getOwnerWithoutOwnerReturnsNull() {
		$this->assertNull(
			$this->fixture->getLoadedTestingModel(array())->getOwner()
		);
	}

	/**
	 * @test
	 */
	public function getOwnerWithOwnerReturnsOwnerInstance() {
		$frontEndUser = tx_oelib_MapperRegistry::
			get('tx_oelib_Mapper_FrontEndUser')->getLoadedTestingModel(array());

		$this->assertTrue(
			$this->fixture->getLoadedTestingModel(
				array('owner_feuser' => $frontEndUser->getUid())
			)->getOwner() instanceof
				tx_oelib_Model_FrontEndUser
		);
	}


	////////////////////////////////////////
	// Tests regarding getEventManagers().
	////////////////////////////////////////

	/**
	 * @test
	 */
	public function getEventManagersReturnsListInstance() {
		$this->assertTrue(
			$this->fixture->getLoadedTestingModel(array())->getEventManagers()
			instanceof tx_oelib_List
		);
	}

	/**
	 * @test
	 */
	public function getEventManagersWithOneEventManagerReturnsListOfFrontEndUsers() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$frontEndUser = tx_oelib_MapperRegistry::
			get('tx_oelib_Mapper_FrontEndUser')->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $frontEndUser->getUid(), 'vips'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertTrue(
			$model->getEventManagers()->first() instanceof tx_oelib_Model_FrontEndUser
		);
	}

	/**
	 * @test
	 */
	public function getEventManagersWithOneEventManagerReturnsOneEventManager() {
		$uid = $this->testingFramework->createRecord('tx_seminars_seminars');
		$frontEndUser = tx_oelib_MapperRegistry::
			get('tx_oelib_Mapper_FrontEndUser')->getNewGhost();
		$this->testingFramework->createRelationAndUpdateCounter(
			'tx_seminars_seminars', $uid, $frontEndUser->getUid(), 'vips'
		);

		/** @var tx_seminars_Model_Event $model */
		$model = $this->fixture->find($uid);
		$this->assertEquals(
			$frontEndUser->getUid(),
			$model->getEventManagers()->getUids()
		);
	}


	///////////////////////////////////////////
	// Tests concerning findByPublicationHash
	///////////////////////////////////////////

	/**
	 * @test
	 */
	public function findByPublicationHashForEmptyPublicationHashGivenThrowsException() {
		$this->setExpectedException(
			'InvalidArgumentException',
			'The given publication hash was empty.'
		);

		$this->fixture->findByPublicationHash('');
	}

	/**
	 * @test
	 */
	public function findByPublicationForEventWithProvidedPublicationHashReturnsThisEvent() {
		$publicationHash = 'blubb';

		$eventUid = $this->testingFramework->createRecord(
			'tx_seminars_seminars', array('publication_hash' => $publicationHash)
		);

		$this->assertEquals(
			$eventUid,
			$this->fixture->findByPublicationHash($publicationHash)->getUid()
		);
	}

	/**
	 * @test
	 */
	public function findByPublicationForNoEventWithProvidedPublicationHashReturnsNull() {
		$this->testingFramework->createRecord('tx_seminars_seminars');

		$this->assertNull(
			$this->fixture->findByPublicationHash('foo')
		);
	}

	/**
	 * @test
	 */
	public function findByPublicationForEventWithProvidedPublicationHashReturnsEventModel() {
		$publicationHash = 'blubb';

		$this->testingFramework->createRecord(
			'tx_seminars_seminars', array('publication_hash' => $publicationHash)
		);

		$this->assertTrue(
			$this->fixture->findByPublicationHash($publicationHash)
				instanceof tx_seminars_Model_Event
		);
	}


	///////////////////////////////////////
	// Tests concerning the registrations
	///////////////////////////////////////

	/**
	 * @test
	 */
	public function getRegistrationsWithOneRegistrationReturnsOneRegistration() {
		$eventUid = $this->testingFramework->createRecord(
			'tx_seminars_seminars', array('registrations' => 1)
		);
		$registrationUid = $this->testingFramework->createRecord(
			'tx_seminars_attendances', array('seminar' => $eventUid)
		);

		/** @var tx_seminars_Model_Event $event */
		$event = $this->fixture->find($eventUid);
		$this->assertEquals(
			$registrationUid,
			$event->getRegistrations()->getUids()
		);
	}


	////////////////////////////////////////
	// Tests concerning findAllByBeginDate
	////////////////////////////////////////

	/**
	 * @test
	 */
	public function findAllByBeginDateForPositiveSameMinimumAndMaximumNotThrowsException() {
		$this->fixture->findAllByBeginDate(42, 42);
	}

	/**
	 * @test
	 */
	public function findAllByBeginDateForZeroMinimumAndPositiveMaximumNotThrowsException() {
		$this->fixture->findAllByBeginDate(0, 1);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function findAllByBeginDateForZeroMinimumAndZeroMaximumThrowsException() {
		$this->fixture->findAllByBeginDate(0, 0);
	}

	/**
	 * @test
	 */
	public function findAllByBeginDateForMinimumSmallerThanMaximumNotThrowsException() {
		$this->fixture->findAllByBeginDate(1, 2);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function findAllByBeginDateForNegativeMinimumSmallerThanMaximumThrowsException() {
		$this->fixture->findAllByBeginDate(-1, 1);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function findAllByBeginDateForMinimumGreaterThanMaximumThrowsException() {
		$this->fixture->findAllByBeginDate(2, 1);
	}

	/**
	 * @test
	 */
	public function findAllByBeginDateNotFindsEventWithBeginDateSmallerThanMinimum() {
		$this->testingFramework->createRecord(
			'tx_seminars_seminars', array('begin_date' => 41)
		);

		$this->assertTrue(
			$this->fixture->findAllByBeginDate(42, 91)->isEmpty()
		);
	}

	/**
	 * @test
	 */
	public function findAllByBeginDateFindsEventWithBeginDateEqualToMinimum() {
		$uid = $this->testingFramework->createRecord(
			'tx_seminars_seminars', array('begin_date' => 42)
		);

		$this->assertTrue(
			$this->fixture->findAllByBeginDate(42, 91)->hasUid($uid)
		);
	}

	/**
	 * @test
	 */
	public function findAllByBeginDateFindsEventWithBeginDateBetweenMinimumAndMaximum() {
		$uid = $this->testingFramework->createRecord(
			'tx_seminars_seminars', array('begin_date' => 2)
		);

		$this->assertTrue(
			$this->fixture->findAllByBeginDate(1, 3)->hasUid($uid)
		);
	}

	/**
	 * @test
	 */
	public function findAllByBeginDateFindsEventWithBeginDateEqualToMaximum() {
		$uid = $this->testingFramework->createRecord(
			'tx_seminars_seminars', array('begin_date' => 91)
		);

		$this->assertTrue(
			$this->fixture->findAllByBeginDate(42, 91)->hasUid($uid)
		);
	}

	/**
	 * @test
	 */
	public function findAllByBeginDateNotFindsEventWithBeginDateGreaterThanMaximum() {
		$this->testingFramework->createRecord(
			'tx_seminars_seminars', array('begin_date' => 92)
		);

		$this->assertTrue(
			$this->fixture->findAllByBeginDate(42, 91)->isEmpty()
		);
	}

	/**
	 * @test
	 */
	public function findAllByBeginDateCanFindEventWithZeroBeginDate() {
		$uid = $this->testingFramework->createRecord(
			'tx_seminars_seminars', array('begin_date' => 0)
		);

		$this->assertTrue(
			$this->fixture->findAllByBeginDate(0, 1)->hasUid($uid)
		);
	}

	/**
	 * @test
	 */
	public function findAllByBeginDateCanFindTwoEvents() {
		$uid = $this->testingFramework->createRecord(
			'tx_seminars_seminars', array('begin_date' => 42)
		);
		$uid = $this->testingFramework->createRecord(
			'tx_seminars_seminars', array('begin_date' => 43)
		);

		$this->assertEquals(
			2,
			$this->fixture->findAllByBeginDate(42, 91)->count()
		);
	}


	//////////////////////////////////////
	// Tests concerning findNextUpcoming
	//////////////////////////////////////

	/**
	 * @test
	 * @expectedException tx_oelib_Exception_NotFound
	 */
	public function findNextUpcomingWithNoEventsThrowsEmptyQueryResultException() {
		$this->fixture->findNextUpcoming();
	}

	/**
	 * @test
	 * @expectedException tx_oelib_Exception_NotFound
	 */
	public function findNextUpcomingWithPastEventThrowsEmptyQueryResultException() {
		$this->testingFramework->createRecord(
			'tx_seminars_seminars',
			array('begin_date' => $GLOBALS['SIM_ACCESS_TIME'] - 1000)
		);

		$this->fixture->findNextUpcoming();
	}

	/**
	 * @test
	 */
	public function findNextUpcomingWithUpcomingEventReturnsModelOfUpcomingEvent() {
		$uid = $this->testingFramework->createRecord(
			'tx_seminars_seminars',
			array('begin_date' => $GLOBALS['SIM_ACCESS_TIME'] + 1000)
		);

		$this->assertSame(
			$uid,
			$this->fixture->findNextUpcoming()->getUid()
		);
	}

	/**
	 * @test
	 */
	public function findNextUpcomingWithTwoUpcomingEventsReturnsOnlyModelOfNextUpcomingEvent() {
		$this->testingFramework->createRecord(
				'tx_seminars_seminars',
				array('begin_date' => $GLOBALS['SIM_ACCESS_TIME'] + 2000)
		);
		$uid = $this->testingFramework->createRecord(
				'tx_seminars_seminars',
				array('begin_date' => $GLOBALS['SIM_ACCESS_TIME'] + 1000)
		);

		$this->assertSame(
			$uid,
			$this->fixture->findNextUpcoming()->getUid()
		);
	}
}