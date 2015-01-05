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
class tx_seminars_Model_TargetGroupTest extends tx_phpunit_testcase {
	/**
	 * @var tx_seminars_Model_TargetGroup
	 */
	private $fixture;

	protected function setUp() {
		$this->fixture = new tx_seminars_Model_TargetGroup();
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
		$this->fixture->setTitle('Housewives');

		$this->assertEquals(
			'Housewives',
			$this->fixture->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function getTitleWithNonEmptyTitleReturnsTitle() {
		$this->fixture->setData(array('title' => 'Housewives'));

		$this->assertEquals(
			'Housewives',
			$this->fixture->getTitle()
		);
	}


	/////////////////////////////////////
	// Tests concerning the minimum age
	/////////////////////////////////////

	/**
	 * @test
	 */
	public function getMinimumAgeWithNoMinimumAgeSetReturnsZero() {
		$this->fixture->setData(array());

		$this->assertEquals(
			0,
			$this->fixture->getMinimumAge()
		);
	}

	/**
	 * @test
	 */
	public function getMinimumAgeWithNonZeroMinimumAgeReturnsMinimumAge() {
		$this->fixture->setData(array('minimum_age' => 18));

		$this->assertEquals(
			18,
			$this->fixture->getMinimumAge()
		);
	}

	/**
	 * @test
	 */
	public function setMinimumAgeSetsMinimumAge() {
		$this->fixture->setMinimumAge(18);

		$this->assertEquals(
			18,
			$this->fixture->getMinimumAge()
		);
	}


	/////////////////////////////////////
	// Tests concerning the maximum age
	/////////////////////////////////////

	/**
	 * @test
	 */
	public function getMaximumAgeWithNoMaximumAgeSetReturnsZero() {
		$this->fixture->setData(array());

		$this->assertEquals(
			0,
			$this->fixture->getMaximumAge()
		);
	}

	/**
	 * @test
	 */
	public function getMaximumAgeWithNonZeroMaximumAgeReturnsMaximumAge() {
		$this->fixture->setData(array('maximum_age' => 18));

		$this->assertEquals(
			18,
			$this->fixture->getMaximumAge()
		);
	}

	/**
	 * @test
	 */
	public function setMaximumAgeSetsMaximumAge() {
		$this->fixture->setMaximumAge(18);

		$this->assertEquals(
			18,
			$this->fixture->getMaximumAge()
		);
	}
}