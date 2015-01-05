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
class tx_seminars_Service_EMailSalutationTest extends tx_phpunit_testcase {
	/**
	 * @var tx_oelib_testingFramework the testing framework
	 */
	private $testingFramework;

	/**
	 * @var tx_seminars_EmailSalutation the fixture the tests relate to
	 */
	private $fixture;

	/**
	 * @var array backed-up extension configuration of the TYPO3 configuration
	 *            variables
	 */
	private $extConfBackup = array();

	/**
	 * @var array backed-up T3_VAR configuration
	 */
	private $t3VarBackup = array();

	protected function setUp() {
		$this->testingFramework = new tx_oelib_testingFramework('tx_seminars');
		$this->fixture = new tx_seminars_EmailSalutation();
		$configuration = new tx_oelib_Configuration();
		$configuration->setAsString('salutation', 'formal');
		tx_oelib_ConfigurationRegistry::getInstance()
			->set('plugin.tx_seminars', $configuration);
		$this->extConfBackup = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'];
		$this->t3VarBackup = $GLOBALS['T3_VAR']['getUserObj'];
	}

	protected function tearDown() {
		$this->testingFramework->cleanUp();
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'] = $this->extConfBackup;
		$GLOBALS['T3_VAR']['getUserObj'] = $this->t3VarBackup;
	}


	//////////////////////
	// Utility functions
	//////////////////////

	/**
	 * Creates an FE-user with the given gender and the name "Foo".
	 *
	 * @param int $gender
	 *        the gender for the FE user, must be one of
	 *        "tx_oelib_Model_FrontEndUser::GENDER_MALE",
	 *        "tx_oelib_Model_FrontEndUser::GENDER_FEMALE" or
	 *        "tx_oelib_Model_FrontEndUser::GENDER_UNKNOWN", may be empty
	 *
	 * @return tx_seminars_Model_FrontEndUser the loaded testing model of a
	 *                                        FE user
	 */
	private function createFrontEndUser(
		$gender = tx_oelib_Model_FrontEndUser::GENDER_MALE
	) {
		return tx_oelib_MapperRegistry::get('tx_seminars_Mapper_FrontEndUser')
			->getLoadedTestingModel(
				array('name' => 'Foo', 'gender' => $gender)
		);
	}

	/**
	 * Checks whether the FrontEndUser.gender fields exists and  marks the test as skipped if that extension is not installed.
	 *
	 * @return void
	 */
	protected function skipWithoutGenderField() {
		if (!Tx_Oelib_Model_FrontEndUser::hasGenderField()) {
			$this->markTestSkipped(
				'This test is skipped because it requires FE user to have a gender field, e.g., ' .
					'from the sr_feuser_register extension.'
			);
		}
	}

	///////////////////////////////////////////
	// Tests concerning the utility functions
	///////////////////////////////////////////

	/**
	 * @test
	 */
	public function createFrontEndUserReturnsFeUserModel() {
		$this->assertTrue(
			$this->createFrontEndUser() instanceof tx_seminars_Model_FrontEndUser
		);
	}

	/**
	 * @test
	 */
	public function createFrontEndUserForGivenGenderAssignsGenderToFrontEndUser() {
		$this->skipWithoutGenderField();

		$this->assertSame(
			tx_oelib_Model_FrontEndUser::GENDER_FEMALE,
			$this->createFrontEndUser(tx_oelib_Model_FrontEndUser::GENDER_FEMALE)->getGender()
		);
	}


	///////////////////////////////////
	// Tests concerning getSalutation
	///////////////////////////////////

	/**
	 * @test
	 */
	public function getSalutationReturnsUsernameOfRegistration() {
		$this->assertContains(
			'Foo',
			$this->fixture->getSalutation($this->createFrontEndUser())
		);
	}

	/**
	 * @test
	 */
	public function getSalutationForMaleUserReturnsMaleSalutation() {
		$this->skipWithoutGenderField();

		$user = $this->createFrontEndUser(tx_oelib_Model_FrontEndUser::GENDER_MALE);

		$this->assertContains(
			tx_oelib_TranslatorRegistry::getInstance()->get('seminars')->translate('email_hello_formal_0'),
			$this->fixture->getSalutation($user)
		);
	}

