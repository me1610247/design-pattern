<?php
class CategoryBuilder {
    private $category;

    public function __construct($name) {
        $this->category = new Category($name);
    }

    public function addDescription($description) {
        $this->category->setDescription($description);
        return $this;
    }

    public function build() {
        return $this->category;
    }
}
$categoryBuilder = CategoryFactory::createCategory("Electronics")->addDescription("Electronic gadgets");
$category = $categoryBuilder->build();

