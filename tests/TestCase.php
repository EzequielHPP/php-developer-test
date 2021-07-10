<?php

namespace Tests;

use Http\Factory\Guzzle\ServerRequestFactory;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UriInterface;
use Slim\App;
use Slim\Factory\AppFactory;

/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
abstract class TestCase extends PHPUnit_TestCase
{
    /** @var  App */
    protected App $app;

	/**
	 * Sets up the fixture, for example, open a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() : void {
		parent::setUp();
		$this->createApplication();
	}

	/**
	 * Tears down the fixture, for example, close a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() : void {
		unset( $this->app );
		parent::tearDown();
	}

	/**
	 * Create a server request.
	 *
	 * @param string $method The HTTP method
	 * @param string|UriInterface $uri The URI
	 * @param array $serverParams The server parameters
	 *
	 * @return Request
	 */
	protected function createRequest(
		string $method,
		$uri,
		array $serverParams = []
	) : Request {
		return ( new ServerRequestFactory() )->createServerRequest( $method, $uri, $serverParams );
	}

	protected function createApplication()
    {
        // Instantiate the application

        $sep = DIRECTORY_SEPARATOR;
        $_SERVER['DB_DIR'] = __DIR__ . $sep . 'Models' . $sep;
        $this->app = $app = AppFactory::create();

        //Constants and translator
        include_once __DIR__ . $sep . '..' . $sep . 'src' . $sep . 'System' . $sep . 'Constants.php';
        include_once __DIR__ . $sep . '..' . $sep . 'src' . $sep . 'System' . $sep . 'Translator.php';

        // Register routes
        require dirname(__DIR__) . $sep . 'app' . $sep . 'routes.php';
    }
}
