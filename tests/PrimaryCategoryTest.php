<?php

use PHPUnit\Framework\TestCase;
use PrimaryCategoryPlugin\PrimaryCategory;

class PrimaryCategoryTest extends TestCase {

    /**
     * Initialize PrimaryCategory object
     * @return void
     */
    public function setUp(): void
    {
        $this->primaryCategory = new PrimaryCategory();
    }

    /**
     * Test for addPrimaryCategoryMetabox() method
     * @return void
     */
    public function test_addPrimaryCategoryMetabox()
    {
        // Your test here
    }

    /**
     * Test primaryCategoryMetaboxCallback() method
     * @return void
     */
    public function test_primaryCategoryMetaboxCallback()
    {
        // Your test here
    }

    /**
     * Test savePrimaryCategory() method
     * @return void
     */
    public function test_savePrimaryCategory()
    {
        // Your test here
    }

    /**
     * Test displayPostsByPrimaryCategory() method
     * @return void
     */
    public function test_displayPostsByPrimaryCategory()
    {
        // Your test here
    }

    /**
     * destruct objects after test completed
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->primaryCategory);
    }
}