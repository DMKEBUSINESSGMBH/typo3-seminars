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
 */
class tx_seminars_Model_AbstractTimeSpanTest extends tx_phpunit_testcase {
	/**
	 * @var tx_seminars_tests_fixtures_TestingTimeSpan
	 */
	private $fixture;

	protected function setUp() {
		$this->fixture = new tx_seminars_tests_fixtures_TestingTimeSpan();
	}

	/**
	 * @test
	 */
	public function setTitleWithEmptyTitleThrowsException() {
		$this->setExpectedException(
			'InvalidArgumentException',
			'The parameter $title must not be empty.'
		);

		$this->fixture->setTitle('');
	}

	/**
	 * @test
	 */
	public function setTitleSetsTitle() {
		$this->fixture->setTitle('Superhero');

		$this->assertEquals(
			'Superhero',
			$this->fixture->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function getTitleWithNonEmptyTitleReturnsTitle() {
		$this->fixture->setData(array('title' => 'Superhero'));

		$this->assertEquals(
			'Superhero',
			$this->fixture->getTitle()
		);
	}


	////////////////////////////////////
	// Tests regarding the begin date.
	////////////////////////////////////

	/**
	 * @test
	 */
	public function getBeginDateAsUnixTimeStampWithoutBeginDateReturnsZero() {
		$this->fixture->setData(array());

		$this->assertEquals(
			0,
			$this->fixture->getBeginDateAsUnixTimeStamp()
		);
	}

	/**
	 * @test
	 */
	public function getBeginDateAsUnixTimeStampWithBeginDateReturnsBeginDate() {
		$this->fixture->setData(array('begin_date' => 42));

		$this->assertEquals(
			42,
			$this->fixture->getBeginDateAsUnixTimeStamp()
		);
	}

	/**
	 * @test
	 */
	public function setBeginDateAsUnixTimeStampWithNegativeTimeStampThrowsException() {
		$this->setExpectedException(
			'InvalidArgumentException',
			'The parameter $beginDate must be >= 0.'
		);

		$this->fixture->setBeginDateAsUnixTimeStamp(-1);
	}

	/**
	 * @test
	 */
	public function setBeginDateAsUnixTimeStampWithZeroTimeStampSetsBeginDate() {
		$this->fixture->setBeginDateAsUnixTimeStamp(0);

		$this->assertEquals(
			0,
			$this->fixture->getBeginDateAsUnixTimeStamp()
		);
	}

	/**
	 * @test
	 */
	public function setBeginDateAsUnixTimeStampWithPositiveTimeStampSetsBeginDate() {
		$this->fixture->setBeginDateAsUnixTimeStamp(42);

		$this->assertEquals(
			42,
			$this->fixture->getBeginDateAsUnixTimeStamp()
		);
	}

	/**
	 * @test
	 */
	public function hasBeginDateWithoutBeginDateReturnsFalse() {
		$this->fixture->setData(array());

		$this->assertFalse(
			$this->fixture->hasBeginDate()
		);
	}

	/**
	 * @test
	 */
	public function hasBeginDateWithBeginDateReturnsTrue() {
		$this->fixture->setBeginDateAsUnixTimeStamp(42);

		$this->assertTrue(
			$this->fixture->hasBeginDate()
		);
	}


	//////////////////////////////////
	// Tests regarding the end date.
	//////////////////////////////////

	/**
	 * @test
	 */
	public function getEndDateAsUnixTimeStampWithoutEndDateReturnsZero() {
		$this->fixture->setData(array());

		$this->assertEquals(
			0,
			$this->fixture->getEndDateAsUnixTimeStamp()
		);
	}

	/**
	 * @test
	 */
	public function getEndDateAsUnixTimeStampWithEndDateReturnsEndDate() {
		$this->fixture->setData(array('end_date' => 42));

		$this->assertEquals(
			42,
			$this->fixture->getEndDateAsUnixTimeStamp()
		);
	}

	/**
	 * @test
	 */
	public function setEndDateAsUnixTimeStampWithNegativeTimeStampThrowsException() {
		$this->setExpectedException(
			'InvalidArgumentException',
			'The parameter $endDate must be >= 0.'
		);

		$this->fixture->setEndDateAsUnixTimeStamp(-1);
	}

	/**
	 * @test
	 */
	public function setEndDateAsUnixTimeStampWithZeroTimeStampSetsEndDate() {
		$this->fixture->setEndDateAsUnixTimeStamp(0);

		$this->assertEquals(
			0,
			$this->fixture->getEndDateAsUnixTimeStamp()
		);
	}

	/**
	 * @test
	 */
	public function setEndDateAsUnixTimeStampWithPositiveTimeStampSetsEndDate() {
		$this->fixture->setEndDateAsUnixTimeStamp(42);

		$this->assertEquals(
			42,
			$this->fixture->getEndDateAsUnixTimeStamp()
		);
	}

	/**
	 * @test
	 */
	public function hasEndDateWithoutEndDateReturnsFalse() {
		$this->fixture->setData(array());

		$this->assertFalse(
			$this->fixture->hasEndDate()
		);
	}

	/**
	 * @test
	 */
	public function hasEndDateWithEndDateReturnsTrue() {
		$this->fixture->setEndDateAsUnixTimeStamp(42);

		$this->assertTrue(
			$this->fixture->hasEndDate()
		);
	}


	//////////////////////////////
	// Tests regarding the room.
	//////////////////////////////

	/**
	 * @test
	 */
	public function getRoomWithoutRoomReturnsAnEmptyString() {
		$this->fixture->setData(array());

		$this->assertEquals(
			'',
			$this->fixture->getRoom()
		);
	}

	/**
	 * @test
	 */
	public function getRoomWithRoomReturnsRoom() {
		$this->fixture->setData(array('room' => 'cuby'));

		$this->assertEquals(
			'cuby',
			$this->fixture->getRoom()
		);
	}

	/**
	 * @test
	 */
	public function setRoomSetsRoom() {
		$this->fixture->setRoom('cuby');

		$this->assertEquals(
			'cuby',
			$this->fixture->getRoom()
		);
	}

	/**
	 * @test
	 */
	public function hasRoomWithoutRoomReturnsFalse() {
		$this->fixture->setData(array());

		$this->assertFalse(
			$this->fixture->hasRoom()
		);
	}

	/**
	 * @test
	 */
	public function hasRoomWithRoomReturnsTrue() {
		$this->fixture->setRoom('cuby');

		$this->assertTrue(
			$this->fixture->hasRoom()
		);
	}
}