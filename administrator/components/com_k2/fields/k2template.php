<?php
/**
 * @version		3.0.0b
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die ;

jimport('joomla.form.formfield');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class JFormFieldK2Template extends JFormField
{
	var $type = 'K2Template';

	public function getInput()
	{
		$application = JFactory::getApplication();
		$template = $application->getTemplate();
		$this->extension = $this->element['extension'];
		if ($this->extension == 'com_k2')
		{
			$corePath = JPATH_SITE.'/components/com_k2/templates';
			$overridesPath = JPATH_SITE.'/templates/'.$template.'/html/com_k2/templates';
		}
		else
		{
			$corePath = JPATH_SITE.'/modules/'.$this->extension.'/tmpl';
			$overridesPath = JPATH_SITE.'/templates/'.$template.'/html/'.$this->extension;
		}
		$coreTemplates = JFolder::folders($corePath);
		if (JFolder::exists($overridesPath))
		{
			$overrides = JFolder::folders($overridesPath);
			$templates = @array_merge($overrides, $coreTemplates);
			$templates = @array_unique($templates);
		}
		else
		{
			$templates = $coreTemplates;
		}
		$options = array();
		foreach ($templates as $folder)
		{
			$options[] = JHtml::_('select.option', $folder, $folder);
		}
		return JHtml::_('select.genericlist', $options, $this->name, '', 'value', 'text', $this->value, $this->id);
	}

}
