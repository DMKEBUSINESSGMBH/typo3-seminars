<?php

/***************************************************************
 * Copyright notice
 *
 * (c) 2005-2014 Oliver Klee (typo3-coding@oliverklee.de)
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
 * Class tx_seminars_Interface_Hook_PreListBuilder
 *
 * @author Mario Seidel <mario.seidel@dmk-ebusiness.de>
 */
interface tx_seminars_Interface_Hook_ListBuilder {
	public function modifySeminarBagBuilder(tx_seminars_BagBuilder_Event $builder, array $piVars);
}
