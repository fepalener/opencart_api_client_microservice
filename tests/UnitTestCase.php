<?php
namespace Test;

use App\Bootstrap;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\IncompleteTestError;

abstract class UnitTestCase extends TestCase
{
    /**
     * Is Bootstrap loaded
     *
     * @var bool
     */
    private $_loaded = false;

    /**
     * @var Bootstrap
     */
    private $app;
    
    protected function setUp()
    {
        parent::setUp();

        $this->app = new Bootstrap(dirname(dirname(__FILE__)));

        $this->_loaded = true;
    }

    /**
     * Check if the test case is setup properly
     *
     * @throws \PHPUnit_Framework_IncompleteTestError
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            throw new IncompleteTestError("Please run parent::setUp().");
        }
    }
}