	/**
	 * @test
	 */
	public function getSalutationForMaleUserReturnsUsersNameWithGenderSpecificTitle() {
		$this->skipWithoutGenderField();

		$user = $this->createFrontEndUser(tx_oelib_Model_FrontEndUser::GENDER_MALE);

		$this->assertContains(
			tx_oelib_TranslatorRegistry::getInstance()->get('seminars')->translate('email_salutation_title_0') .
				' ' . $user->getLastOrFullName(),
			$this->fixture->getSalutation($user)
		);
	}

	/**
	 * @test
	 */
	public function getSalutationForFemaleUserReturnsFemaleSalutation() {
		$this->skipWithoutGenderField();

		$user = $this->createFrontEndUser(tx_oelib_Model_FrontEndUser::GENDER_FEMALE);

		$this->assertContains(
			tx_oelib_TranslatorRegistry::getInstance()->get('seminars')
				->translate('email_hello_formal_1'),
			$this->fixture->getSalutation($user)
		);
	}

	/**
	 * @test
	 */
	public function getSalutationForFemaleUserReturnsUsersNameWithGenderSpecificTitle() {
		$this->skipWithoutGenderField();

		$user = $this->createFrontEndUser(tx_oelib_Model_FrontEndUser::GENDER_FEMALE);

		$this->assertContains(
			tx_oelib_TranslatorRegistry::getInstance()->get('seminars')->translate('email_salutation_title_1') .
				' ' . $user->getLastOrFullName(),
			$this->fixture->getSalutation($user)
		);
	}

	/**
	 * @test
	 */
	public function getSalutationForUnknownUserReturnsUnknownSalutation() {
		$user = $this->createFrontEndUser(
			tx_oelib_Model_FrontEndUser::GENDER_UNKNOWN
		);

		$this->assertContains(
			tx_oelib_TranslatorRegistry::getInstance()->get('seminars')
				->translate('email_hello_formal_99'),
			$this->fixture->getSalutation($user)
		);
	}

	/**
	 * @test
	 */
	public function getSalutationForUnknownUserReturnsUsersNameWithGenderSpecificTitle() {
		$user = $this->createFrontEndUser(
			tx_oelib_Model_FrontEndUser::GENDER_UNKNOWN
		);

		$this->assertContains(
			tx_oelib_TranslatorRegistry::getInstance()->get('seminars')
				->translate('email_salutation_title_99') . ' ' .
				$user->getLastOrFullName(),
			$this->fixture->getSalutation($user)
		);
	}

	/**
	 * @test
	 */
	public function getSalutationForInformalSalutationReturnsInformalSalutation() {
		$user = $this->createFrontEndUser();
		tx_oelib_ConfigurationRegistry::get('plugin.tx_seminars')
			->setAsString('salutation', 'informal');

		$this->assertContains(
			tx_oelib_TranslatorRegistry::getInstance()->get('seminars')
					->translate('email_hello_informal'),
			$this->fixture->getSalutation($user)
		);
	}

	/**
	 * @test
	 */
	public function getSalutationForInformalSalutationReturnsUsersName() {
		$user = $this->createFrontEndUser();
		tx_oelib_ConfigurationRegistry::get('plugin.tx_seminars')
			->setAsString('salutation', 'informal');

		$this->assertContains(
			$user->getLastOrFullName(),
			$this->fixture->getSalutation($user)
		);
	}


	///////////////////////////////
	// Tests concerning the hooks
	///////////////////////////////

	/**
	 * @test
	 */
	public function getSalutationForHookSetInConfigurationCallsThisHook() {
		$hookClassName = uniqid('tx_salutationHook');
		$salutationHookMock = $this->getMock(
			$hookClassName, array('modifySalutation')
		);
		$salutationHookMock->expects($this->atLeastOnce())
			->method('modifySalutation');

		$GLOBALS['T3_VAR']['getUserObj'][$hookClassName] = $salutationHookMock;
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['seminars']
			['modifyEmailSalutation'][$hookClassName] = $hookClassName;

		$this->fixture->getSalutation($this->createFrontEndUser());
	}

