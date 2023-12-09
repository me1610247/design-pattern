<?php
class CategoryFactory {
    public static function createCategory($name) {
        return new CategoryBuilder($name);
    }
}
