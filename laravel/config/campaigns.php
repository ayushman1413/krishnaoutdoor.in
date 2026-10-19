<?php

/*
|--------------------------------------------------------------------------
| Campaign case studies
|--------------------------------------------------------------------------
|
| Campaigns live in the database (Admin > Our Work) and each one gets its own
| case-study page at /projects/{slug}. This file only says which keyword
| pages show which existing campaigns in their "Campaigns we have run" block
| and which keyword page a case study links back to.
|
| Brand names are matched loosely against the campaign name (case, spaces and
| punctuation are ignored), and a name with no matching campaign in the
| database is simply not shown; it appears in Admin > SEO > Content TODOs.
|
| Order matters: a campaign links back to the first page below that lists it.
|
*/

return [

    'keyword_pages' => [
        'view.keyword.best.mumbai' => ['Kala-Kendra', 'Shree Swaminarayan', 'Prefr', 'Fashionism', 'Aluminium Bharat'],
        'view.keyword.tmt.thane' => ['Ambuja Cement', 'Doraemon'],
        'view.keyword.hoarding.ahmedabad' => ['Torrent Power'],
        'view.keyword.agency.mumbai' => ['Kala-Kendra', 'Prefr', 'Fashionism'],
    ],

    'media_labels' => [
        'outdoor' => 'Outdoor Media',
        'transit' => 'Transit Media',
        'integrated' => 'Integrated Media',
        'social' => 'Social Media',
    ],

];
