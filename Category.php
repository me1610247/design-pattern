<?php
class Category {
    private $name;
    private $description;

    public function __construct($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    // Other methods for category management
    
}