	/**
	 * @test
	 */
	public function getSalutationCanCallMultipleSetHooks() {
		$hookClassName1 = uniqid('tx_salutationHook1');
		$salutationHookMock1 = $this->getMock(
			$hookClassName1, array('modifySalutation')
		);
		$salutationHookMock1->expects($this->atLeastOnce())
			->method('modifySalutation');
		$GLOBALS['T3_VAR']['getUserObj'][$hookClassName1] = $salutationHookMock1;
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['seminars']
			['modifyEmailSalutation'][$hookClassName1] = $hookClassName1;

		$hookClassName2 = uniqid('tx_salutationHook2');
		$salutationHookMock2 = $this->getMock(
			$hookClassName2, array('modifySalutation')
		);
		$salutationHookMock2->expects($this->atLeastOnce())
			->method('modifySalutation');
		$GLOBALS['T3_VAR']['getUserObj'][$hookClassName2] = $salutationHookMock2;
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['seminars']
			['modifyEmailSalutation'][$hookClassName2] = $hookClassName2;

		$this->fixture->getSalutation($this->createFrontEndUser());
	}


	////////////////////////////////////////
	// Tests concerning createIntroduction
	////////////////////////////////////////

	/**
	 * @test
	 */
	public function createIntroductionForEventWithDateReturnsEventsDate() {
		$dateFormatYMD = '%d.%m.%Y';
		$eventUid = $this->testingFramework->createRecord(
			'tx_seminars_seminars',
			array('begin_date' => $GLOBALS['SIM_EXEC_TIME'])
		);

		$event = new tx_seminars_seminarchild($eventUid, array(
			'dateFormatYMD' => $dateFormatYMD
		));

		$this->assertContains(
			strftime($dateFormatYMD, $GLOBALS['SIM_EXEC_TIME']),
			$this->fixture->createIntroduction('%s', $event)
		);
	}

	/**
	 * @test
	 */
	public function createIntroductionForEventWithBeginAndEndDateOnDifferentDaysReturnsEventsDateFromTo() {
		$dateFormatYMD = '%d.%m.%Y';
		$dateFormatD = '%d';
		$eventUid = $this->testingFramework->createRecord(
			'tx_seminars_seminars',
			array(
				'begin_date' => $GLOBALS['SIM_EXEC_TIME'],
				'end_date' => $GLOBALS['SIM_EXEC_TIME'] + tx_oelib_Time::SECONDS_PER_DAY,
			)
		);

		$event = new tx_seminars_seminarchild($eventUid, array(
			'dateFormatYMD' => $dateFormatYMD,
			'dateFormatD' => $dateFormatD,
			'abbreviateDateRanges' => 1,
		));

		$this->assertContains(
			strftime($dateFormatD, $GLOBALS['SIM_EXEC_TIME']) .
				'-' .
				strftime($dateFormatYMD, $GLOBALS['SIM_EXEC_TIME'] + tx_oelib_Time::SECONDS_PER_DAY),
			$this->fixture->createIntroduction('%s', $event)
		);
	}

	/**
	 * @test
	 */
	public function createIntroductionForEventWithTimeReturnsEventsTime() {
		$timeFormat = '%H:%M';
		$eventUid = $this->testingFramework->createRecord(
			'tx_seminars_seminars',
			array(
				'begin_date' => $GLOBALS['SIM_EXEC_TIME'],
			)
		);

		$event = new tx_seminars_seminarchild($eventUid, array(
			'timeFormat' => $timeFormat,
		));

		$this->assertContains(
			strftime($timeFormat, $GLOBALS['SIM_EXEC_TIME']),
			$this->fixture->createIntroduction('%s', $event)
		);
	}

	/**
	 * @test
	 */
	public function createIntroductionForEventWithStartAndEndOnOneDayReturnsTimeFromTo() {
		$timeFormat = '%H:%M';
		$endDate = $GLOBALS['SIM_EXEC_TIME'] + 3600;
		$eventUid = $this->testingFramework->createRecord(
			'tx_seminars_seminars',
			array(
				'begin_date' => $GLOBALS['SIM_EXEC_TIME'],
				'end_date' => $endDate,
			)
		);

		$event = new tx_seminars_seminarchild($eventUid, array(
			'timeFormat' => $timeFormat,
		));
		$translator = tx_oelib_TranslatorRegistry::getInstance()->get('seminars');
		$timeInsert = strftime($timeFormat, $GLOBALS['SIM_EXEC_TIME']) . ' ' .
			$translator->translate('email_timeTo') . ' ' .
			strftime($timeFormat, $endDate);

		$this->assertContains(
			sprintf(
				$translator->translate('email_timeFrom'),
				$timeInsert
			),
			$this->fixture->createIntroduction('%s', $event)
		);
	}
}