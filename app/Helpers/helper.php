<?php

use App\Models\Page;

function getCategories()
{
    return \App\Models\Category::
        where('status', 1)
        ->where('showHome', 'Yes')
        ->with('sub_categories')
        ->get();
}



function static_pages()
{

    $pages = Page::orderBy('name', 'ASC')->get();

    return $pages;

}

?>
