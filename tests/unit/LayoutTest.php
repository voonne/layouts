<?php

namespace Voonne\TestLayouts;

use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;
use UnitTester;
use Voonne\Layouts\InvalidStateException;
use Voonne\Layouts\Layout;
use Voonne\Panels\PanelManager;
use Voonne\Panels\Renderers\RendererManager;
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
	 * @var Layout
	 */
	private $layout;


	protected function _before()
	{
		$this->rendererManager = Mockery::mock(RendererManager::class);
		$this->panelManager = Mockery::mock(PanelManager::class);
		$this->contentForm = Mockery::mock(ContentForm::class);

		$this->layout = new TestLayout();
		$this->layout->injectPrimary($this->rendererManager, $this->panelManager, $this->contentForm);
	}


	protected function _after()
	{
		Mockery::close();
	}


	public function testInitialize()
	{
		$this->assertEquals($this->rendererManager, $this->layout->getRendererManager());
		$this->assertEquals($this->contentForm, $this->layout->getContentForm());

		$this->expectException(InvalidStateException::class);
		$this->layout->injectPrimary($this->rendererManager, $this->panelManager, $this->contentForm);
	}

}


class TestLayout extends Layout
{

}
