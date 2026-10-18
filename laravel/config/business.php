<?php

/*
|--------------------------------------------------------------------------
| Business facts (NAP)
|--------------------------------------------------------------------------
|
| Office names, addresses and phone numbers shown in the footer, header and
| chat widget, and used as the starting values for the LocalBusiness schema
| in SEO settings. Keep the wording here exactly as approved.
|
| Values marked TODO were not available and are left empty on purpose;
| nothing that depends on them is output until they are filled in.
|
*/

return [

    'email' => 'info@krishnaoutdoor.in',

    'offices' => [

        'ahmedabad' => [
            'label' => 'Ahmedabad Head Office',
            'schema_name' => 'Krishna Outdoor – Ahmedabad Head Office',
            'address' => 'Aakanksha Complex, 403-404, Netaji Rd, nr. Railway Crossing, Navrangpura, Ahmedabad, Gujarat 380009',
            'street' => 'Aakanksha Complex, 403-404, Netaji Rd, nr. Railway Crossing, Navrangpura',
            'locality' => 'Ahmedabad',
            'region' => 'Gujarat',
            'postal_code' => '380009',
            'phone_display' => '+91 98796 16411',
            'phone' => '+919879616411',
            // From the Google Maps embed on /contact (zoomed-in office pin);
            // map_url is the same listing's CID from that embed.
            'geo' => ['lat' => 23.0341785, 'lng' => 72.566672],
            'map_url' => 'https://maps.google.com/?cid=15385850377311934967',
            'area_served' => ['Ahmedabad', 'Gujarat'],
            // TODO: confirm opening hours, e.g. ['Mo-Fr 10:00-19:00', 'Sa 10:00-14:00'].
            'opening_hours' => [],
        ],

        'mumbai' => [
            'label' => 'Mumbai Office',
            'schema_name' => 'Krishna Outdoor – Mumbai Office',
            'address' => '701-702 Morya Blue Moon, Off New Link Road, Andheri West, Mumbai, Maharashtra 400053',
            'street' => '701-702 Morya Blue Moon, Off New Link Road, Andheri West',
            'locality' => 'Mumbai',
            'region' => 'Maharashtra',
            'postal_code' => '400053',
            'phone_display' => '+91 99200 11574',
            'phone' => '+919920011574',
            // TODO: confirm the office pin. The Mumbai map embed on /contact is
            // zoomed out and its centre (19.1386, 72.7552) lies in the sea west
            // of Andheri, so it is not the office location. geo is omitted from
            // the schema until real coordinates are entered here.
            'geo' => null,
            'map_url' => 'https://maps.google.com/?cid=18172301373733369712',
            'area_served' => ['Mumbai', 'Thane'],
            // TODO: confirm opening hours.
            'opening_hours' => [],
        ],

    ],

    // VideoObject schema for the site's self-hosted videos. Paths are
    // relative to the site root.
    'videos' => [
        'hero' => [
            'name' => 'Krishna Outdoor – 360 degree advertising',
            'description' => 'Brand film: digital billboards, bus and tram advertising and the brands Krishna Outdoor has worked with, ending with the Krishna Outdoor logo.',
            'thumbnail' => '/assets/images/hero/hero-desktop-poster.webp',
            'content' => '/assets/videos/hero-desktop.mp4',
            // TODO: date the video was first published (YYYY-MM-DD). Google
            // requires uploadDate for video rich results.
            'upload_date' => null,
        ],
        'showcase' => [
            'name' => 'Mumbai local train branding campaign',
            'description' => 'Parul University branding on a Mumbai Central Railway local train, a transit campaign by Krishna Outdoor.',
            'thumbnail' => '/assets/images/hero/work-showcase-poster.webp',
            'content' => '/assets/videos/work-showcase.mp4',
            // TODO: date the video was first published (YYYY-MM-DD).
            'upload_date' => null,
        ],
    ],

    'social' => [
        'https://www.facebook.com/krishnaoutdoorofficial/',
        'https://www.instagram.com/krishnaoutdoorofficial/',
        'https://www.linkedin.com/company/krishnaoutdoor/',
    ],

];
