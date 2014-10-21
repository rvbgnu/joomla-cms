<?php
/**
 * description
 *
 * @package		Joomla.Plugin
 * @subpackage	Content.joomla
 *
 * @copyright	Copyright (c) 2013 David Hurley. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class LinkProtectHelper
{
	public $params = null;

	public function __construct($params = null)
	{
		$this->params = $params;
	}
	
	/**
	 * Function is used to replace all the matched links
	 * @param 	array $matches	An array of matched Link items
	 * @return 	string			The replaced link string
	 */
	public function replaceLinks($matches)
	{
		$link = $matches[2];
		if (strpos($link, JURI::root()))
		{
			return $link;
		} else
		{
			$warningPage	= $this->params->get('warning_page');
			$external		= base64_encode($link);
			$newLink		= 'href="'.JRoute::_(ContentHelperRoute::getArticleRoute($warningPage).'&external='.$external).'"';
			return $newLink;
		}
	}
	
	/**
	 * Function to replace external link on the exit page
	 * @param object $article		The content item
	 * @param string $external		The encoded external URL link
	 * Return is directly in the instance of $article->text
	 */
	public function leaveSite($article, $external)
	{
		$target		= $this->params->get('new_window') ? 'target="_blank"' : '';
		$link		= base64_decode($external);
		$article->text = str_ireplace('{linkprotecturl}', '<a href="'.$link.'" '.$target.'>'.$link.'</a>', $article->text);
	}
}