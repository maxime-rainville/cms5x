<?php

use SilverStripe\Dev\SapphireTest;

class PageTest extends SapphireTest
{
    public function testCreate()
    {
        $page = new Page();
        $page->Title = 'Test Page';
        $page->write();

        $version = Page::get()->byID($page->ID)->Version;

        $page->Title = 'test update';
        // $page->write();
        $page->publishSingle();

        $this->assertEquals($version + 1, Page::get()->byID($page->ID)->Version);
    }
}

