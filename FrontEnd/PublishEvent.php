<?php
/***************************************************************
* Copyright notice
*
* (c) 2009-2014 Bernd Schönbach <bernd@oliverklee.de>
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
 * This class publishes events which are hidden through editing or creation in the FE-editor.
 *
 * @package TYPO3
 * @subpackage tx_seminars
 *
 * @author Bernd Schönbach <bernd@oliverklee.de>
 */
class tx_seminars_FrontEnd_PublishEvent extends tx_oelib_templatehelper {
	/**
	 * @var int
	 */
	const PUBLICATION_TYPE_NUMBER = 737;

	/**
	 * @var string the prefix used for the piVars
	 */
	public $prefixId = 'tx_seminars_publication';

	/**
	 * @var string the extension key
	 */
	public $extKey = 'seminars';

	/**
	 * Creates the HTML for the event publishing.
	 *
	 * This will just output a success or fail line for the event publishing
	 * page.
	 *
	 * @return string HTML code for the event publishing, will not be empty
	 */
	public function render() {
		$this->init(array());

		if (!isset($this->piVars['hash']) || ($this->piVars['hash'] == '')) {
			return $this->translate('message_publishingFailed');
		}

		/** @var tx_seminars_Mapper_Event $eventMapper */
		$eventMapper = t3lib_div::makeInstance('tx_seminars_Mapper_Event');
		/** @var tx_seminars_Model_Event $event */
		$event = $eventMapper->findByPublicationHash($this->piVars['hash']);

		if (($event !== NULL) && $event->isHidden()) {
			$event->markAsVisible();
			$event->purgePublicationHash();
			$eventMapper->save($event);
			$result = $this->translate('message_publishingSuccessful');
		} else {
			$result = $this->translate('message_publishingFailed');
		}

		return $result;
	}
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/seminars/FrontEnd/PublishEvent.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/seminars/FrontEnd/PublishEvent.php']);
}