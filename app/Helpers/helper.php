<?php

function getCategories()
{
    return \App\Models\Category::
                 where('status', 1)
                ->where('showHome', 'Yes')
                ->with('sub_categories')
                ->get();
}



