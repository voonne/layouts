<?php

/**
 * This file is part of the Voonne platform (http://www.voonne.org)
 *
 * Copyright (c) 2016 Jan Lavička (mail@janlavicka.name)
 *
 * For the full copyright and license information, please view the file licence.md that was distributed with this source code.
 */

namespace Voonne\Layouts;

use Nette\ComponentModel\IComponent;
use Voonne\Controls\Control;
use Voonne\Panels\Panels\PanelManager;
use Voonne\Panels\Renderers\Renderer;
use Voonne\Panels\Renderers\RendererManager;
use Voonne\Security\User;
use Voonne\Voonne\Content\ContentForm;


abstract class Layout extends Control
{

	const POSITION_TOP = 'top';
	const POSITION_BOTTOM = 'bottom';
	const POSITION_LEFT = 'left';
	const POSITION_RIGHT = 'right';
	const POSITION_CENTER = 'center';

	/**
	 * @var RendererManager
	 */
	private $rendererManager;

	/**
	 * @var PanelManager
	 */
	private $panelManager;

	/**
	 * @var ContentForm
	 */
	private $contentForm;

	/**
	 * @var User
	 */
	private $user;


	/**
	 * @return RendererManager
	 */
	public function getRendererManager()
	{
		return $this->rendererManager;
	}


	/**
	 * @return PanelManager
	 */
	public function getPanelManager()
	{
		return $this->panelManager;
	}


	/**
	 * @return ContentForm
	 */
	public function getContentForm()
	{
		return $this->contentForm;
	}


	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}


	/**
	 * @param RendererManager $rendererManager
	 * @param PanelManager $panelManager
	 * @param ContentForm $contentForm
	 * @param User $user
	 */
	public function injectPrimary(RendererManager $rendererManager, PanelManager $panelManager, ContentForm $contentForm, User $user)
	{
		if($this->rendererManager !== null) {
			throw new InvalidStateException('Method ' . __METHOD__ . ' is intended for initialization and should not be called more than once.');
		}

		$this->rendererManager = $rendererManager;
		$this->panelManager = $panelManager;
		$this->contentForm = $contentForm;
		$this->user = $user;
	}


	/**
	 * @param IComponent $component
	 * @param string $name
	 * @param string|null $insertBefore
	 *
	 * @return $this
	 */
	public function addComponent(IComponent $component, $name, $insertBefore = null)
	{
		if ($component instanceof Renderer) {
			// INJECT
			$component->injectPrimary($this->getContentForm()->getComponent($name));
		}

		parent::addComponent($component, $name, $insertBefore);

		return $this;
	}

}
