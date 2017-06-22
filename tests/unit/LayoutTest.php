<?php

namespace Voonne\TestLayouts;

use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;
use UnitTester;
use Voonne\Layouts\InvalidStateException;
use Voonne\Layouts\Layout;
use Voonne\Panels\Panels\PanelManager;
use Voonne\Panels\Renderers\RendererManager;
use Voonne\Security\User;
use Voonne\Voonne\Content\ContentForm;


class LayoutTest extends Unit
{

	/**
	 * @var UnitTester
	 */
	protected $tester;

	/**
	 * @var MockInterface
	 */
	private $rendererManager;

	/**
	 * @var MockInterface
	 */
	private $panelManager;

	/**
	 * @var MockInterface
	 */
	private $contentForm;

	/**
	 * @var MockInterface
	 */
	private $user;

	/**
	 * @var Layout
	 */
	private $layout;


	protected function _before()
	{
		$this->rendererManager = Mockery::mock(RendererManager::class);
		$this->panelManager = Mockery::mock(PanelManager::class);
		$this->contentForm = Mockery::mock(ContentForm::class);
		$this->user = Mockery::mock(User::class);

		$this->layout = new TestLayout();
		$this->layout->injectPrimary($this->rendererManager, $this->panelManager, $this->contentForm, $this->user);
	}


	protected function _after()
	{
		Mockery::close();
	}


	public function testInitialize()
	{
		$this->assertEquals($this->rendererManager, $this->layout->getRendererManager());
		$this->assertEquals($this->panelManager, $this->layout->getPanelManager());
		$this->assertEquals($this->contentForm, $this->layout->getContentForm());
		$this->assertEquals($this->user, $this->layout->getUser());

		$this->expectException(InvalidStateException::class);
		$this->layout->injectPrimary($this->rendererManager, $this->panelManager, $this->contentForm, $this->user);
	}

}


class TestLayout extends Layout
{

}
