<?php
/**
 * @version		3.0.0
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die ;

/**
 * K2 utilities helper class.
 */

class K2HelperUtilities
{
	public static function writtenBy($gender)
	{
		if ($gender == 'm')
		{
			return JText::_('K2_WRITTEN_BY_MALE');
		}
		else if ($gender == 'f')
		{
			return JText::_('K2_WRITTEN_BY_FEMALE');
		}
		else
		{
			return JText::_('K2_WRITTEN_BY');
		}
	}

	public static function wordLimit($string, $length = 100, $endCharacter = '&#8230;')
	{
		// If the string is empty return
		if (trim($string) == '')
		{
			return $string;
		}

		// Strip HTML tags
		$string = strip_tags($string);

		// Get words
		$words = str_word_count($string, 1);

		// Truncate
		if (count($words) > $length)
		{
			$words = array_slice($words, 0, $length);
			$string = implode(' ', $words);

			// Append end character
			if ($endCharacter)
			{
				$string .= ' '.$endCharacter;
			}
		}

		// Return
		return $string;
	}

	public static function getModule($id)
	{
		// Get module
		$module = JTable::getInstance('Module');
		$module->load($id);

		// Check access and state
		$date = JFactory::getDate()->toSql();
		$viewlevels = JFactory::getUser()->getAuthorisedViewLevels();

		if ($module->published && in_array($module->access, $viewlevels) && ((int)$module->publish_up == 0 || $module->publish_up >= $date) && ((int)$module->publish_down == 0 || $module->publish_down < $date))
		{
			$module->params = new JRegistry($module->params);
			return $module;
		}
		else
		{
			return false;
		}

	}

}