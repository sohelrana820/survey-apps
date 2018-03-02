<?php

namespace App\Tests;


use App\helpers\Utility;

class UtilityTests extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Utility
     */
    private $utility;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->utility = new Utility();
    }

    /**
     *
     */
    public function testTest()
    {
        $this->assertTrue($this->utility->test());
    }
}