<?php
/**
 * @version		3.0.0
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die ; ?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2LatestCommentsBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">

	<?php if(count($comments)): ?>
	<ul>
		<?php foreach ($comments as $key => $comment):	?>
		<li class="<?php echo ($key%2) ? "odd" : "even"; if(count($comments)==$key+1) echo ' lastItem'; ?>">
			<?php if($comment->user->image): ?>
			<a class="k2Avatar lcAvatar" href="<?php echo $comment->link; ?>">
				<img src="<?php echo $comment->user->image; ?>" alt="<?php echo htmlspecialchars($comment->user->displayName); ?>" style="width:<?php echo $lcAvatarWidth; ?>px;height:auto;" />
			</a>
			<?php endif; ?>

			<?php if($params->get('commentLink')): ?>
			<a href="<?php echo $comment->link; ?>"><span class="lcComment"><?php echo $comment->text; ?></span></a>
			<?php else: ?>
			<span class="lcComment"><?php echo $comment->text; ?></span>
			<?php endif; ?>

			<?php if($params->get('commenterName')): ?>
			<span class="lcUsername"><?php echo JText::_('K2_WRITTEN_BY'); ?>
				<?php if($comment->user->link): ?>
				<a rel="author" href="<?php echo $comment->user->link; ?>"><?php echo $comment->user->displayName; ?></a>
				<?php elseif($comment->url): ?>
				<a target="_blank" rel="nofollow" href="<?php echo $comment->url; ?>"><?php echo $comment->user->displayName; ?></a>
				<?php else: ?>
				<?php echo $comment->user->displayName; ?>
				<?php endif; ?>
			</span>
			<?php endif; ?>

			<?php if($params->get('commentDate')): ?>
			<span class="lcCommentDate">
				<?php if($params->get('commentDateFormat') == 'relative'): ?>
				<?php echo $comment->relativeDate; ?>
				<?php else: ?>
				<?php echo JText::_('K2_ON'); ?> <?php echo JHTML::_('date', $comment->date, JText::_('K2_DATE_FORMAT_LC2')); ?>
				<?php endif; ?>
			</span>
			<?php endif; ?>

			<div class="clr"></div>

			<?php if($params->get('itemTitle')): ?>
			<span class="lcItemTitle"><a href="<?php echo $comment->itemLink; ?>"><?php echo $comment->itemTitle; ?></a></span>
			<?php endif; ?>

			<?php if($params->get('itemCategory')): ?>
			<span class="lcItemCategory">(<a href="<?php echo $comment->categoryLink; ?>"><?php echo $comment->categoryTitle; ?></a>)</span>
			<?php endif; ?>

			<div class="clr"></div>
		</li>
		<?php endforeach; ?>
		<li class="clearList"></li>
	</ul>
	<?php endif; ?>

	<?php if($params->get('feed')): ?>
	<div class="k2FeedIcon">
		<a href="<?php echo JRoute::_('index.php?option=com_k2&view=itemlist&format=feed&moduleID='.$module->id); ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

</div>
