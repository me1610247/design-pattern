<?php
class Item {
    private $name;
    private $details;
    private $images;

    public function __construct($name) {
        $this->name = $name;
    }
    public function setDetails($details) {
        $this->details = $details;
    }

    public function setImages($images) {
        $this->images = $images;
    }
    
    // Other methods for item management
}
