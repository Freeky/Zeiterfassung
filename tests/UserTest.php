<?php

require_once '\..\source\controls\admin\User.php';

/**
 * Test class for User.
 * Generated by PHPUnit on 2011-05-06 at 14:20:40.
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var User
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new User;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @todo Implement testGetUID().
     */
    public function testUID()
    {
        $UID="1";
    	$this->object->setUID($UID);
    	$this->assertEquals($UID,$this->object->getUID());
    }

    /**
     * @todo Implement testGetPassword().
     */
    public function testPassword()
    {
    	$pass="meep";
    	$this->object->setPassword($pass);
    	$pass=hash("sha512",$pass);
    	$this->assertEquals($pass,$this->object->getPassword());
    }

	public function testPasswordLen()
    {
    	$pass="meep";
    	$this->object->setPassword($pass);
    	$this->assertEquals(4,$this->object->getPasswordLen());
    }
    /**
     * @todo Implement testGetAdmin().
     */
    public function testAdmin()
    {
        $admin="1";
    	$this->object->setAdmin($admin);
    	$this->assertEquals($admin,$this->object->getAdmin());
    }

    /**
     * @todo Implement testSetName().
     */
    public function testName()
    {
        $name="test";
    	$this->object->setName($name);
    	$this->assertEquals($name,$this->object->getName());
    }
}
?>
