<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * This class creates a CSV export of registrations for download.
 *
 * @package TYPO3
 * @subpackage tx_seminars
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class Tx_Seminars_Csv_EmailRegistrationListView extends Tx_Seminars_Csv_AbstractRegistrationListView {
	/**
	 * Returns the keys of the front-end user fields to export.
	 *
	 * @return string[]
	 */
	protected function getFrontEndUserFieldKeys() {
		return $this->configuration->getAsTrimmedArray('fieldsFromFeUserForEmailCsv');
	}

	/**
	 * Returns the keys of the registration fields to export.
	 *
	 * @return string[]
	 */
	protected function getRegistrationFieldKeys() {
		return $this->configuration->getAsTrimmedArray('fieldsFromAttendanceForEmailCsv');
	}

	/**
	 * Checks whether the export should also contain registrations that are on the queue.
	 *
	 * @return bool
	 */
	protected function shouldAlsoContainRegistrationsOnQueue() {
		return $this->configuration->getAsBoolean('showAttendancesOnRegistrationQueueInEmailCsv');
	}
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/seminars/Csv/EmailRegistrationListView.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/seminars/Csv/EmailRegistrationListView.php']);
}