<?php

/*
|--------------------------------------------------------------------------
| Static page SEO registry
|--------------------------------------------------------------------------
|
| One entry per static route. This is the single source of truth for:
|  - the default SEO values seeded into seo_meta (title/description), which
|    the SEO admin panel then owns — editing a page there wins over this file;
|  - the sitemap's list of static URLs;
|  - breadcrumbs (label + parent route) for BreadcrumbList schema;
|  - which office (LocalBusiness schema, chat "Call us" number) a page uses;
|  - the automatic Service schema on media and keyword pages.
|
| 'region' is 'ahmedabad', 'mumbai', 'both' or null.
|
*/

return [

    'view.home' => [
        'path' => '/',
        'label' => 'Home',
        'parent' => null,
        'region' => 'ahmedabad',
        'title' => 'Outdoor Advertising Agency in Ahmedabad | Krishna Outdoor',
        'description' => 'Outdoor advertising in Ahmedabad since 1985: 2000+ hoardings, AMTS and GSRTC bus ads, bus shelters and DOOH. Get a free site availability list today.',
    ],

    'view.about' => [
        'path' => '/about',
        'label' => 'About Us',
        'parent' => 'view.home',
        'region' => null,
        'title' => 'About Krishna Outdoor | OOH Advertising Since 1985',
        'description' => 'Since 1985, Krishna Outdoor has built brand visibility with hoardings, bus and train advertising across Ahmedabad, Gujarat and Mumbai. Meet our team.',
    ],

    'view.contact' => [
        'path' => '/contact',
        'label' => 'Contact Us',
        'parent' => 'view.home',
        'region' => 'both',
        'title' => 'Contact Krishna Outdoor | Ahmedabad & Mumbai Office',
        'description' => 'Contact our Ahmedabad and Mumbai offices for hoarding, bus shelter, bus and local train advertising. Call +91 98796 16411 for a free site list today.',
    ],

    'view.services' => [
        'path' => '/services',
        'label' => 'Media Solutions',
        'parent' => 'view.home',
        'region' => null,
        'title' => 'Outdoor, Transit & Social Media Services | Krishna Outdoor',
        'description' => 'Hoardings, AMTS and GSRTC bus ads, bus shelters, Mumbai local train and BEST bus branding, plus social media marketing in Ahmedabad and Mumbai.',
    ],

    'view.ooh.media' => [
        'path' => '/media/ooh',
        'label' => 'OOH Media',
        'parent' => 'view.home',
        'region' => 'ahmedabad',
        'title' => 'OOH Media in Gujarat: Hoardings, Unipoles & Bus Shelters',
        'description' => 'Explore 2000+ hoarding sites across Gujarat, 300+ own hoardings in Ahmedabad, 400+ backlit bus shelters, unipoles and gantries. Check availability.',
        'service' => ['name' => 'Outdoor (OOH) Media in Gujarat', 'type' => 'Outdoor Advertising', 'area' => ['Ahmedabad', 'Gujarat']],
    ],

    'view.transit.media' => [
        'path' => '/media/transit',
        'label' => 'Transit Media',
        'parent' => 'view.home',
        'region' => 'both',
        // Header/chat call and WhatsApp numbers: the page leads with Mumbai.
        'office' => 'mumbai',
        'title' => 'Transit Advertising Agency in Mumbai | Bus & Train Ads',
        'description' => 'Transit advertising agency for Mumbai local trains, BEST and TMT buses, plus GSRTC and AMTS buses in Gujarat. Rights on 7000+ buses. Enquire today.',
        'service' => ['name' => 'Transit Advertising', 'type' => 'Transit Advertising', 'area' => ['Mumbai', 'Thane', 'Ahmedabad', 'Gujarat']],
    ],

    'view.digital.media' => [
        'path' => '/media/digital',
        'label' => 'Digital Media',
        'parent' => 'view.home',
        'region' => 'ahmedabad',
        'title' => 'DOOH Advertising Agency Ahmedabad | Digital Billboards',
        'description' => 'Digital out-of-home (DOOH) advertising in Ahmedabad. Reach your audience with dynamic digital billboards and screens across prime city locations.',
        'service' => ['name' => 'Digital Out-of-Home (DOOH) Advertising in Ahmedabad', 'type' => 'Digital Out-of-Home Advertising', 'area' => ['Ahmedabad']],
    ],

    'view.network' => [
        'path' => '/our-network',
        'label' => 'Our Network',
        'parent' => 'view.home',
        'region' => null,
        'title' => 'Outdoor Media Network: Gujarat, Mumbai & Thane',
        'description' => 'See our network: 2000+ Gujarat hoardings, 7000+ GSRTC buses, AMTS, BEST and TMT buses and Mumbai local trains. Explore media availability today.',
    ],

    'view.projects' => [
        'path' => '/projects',
        'label' => 'Our Work',
        'parent' => 'view.home',
        'region' => null,
        'title' => 'OOH Campaigns & Case Studies | Krishna Outdoor',
        'description' => 'Hoarding, BEST bus, TMT bus and Mumbai local train campaigns for brands like Ambuja Cement, Torrent Power and Prefr across Ahmedabad and Mumbai.',
    ],

    'view.careers' => [
        'path' => '/careers',
        'label' => 'Careers',
        'parent' => 'view.home',
        'region' => null,
        'title' => 'Careers at Krishna Outdoor | Join Our OOH Team',
        'description' => 'Explore career opportunities at Krishna Outdoor, a leading outdoor advertising company in Ahmedabad and Mumbai since 1985.',
    ],

    'view.keyword.hoarding.ahmedabad' => [
        'path' => '/hoarding-advertising-ahmedabad',
        'label' => 'Hoarding Advertising Ahmedabad',
        'parent' => 'view.ooh.media',
        'region' => 'ahmedabad',
        'title' => 'Hoarding Advertising in Ahmedabad | 300+ Own Sites',
        'description' => 'Hoarding advertising in Ahmedabad with 300+ own sites and 2000+ across Gujarat. Frontlit, backlit and unipoles on prime roads. Get the free site list.',
        'service' => ['name' => 'Hoarding Advertising in Ahmedabad', 'type' => 'Hoarding Advertising', 'area' => ['Ahmedabad', 'Gujarat']],
    ],

    'view.keyword.amts.ahmedabad' => [
        'path' => '/amts-bus-advertising-ahmedabad',
        'label' => 'AMTS Bus Advertising Ahmedabad',
        'parent' => 'view.ooh.media',
        'region' => 'ahmedabad',
        'title' => 'AMTS Bus Advertising in Ahmedabad | 900+ Buses',
        'description' => 'AMTS bus advertising across Ahmedabad with rights on 900+ city buses. Full wraps and panels on busy routes. Ask Krishna Outdoor for routes and rates.',
        'service' => ['name' => 'AMTS Bus Advertising in Ahmedabad', 'type' => 'Bus Advertising', 'area' => ['Ahmedabad']],
    ],

    'view.keyword.bus.shelter.ahmedabad' => [
        'path' => '/bus-shelter-advertising-ahmedabad',
        'label' => 'Bus Shelter Advertising Ahmedabad',
        'parent' => 'view.ooh.media',
        'region' => 'ahmedabad',
        'title' => 'Bus Shelter Advertising in Ahmedabad | 400+ Backlit Sites',
        'description' => 'Bus shelter advertising in Ahmedabad on 400+ backlit shelters. Eye-level visibility where commuters wait. Check locations and availability today.',
        'service' => ['name' => 'Bus Shelter Advertising in Ahmedabad', 'type' => 'Bus Shelter Advertising', 'area' => ['Ahmedabad']],
    ],

    'view.keyword.gsrtc' => [
        'path' => '/gsrtc-bus-advertising',
        'label' => 'GSRTC Bus Advertising',
        'parent' => 'view.transit.media',
        'region' => 'ahmedabad',
        'title' => 'GSRTC Bus Advertising | 7000+ Buses Across Gujarat',
        'description' => 'GSRTC bus advertising on 7000+ state buses reaching every district of Gujarat. Formats, routes and booking support from Krishna Outdoor. Enquire now.',
        'service' => ['name' => 'GSRTC Bus Advertising', 'type' => 'Bus Advertising', 'area' => ['Gujarat']],
    ],

    'view.keyword.agency.mumbai' => [
        'path' => '/outdoor-advertising-agency-mumbai',
        'label' => 'Outdoor Advertising Agency Mumbai',
        'parent' => 'view.network',
        'region' => 'mumbai',
        'title' => 'Outdoor Advertising Agency in Mumbai | Krishna Outdoor',
        'description' => 'Outdoor advertising agency in Mumbai for local train branding, BEST and TMT bus ads. Mumbai office, campaign planning and site lists. Talk to us today.',
        'service' => ['name' => 'Outdoor Advertising Agency in Mumbai', 'type' => 'Outdoor Advertising', 'area' => ['Mumbai', 'Thane']],
    ],

    'view.keyword.local.train.mumbai' => [
        'path' => '/mumbai-local-train-advertising',
        'label' => 'Mumbai Local Train Advertising',
        'parent' => 'view.transit.media',
        'region' => 'mumbai',
        'title' => 'Mumbai Local Train Advertising | WR & CR Train Branding',
        'description' => 'Mumbai local train advertising on Western and Central Railway trains. Exterior train branding seen by daily commuters. Get formats and availability.',
        'service' => ['name' => 'Mumbai Local Train Advertising', 'type' => 'Train Advertising', 'area' => ['Mumbai']],
    ],

    'view.keyword.best.mumbai' => [
        'path' => '/best-bus-advertising-mumbai',
        'label' => 'BEST Bus Advertising Mumbai',
        'parent' => 'view.transit.media',
        'region' => 'mumbai',
        'title' => 'BEST Bus Advertising in Mumbai | 400+ EV Bus Wraps',
        'description' => 'BEST bus advertising in Mumbai with rights on 400+ BEST EV buses. Full-wrap branding on busy city routes, backed by proven campaigns. Enquire today.',
        'service' => ['name' => 'BEST Bus Advertising in Mumbai', 'type' => 'Bus Advertising', 'area' => ['Mumbai']],
    ],

    'view.keyword.tmt.thane' => [
        'path' => '/tmt-bus-advertising-thane',
        'label' => 'TMT Bus Advertising Thane',
        'parent' => 'view.transit.media',
        'region' => 'mumbai',
        'title' => 'TMT Bus Advertising in Thane | 350+ City Buses',
        'description' => 'TMT bus advertising in Thane with rights on 350+ city buses covering Thane and Mumbai-region routes. Full and partial branding. Get rates today.',
        'service' => ['name' => 'TMT Bus Advertising in Thane', 'type' => 'Bus Advertising', 'area' => ['Thane']],
    ],

    'view.keyword.social.ahmedabad' => [
        'path' => '/social-media-marketing-ahmedabad',
        'label' => 'Social Media Marketing Ahmedabad',
        'parent' => 'view.services',
        'region' => 'ahmedabad',
        'title' => 'Social Media Marketing in Ahmedabad | Krishna Outdoor',
        'description' => 'Social media marketing in Ahmedabad: strategy, content, paid ads and reports on Instagram, Facebook and LinkedIn, linked with your outdoor campaigns.',
        'service' => ['name' => 'Social Media Marketing in Ahmedabad', 'type' => 'Social Media Marketing', 'area' => ['Ahmedabad']],
    ],

    'view.keyword.social.mumbai' => [
        'path' => '/social-media-marketing-mumbai',
        'label' => 'Social Media Marketing Mumbai',
        'parent' => 'view.services',
        'region' => 'mumbai',
        'title' => 'Social Media Marketing Agency in Mumbai | Krishna Outdoor',
        'description' => 'Social media marketing in Mumbai for brands that want reach online and on the street: content, paid ads and campaigns paired with train and bus ads.',
        'service' => ['name' => 'Social Media Marketing in Mumbai', 'type' => 'Social Media Marketing', 'area' => ['Mumbai']],
    ],

    // Conversion landing page: kept out of search results and the sitemap.
    'view.free.site.list' => [
        'path' => '/free-site-list',
        'label' => 'Free Site List',
        'parent' => 'view.home',
        'region' => null,
        'index' => false,
        'title' => 'Get a Free Site List | Krishna Outdoor',
        'description' => 'Tell us your city and media type and our team will send you a free list of available hoardings, bus shelters, bus and train advertising options.',
    ],

];
