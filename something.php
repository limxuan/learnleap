<?php

class TestClass
{
    private $name;
    public function __construct($name)
    {
        $this->name = $name;
    }
    public function sayHello()
    {
        echo "Hello, ".$this->name."!";
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return$this->name;
    }
}

$test = new TestClass("World");
$test->sayHello();
$test->setName("PHP");
$test->sayHello();
