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
class tx_seminars_Model_EventTypeTest extends tx_phpunit_testcase {
	/**
	 * @var tx_seminars_Model_EventType
	 */
	private $fixture;

	protected function setUp() {
		$this->fixture = new tx_seminars_Model_EventType();
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
		$this->fixture->setTitle('Workshop');

		$this->assertEquals(
			'Workshop',
			$this->fixture->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function getTitleWithNonEmptyTitleReturnsTitle() {
		$this->fixture->setData(array('title' => 'Workshop'));

		$this->assertEquals(
			'Workshop',
			$this->fixture->getTitle()
		);
	}


	//////////////////////////////////////////////
	// Tests concerning the single view page UID
	//////////////////////////////////////////////

	/**
	 * @test
	 */
	public function getSingleViewPageUidReturnsSingleViewPageUid() {
		$this->fixture->setData(array('single_view_page' => 42));

		$this->assertEquals(
			42,
			$this->fixture->getSingleViewPageUid()
		);
	}

	/**
	 * @test
	 */
	public function hasSingleViewPageUidForZeroPageUidReturnsFalse() {
		$this->fixture->setData(array('single_view_page' => 0));

		$this->assertFalse(
			$this->fixture->hasSingleViewPageUid()
		);
	}

	/**
	 * @test
	 */
	public function hasSingleViewPageUidForNonZeroPageUidReturnsTrue() {
		$this->fixture->setData(array('single_view_page' => 42));

		$this->assertTrue(
			$this->fixture->hasSingleViewPageUid()
		);
	}
}