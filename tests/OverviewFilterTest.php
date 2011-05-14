<?php

require_once '\..\source\controls\base\OverviewFilter.php';

/**
 * Test class for OverviewFilter.
 * Generated by PHPUnit on 2011-05-06 at 12:20:39.
 */
class OverviewFilterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var OverviewFilter
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new OverviewFilter;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testFrom()
    {
    	$testDate = "19.04.2011";
        $this->object->setFrom($testDate);
        
        $this->assertEquals($this->object->getFrom(), $testDate);
    }

    public function testTo()
    {
        $testDate = "19.04.2011";
        $this->object->setTo($testDate);
        
        $this->assertEquals($this->object->getTo(), $testDate);
    }

    public function testClient()
    {
        $expectedClient = "myclient";
        $this->object->setClient($expectedClient);
        $actualClient = $this->object->getClient();
        $this->assertEquals($actualClient, $expectedClient);
    }

    public function testPlanned()
    {
        $this->assertTrue($this->object->getPlanned());
        $this->object->setPlanned(false);
        $this->assertFalse($this->object->getPlanned());
    }

    public function testInprogress()
    {
        $this->assertTrue($this->object->getInprogress());
        $this->object->setInprogress(false);
        $this->assertFalse($this->object->getInprogress());
    }

    public function testDone()
    {
        $this->assertTrue($this->object->getDone());
        $this->object->setDone(false);
        $this->assertFalse($this->object->getDone());
    }

    public function testSetCanceled()
    {
        $this->assertTrue($this->object->getCanceled());
        $this->object->setCanceled(false);
        $this->assertFalse($this->object->getCanceled());
    }
}
?>
