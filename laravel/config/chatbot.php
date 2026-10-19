<?php

/*
|--------------------------------------------------------------------------
| Krishna AI knowledge base
|--------------------------------------------------------------------------
|
| Everything the chatbot may state as fact. It is built only from what the
| website already says (media rights, formats, offices, process). Prices are
| never listed because the site has none: pricing questions are answered with
| the cost drivers and a route to a free site list. Add or correct facts here
| (or in Admin > Our Work for campaigns) and the bot follows.
|
| Entry keys:
|   id     unique id
|   media  media key the entry is about (hoarding, amts, shelter, gsrtc, best,
|          tmt, train, dooh, print, social, branding, surat, jaipur) or null
|   city   ahmedabad | mumbai | gujarat | thane | null
|   k      keywords / phrases that make the entry relevant (weighted by rarity)
|   a      the answer (plain text; **bold** and line breaks are allowed)
|   links  [label, path] pairs shown under the answer
|   next   follow-up suggestions shown as chips
|
*/

return [

    'media' => [
        'hoarding' => ['label' => 'hoardings', 'page' => '/hoarding-advertising-ahmedabad', 'title' => 'Hoarding advertising in Ahmedabad', 'list' => 'hoardings', 'syn' => ['hoarding', 'hoardings', 'billboard', 'billboards', 'unipole', 'unipoles', 'gantry', 'gantries', 'frontlit', 'backlit hoarding', 'ooh', 'outdoor']],
        'amts' => ['label' => 'AMTS buses', 'page' => '/amts-bus-advertising-ahmedabad', 'title' => 'AMTS bus advertising in Ahmedabad', 'list' => 'amts', 'syn' => ['amts', 'ahmedabad bus', 'city bus ahmedabad', 'ahmedabad city bus']],
        'shelter' => ['label' => 'bus shelters', 'page' => '/bus-shelter-advertising-ahmedabad', 'title' => 'Bus shelter advertising in Ahmedabad', 'list' => 'bus-shelters', 'syn' => ['shelter', 'shelters', 'bus stop', 'bus stand', 'bus shelter']],
        'gsrtc' => ['label' => 'GSRTC buses', 'page' => '/gsrtc-bus-advertising', 'title' => 'GSRTC bus advertising', 'list' => 'gsrtc', 'syn' => ['gsrtc', 'st bus', 'state transport', 'state bus', 'gujarat bus', 'statewide bus']],
        'best' => ['label' => 'BEST buses', 'page' => '/best-bus-advertising-mumbai', 'title' => 'BEST bus advertising in Mumbai', 'list' => 'best', 'syn' => ['best', 'best bus', 'mumbai bus', 'ev bus', 'electric bus', 'best ev']],
        'tmt' => ['label' => 'TMT buses', 'page' => '/tmt-bus-advertising-thane', 'title' => 'TMT bus advertising in Thane', 'list' => 'tmt', 'syn' => ['tmt', 'thane bus', 'thane municipal']],
        'train' => ['label' => 'Mumbai local trains', 'page' => '/mumbai-local-train-advertising', 'title' => 'Mumbai local train advertising', 'list' => 'mumbai-local-train', 'syn' => ['train', 'local train', 'railway', 'western railway', 'central railway', 'suburban', 'rake']],
        'dooh' => ['label' => 'digital screens (DOOH)', 'page' => '/media/digital', 'title' => 'Digital out-of-home advertising', 'list' => 'dooh', 'syn' => ['dooh', 'digital screen', 'digital screens', 'digital billboard', 'led', 'digital out of home', 'digital media']],
        'social' => ['label' => 'social media marketing', 'page' => '/social-media-marketing-ahmedabad', 'title' => 'Social media marketing', 'list' => 'other', 'syn' => ['social media', 'instagram', 'facebook', 'linkedin', 'youtube', 'smm', 'paid ads', 'reels']],
        'print' => ['label' => 'print and electronic media', 'page' => '/services', 'title' => 'Print and electronic media', 'list' => 'other', 'syn' => ['newspaper', 'print', 'radio', 'television', 'tv', 'ott', 'press', 'electronic media']],
        'branding' => ['label' => 'branding solutions', 'page' => '/services', 'title' => 'Branding solutions', 'list' => 'other', 'syn' => ['branding', 'brand identity', 'creative', 'design']],
        'surat' => ['label' => 'Surat EV buses', 'page' => '/media/ooh', 'title' => 'Surat EV buses', 'list' => 'transit', 'syn' => ['surat', 'surat bus']],
        'jaipur' => ['label' => 'Jaipur city buses', 'page' => '/media/transit', 'title' => 'Jaipur city buses', 'list' => 'transit', 'syn' => ['jaipur', 'rajasthan']],
    ],

    'cities' => [
        'ahmedabad' => ['ahmedabad', 'amdavad', 'ahmdabad', 'ahd'],
        'mumbai' => ['mumbai', 'bombay', 'andheri', 'navi mumbai'],
        'thane' => ['thane'],
        'gujarat' => ['gujarat', 'surat', 'vadodara', 'baroda', 'rajkot', 'gandhinagar', 'statewide', 'state wide', 'state-wide'],
        'rajasthan' => ['jaipur', 'rajasthan'],
    ],

    'knowledge' => [

        ['id' => 'ahmedabad-overview', 'media' => null, 'city' => 'ahmedabad',
            'k' => ['ahmedabad', 'ahmedabad media', 'in ahmedabad', 'advertising in ahmedabad', 'ahmedabad options'],
            'a' => "In Ahmedabad we offer:\n• **300+ own hoardings** (frontlit, backlit, unipoles and gantries)\n• **900+ AMTS city buses**\n• **400+ backlit bus shelters**\n• **DOOH digital screens** and social media marketing\nTell me your goal and I'll suggest a mix.",
            'links' => [['Outdoor advertising agency in Ahmedabad', '/'], ['OOH media', '/media/ooh']], 'next' => ['Plan a campaign for me', 'Hoardings in Ahmedabad', 'AMTS buses']],
        ['id' => 'gujarat-overview', 'media' => null, 'city' => 'gujarat',
            'k' => ['gujarat', 'gujarat media', 'in gujarat', 'across gujarat', 'gujarat options'],
            'a' => "Across Gujarat we offer **2000+ hoarding sites**, unipoles and gantries, **7000+ GSRTC buses** reaching every district, plus city formats in Ahmedabad (900+ AMTS buses, 400+ bus shelters) and 200+ full-wrap rights on Surat electric buses.",
            'links' => [['OOH media in Gujarat', '/media/ooh'], ['GSRTC buses', '/gsrtc-bus-advertising']], 'next' => ['Plan a statewide campaign', 'GSRTC details']],

        // ---- Company ------------------------------------------------------
        ['id' => 'company', 'media' => null, 'city' => null,
            'k' => ['about', 'company', 'who are you', 'krishna outdoor', 'history', 'since 1985', '1985', 'founded', 'experience', 'years', 'legacy', 'tell me about', 'what do you do'],
            'a' => "Krishna Outdoor is an outdoor and transit advertising company working since **1985**, with offices in **Ahmedabad** (head office) and **Mumbai**.\nWe hold rights on hoardings, city and state buses, bus shelters and Mumbai local trains, and we also support print, electronic, digital and social media through the legacy of Rakesh Advertising.",
            'links' => [['About Krishna Outdoor', '/about']], 'next' => ['What media do you offer?', 'Who leads the company?', 'Which brands have you worked with?']],
        ['id' => 'leadership', 'media' => null, 'city' => null,
            'k' => ['owner', 'founder', 'chairman', 'director', 'md', 'managing director', 'leadership', 'rakesh gandhi', 'kevin gandhi', 'management', 'who runs'],
            'a' => "Krishna Outdoor is led by **Rakesh Gandhi** (Chairman & Managing Director) and **Kevin Gandhi** (Director).",
            'links' => [['Meet the team', '/about#leadership']], 'next' => ['Tell me about the company', 'How do I contact you?']],
        ['id' => 'clients', 'media' => null, 'city' => null,
            'k' => ['clients', 'brands', 'customers', 'worked with', 'portfolio', 'campaigns', 'case study', 'case studies', 'projects', 'our work', 'references', 'examples'],
            'a' => "Our clients section includes brands such as Airtel, Apple, Audi, Havells, Hyundai, JioHotstar, KitKat, L'Oréal, Mercedes, Porsche, Spotify, TRESemmé, Vadilal and Zoho. Campaign examples (BEST bus wraps, Mumbai local trains, TMT buses, hoardings) are on the Our Work page, each with its own case-study page.",
            'links' => [['Our campaigns', '/projects']], 'next' => ['Show BEST bus campaigns', 'How do I start a campaign?']],
        ['id' => 'media-overview', 'media' => null, 'city' => null,
            'k' => ['media', 'services', 'what do you offer', 'offer', 'solutions', 'formats', 'types of advertising', 'options', 'what can you', 'all media', 'everything'],
            'a' => "Here is what we offer:\n• **Outdoor:** hoardings, unipoles and gantries (2000+ sites in Gujarat, 300+ own in Ahmedabad) and 400+ backlit bus shelters\n• **Transit:** 900+ AMTS buses, 7000+ GSRTC buses, 400+ BEST EV buses, 350+ TMT buses, Mumbai local trains (Western and Central Railway)\n• **Digital:** DOOH screens in Ahmedabad and social media marketing\n• **Print and electronic:** newspaper, radio, TV and OTT, plus branding support",
            'links' => [['All media solutions', '/services']], 'next' => ['I need help choosing', 'Compare hoardings and buses', 'Get a free site list']],

        // ---- Contact / offices --------------------------------------------
        ['id' => 'contact', 'media' => null, 'city' => null,
            'k' => ['contact', 'phone', 'call', 'number', 'mobile', 'email', 'mail', 'whatsapp', 'reach you', 'talk to', 'speak', 'human', 'person', 'team', 'callback', 'call back'],
            'a' => "You can reach the team directly:\n**Ahmedabad:** +91 98796 16411\n**Mumbai:** +91 99200 11574\nEmail: info@krishnaoutdoor.in\nOr leave your name and mobile number here and I'll pass it to the team.",
            'links' => [['Call Ahmedabad', 'tel:+919879616411'], ['Call Mumbai', 'tel:+919920011574'], ['Free site list form', '/free-site-list']], 'next' => ['Where are your offices?', 'Get a free site list']],
        ['id' => 'office-ahmedabad', 'media' => null, 'city' => 'ahmedabad',
            'k' => ['office', 'address', 'location of office', 'head office', 'where are you', 'visit', 'navrangpura', 'ahmedabad office'],
            'a' => "**Ahmedabad Head Office:** Aakanksha Complex, 403-404, Netaji Rd, nr. Railway Crossing, Navrangpura, Ahmedabad, Gujarat 380009\nPhone: +91 98796 16411",
            'links' => [['Open the Contact page', '/contact']], 'next' => ['Mumbai office address']],
        ['id' => 'office-mumbai', 'media' => null, 'city' => 'mumbai',
            'k' => ['office', 'address', 'mumbai office', 'andheri', 'morya blue moon', 'where are you', 'visit'],
            'a' => "**Mumbai Office:** 701-702 Morya Blue Moon, Off New Link Road, Andheri West, Mumbai, Maharashtra 400053\nPhone: +91 99200 11574",
            'links' => [['Open the Contact page', '/contact']], 'next' => ['Ahmedabad office address']],

        // ---- Hoardings -----------------------------------------------------
        ['id' => 'hoarding-what', 'media' => 'hoarding', 'city' => 'ahmedabad',
            'k' => ['hoarding', 'hoardings', 'billboard', 'billboards', 'how many hoardings', 'sites', 'own hoardings', '300', '2000', 'outdoor advertising ahmedabad'],
            'a' => "In Ahmedabad Krishna Outdoor **owns 300+ hoardings**, and we have access to **2000+ hoarding sites across Gujarat**. Because the sites are ours we can show real, verifiable locations rather than a generic list.",
            'links' => [['Hoarding advertising in Ahmedabad', '/hoarding-advertising-ahmedabad']], 'next' => ['Hoarding formats', 'What does a hoarding cost?', 'Get a hoarding site list']],
        ['id' => 'hoarding-formats', 'media' => 'hoarding', 'city' => null,
            'k' => ['frontlit', 'backlit', 'unipole', 'unipoles', 'gantry', 'gantries', 'formats', 'what formats', 'which formats', 'formats available', 'types of hoardings', 'difference', 'lit', 'night'],
            'a' => "Hoarding formats we offer:\n• **Frontlit:** lit from external floodlights for day and night visibility\n• **Backlit:** illuminated from behind the print, brighter and sharper at night\n• **Unipoles and gantries:** single-pole and overhead structures on highways and major junctions for maximum reach",
            'links' => [['Hoarding formats', '/hoarding-advertising-ahmedabad']], 'next' => ['What does a hoarding cost?', 'How does booking work?']],
        ['id' => 'media-ooh-gujarat', 'media' => 'hoarding', 'city' => 'gujarat',
            'k' => ['gujarat hoardings', 'ooh gujarat', 'across gujarat', 'gujarat outdoor', 'unipoles gujarat', 'other cities'],
            'a' => "Our OOH network covers **2000+ hoarding sites across Gujarat**, plus unipoles and gantries, and 400+ backlit bus shelters in Ahmedabad. Tell me your target city and I'll point you to what we can offer there.",
            'links' => [['OOH media in Gujarat', '/media/ooh']], 'next' => ['Plan a statewide campaign', 'Get a free site list']],

        // ---- AMTS ----------------------------------------------------------
        ['id' => 'amts-what', 'media' => 'amts', 'city' => 'ahmedabad',
            'k' => ['amts', 'ahmedabad bus', 'city bus', 'bus advertising ahmedabad', 'how many buses', '900', 'municipal transport'],
            'a' => "We hold advertising rights on **900+ AMTS city buses** in Ahmedabad. AMTS buses run fixed routes across the city every day, so one booking reaches many neighbourhoods and the same commuters see your ad repeatedly.",
            'links' => [['AMTS bus advertising', '/amts-bus-advertising-ahmedabad']], 'next' => ['AMTS formats', 'AMTS vs hoardings', 'Get an AMTS bus list']],
        ['id' => 'amts-formats', 'media' => 'amts', 'city' => null,
            'k' => ['wrap', 'full wrap', 'side panel', 'back panel', 'panel', 'formats', 'what formats', 'which formats', 'formats available', 'bus formats'],
            'a' => "On AMTS buses you can choose:\n• **Full wrap:** the whole exterior becomes your brand\n• **Side panel:** a large printed panel along the bus body\n• **Back panel:** faces following traffic, so it stays in view at every stop and signal",
            'links' => [['AMTS formats', '/amts-bus-advertising-ahmedabad']], 'next' => ['What affects the cost?', 'Can I choose the routes?']],
        ['id' => 'amts-routes', 'media' => 'amts', 'city' => 'ahmedabad',
            'k' => ['route', 'routes', 'areas', 'which route', 'choose route', 'coverage'],
            'a' => "Yes. Share your target neighbourhoods or customer profile and the team will recommend buses whose routes overlap with where your audience lives, works or shops. I can't list route numbers here, so the free site list is the best next step.",
            'links' => [['Get the AMTS route list', '/free-site-list?media=amts&city=Ahmedabad']], 'next' => ['What affects the cost?']],

        // ---- Bus shelters --------------------------------------------------
        ['id' => 'shelter-what', 'media' => 'shelter', 'city' => 'ahmedabad',
            'k' => ['shelter', 'shelters', 'bus shelter', 'bus stop', 'bus stand', 'backlit shelter', '400', 'dwell', 'commuters waiting'],
            'a' => "We hold advertising rights on **400+ backlit bus shelters** across Ahmedabad. Commuters wait at a stop for minutes, so a shelter panel can carry more message (a product detail, an offer, even a QR code) and it stays lit and legible after dark.",
            'links' => [['Bus shelter advertising', '/bus-shelter-advertising-ahmedabad']], 'next' => ['Shelters with AMTS buses', 'What affects the cost?', 'Get a shelter list']],

        // ---- GSRTC ---------------------------------------------------------
        ['id' => 'gsrtc-what', 'media' => 'gsrtc', 'city' => 'gujarat',
            'k' => ['gsrtc', 'state transport', 'st bus', 'statewide', 'state wide', 'all districts', 'every district', '7000', 'gujarat bus', 'rural', 'small towns'],
            'a' => "We hold advertising rights on **7000+ GSRTC buses**. GSRTC buses connect every district of Gujarat, including smaller towns and rural routes that a hoarding network or city bus can't reach, so it is the format for true state-wide reach.",
            'links' => [['GSRTC bus advertising', '/gsrtc-bus-advertising']], 'next' => ['Who uses GSRTC advertising?', 'GSRTC formats', 'Get a GSRTC fleet list']],
        ['id' => 'gsrtc-who', 'media' => 'gsrtc', 'city' => null,
            'k' => ['who uses', 'suits', 'best for', 'fmcg', 'recruit', 'recruitment', 'education', 'government', 'psu', 'launch statewide'],
            'a' => "GSRTC advertising suits brands that need to be seen across the whole state: FMCG companies launching a product statewide, education institutions recruiting from several districts, and government or PSU campaigns that must reach people beyond the big cities. It also pairs well with Ahmedabad hoardings or AMTS buses for the capital.",
            'links' => [['GSRTC bus advertising', '/gsrtc-bus-advertising']], 'next' => ['Plan a statewide campaign']],
        ['id' => 'gsrtc-formats', 'media' => 'gsrtc', 'city' => null,
            'k' => ['formats', 'what formats', 'which formats', 'wrap', 'panel', 'gsrtc formats'],
            'a' => "On GSRTC buses we offer **full wraps** for maximum visibility on highway and intercity routes, and **panel formats** (side or back) for a presence across more buses at a lower per-bus cost.",
            'links' => [['GSRTC formats', '/gsrtc-bus-advertising']], 'next' => ['What affects the cost?']],

        // ---- Mumbai --------------------------------------------------------
        ['id' => 'mumbai-overview', 'media' => null, 'city' => 'mumbai',
            'k' => ['mumbai', 'mumbai advertising', 'outdoor advertising agency mumbai', 'mumbai portfolio', 'mumbai media', 'bombay'],
            'a' => "In Mumbai we offer a connected transit portfolio from one agency and one office:\n• **Mumbai local trains** on Western and Central Railway (exterior branding)\n• **400+ BEST EV full-wrap buses**\n• **350+ TMT buses** serving Thane\nOur Mumbai office is in Andheri West, phone +91 99200 11574.",
            'links' => [['Outdoor advertising agency in Mumbai', '/outdoor-advertising-agency-mumbai']], 'next' => ['Mumbai local train advertising', 'BEST bus advertising', 'Get a Mumbai site list']],
        ['id' => 'train-what', 'media' => 'train', 'city' => 'mumbai',
            'k' => ['train', 'local train', 'mumbai local', 'railway', 'western railway', 'central railway', 'wr', 'cr', 'rake', 'train branding', 'commuters'],
            'a' => "We hold display rights on **Mumbai local trains across the Western and Central Railway lines**. The format is exterior train branding, seen by daily commuters, by people on platforms and by traffic alongside the line, so one branded rake is seen well beyond its own passengers.",
            'links' => [['Mumbai local train advertising', '/mumbai-local-train-advertising']], 'next' => ['How early should I book?', 'Train vs BEST buses', 'Get a train availability list']],
        ['id' => 'train-lead', 'media' => 'train', 'city' => 'mumbai',
            'k' => ['how early', 'lead time', 'in advance', 'launch date', 'approval', 'train booking time', 'how early should i book'],
            'a' => "Train branding involves coordination with the railway authorities as well as printing and installation, so we recommend starting the conversation **three to four weeks before your planned launch** to confirm availability and get creative approved.",
            'links' => [['Mumbai local train advertising', '/mumbai-local-train-advertising']], 'next' => ['What affects the cost?']],
        ['id' => 'best-what', 'media' => 'best', 'city' => 'mumbai',
            'k' => ['best', 'best bus', 'ev bus', 'electric bus', 'full wrap', '400', 'mumbai bus', 'brihanmumbai', 'bus wrap mumbai'],
            'a' => "We hold advertising rights on **400+ BEST EV full-wrap buses** in Mumbai. A full wrap covers the bus end to end, so the creative reads as one continuous image on a moving, full-colour canvas that travels Mumbai's roads all day.",
            'links' => [['BEST bus advertising', '/best-bus-advertising-mumbai']], 'next' => ['Design and approval for wraps', 'Combine BEST and trains', 'Get a BEST fleet list']],
        ['id' => 'best-design', 'media' => 'best', 'city' => null,
            'k' => ['design', 'creative', 'specs', 'artwork', 'approval', 'print', 'wrap design'],
            'a' => "Wrap creative has to work with the bus's real structure (windows, doors and panel seams). Our production team checks every design for print feasibility before printing and coordinates the approvals needed to mount a wrap on a BEST bus.",
            'links' => [['BEST bus advertising', '/best-bus-advertising-mumbai']], 'next' => ['What affects the cost?']],
        ['id' => 'best-thane', 'media' => 'best', 'city' => 'thane',
            'k' => ['best thane', 'does best cover thane', 'best cover thane', 'best in thane', 'best bus thane'],
            'a' => "BEST buses run routes across Mumbai's suburbs and island city. For Thane we hold rights on **350+ TMT buses**, and many brands combine TMT with BEST buses if their customers travel between the two.",
            'links' => [['TMT bus advertising in Thane', '/tmt-bus-advertising-thane'], ['BEST bus advertising', '/best-bus-advertising-mumbai']], 'next' => ['TMT bus details', 'Plan a Mumbai and Thane campaign']],
        ['id' => 'tmt-what', 'media' => 'tmt', 'city' => 'thane',
            'k' => ['tmt', 'thane', 'thane bus', 'thane municipal', '350', 'thane advertising'],
            'a' => "We hold advertising rights on **350+ TMT (Thane Municipal Transport) buses** serving Thane and neighbouring areas. Thane has grown fast but carries less outdoor clutter than central Mumbai, so a TMT campaign often competes for less attention. You can choose **full branding** or **partial branding** (side and back panels).",
            'links' => [['TMT bus advertising in Thane', '/tmt-bus-advertising-thane']], 'next' => ['TMT vs Mumbai buses', 'Get a TMT fleet list']],

        // ---- Digital, social, print ---------------------------------------
        ['id' => 'dooh', 'media' => 'dooh', 'city' => 'ahmedabad',
            'k' => ['dooh', 'digital', 'digital billboard', 'digital screen', 'screens', 'led', 'digital out of home', 'dynamic', 'dayparting'],
            'a' => "Digital out-of-home (DOOH) means digital billboards and screens in prime, high-traffic spots in Ahmedabad. They allow dynamic creative, scheduled campaigns (different ads at different times of day) and faster changes than a printed hoarding. I don't have screen counts to quote, so ask the team for current screens, rates and specifications.",
            'links' => [['Digital out-of-home advertising', '/media/digital']], 'next' => ['DOOH vs hoardings', 'Get a DOOH list']],
        ['id' => 'social', 'media' => 'social', 'city' => null,
            'k' => ['social', 'social media', 'instagram', 'facebook', 'linkedin', 'youtube', 'paid ads', 'content', 'reels', 'digital marketing', 'smm', 'online'],
            'a' => "We run social media marketing across **Instagram, Facebook, LinkedIn and YouTube**: strategy, content, paid social ads and reporting. It can be booked on its own or paired with a hoarding, bus or train campaign so the street visibility continues online.",
            'links' => [['Social media marketing in Ahmedabad', '/social-media-marketing-ahmedabad'], ['Social media marketing in Mumbai', '/social-media-marketing-mumbai']], 'next' => ['Outdoor plus social ideas', 'What does it cost?']],
        ['id' => 'print', 'media' => 'print', 'city' => null,
            'k' => ['newspaper', 'print', 'radio', 'tv', 'television', 'ott', 'electronic', 'press release', 'ins agency', 'rakesh advertising'],
            'a' => "Beyond outdoor, we support **newspaper, radio, television and OTT** advertising through media planning and INS agency capabilities strengthened by the legacy of Rakesh Advertising. Share your market, readership and objective and the team will suggest options.",
            'links' => [['Media solutions', '/services']], 'next' => ['Get in touch']],
        ['id' => 'branding', 'media' => 'branding', 'city' => null,
            'k' => ['branding', 'brand identity', 'logo design', 'creative', 'campaign creative', 'marketing support', 'design'],
            'a' => "Our branding solutions cover brand communication, campaign creative and marketing support, so your creative works in the environment where it will be seen (a bus wrap reads differently from a shelter panel).",
            'links' => [['Media solutions', '/services']], 'next' => ['Get in touch']],
        ['id' => 'surat-jaipur', 'media' => 'surat', 'city' => null,
            'k' => ['surat', 'ev bus surat', 'jaipur', 'rajasthan', 'other cities', 'outside gujarat'],
            'a' => "Beyond Ahmedabad and Mumbai we also offer **200+ full-wrap rights on Surat city electric buses** and selected transit opportunities on **Jaipur city buses**.",
            'links' => [['Our network', '/our-network']], 'next' => ['Get a free site list']],

        // ---- Process / pricing / comparisons -------------------------------
        ['id' => 'pricing', 'media' => null, 'city' => null,
            'k' => ['price', 'pricing', 'cost', 'rate', 'rates', 'discount', 'negotiate', 'cheaper', 'offer price', 'how much', 'budget', 'charges', 'quote', 'quotation', 'expensive', 'cheap', 'affordable', 'per month', 'rent'],
            'a' => "I can't quote a price here because rates depend on the site and campaign. What drives the cost:\n• **The format** (a full wrap costs more than a panel; backlit more than frontlit)\n• **The location or routes** (busy corridors cost more than quiet ones)\n• **How many sites or buses** you book\n• **The duration** (longer bookings usually lower the effective monthly cost)\nShare your city, media type and budget and the team will send indicative rates with a free site list.",
            'links' => [['Get a free site list', '/free-site-list']], 'next' => ['Get a free site list', 'Talk to the team']],
        ['id' => 'booking', 'media' => null, 'city' => null,
            'k' => ['book', 'booking', 'how to start', 'process', 'steps', 'how does it work', 'get started', 'start campaign', 'procedure', 'how do i advertise', 'advertise with you'],
            'a' => "Booking is simple:\n1. Tell us your city, media type, audience and budget\n2. We share available sites or buses with photos, sizes, routes and rates\n3. You confirm and send your creative for printing\n4. We mount it and share live photos once it is up\nThe quickest start is the free site list: our team usually replies within one business day.",
            'links' => [['Get a free site list', '/free-site-list']], 'next' => ['Get a free site list', 'I need help choosing']],
        ['id' => 'site-list', 'media' => null, 'city' => null,
            'k' => ['site list', 'free site list', 'availability', 'available', 'availability list', 'fleet list', 'route list', 'location list', 'check availability', 'send me'],
            'a' => "The free site list shows available sites or buses for your city and media type, with locations and rates. I can take your details right here (name and mobile number), or you can use the form.",
            'links' => [['Open the free site list form', '/free-site-list']], 'next' => ['Take my details', 'Call the team']],
        ['id' => 'compare-hoarding-bus', 'media' => null, 'city' => null,
            'k' => ['hoarding vs bus', 'hoardings or buses', 'bus or hoarding', 'compare', 'difference between', 'which is better', 'better', 'versus', 'vs'],
            'a' => "A quick way to think about it:\n• **Hoardings** sit at one fixed, prime spot: strong presence where your audience passes\n• **Buses** (AMTS, BEST, TMT, GSRTC) move through many neighbourhoods daily: broader reach and repeated exposure\n• **Bus shelters** give minutes of dwell time: room for more message\n• **Local trains** give mass daily commuter reach in Mumbai\nMany brands combine formats. Tell me your city and goal and I'll suggest a mix.",
            'links' => [['All media solutions', '/services']], 'next' => ['I need help choosing', 'Hoardings vs AMTS', 'Shelters vs buses']],
        ['id' => 'compare-amts-hoarding', 'media' => 'amts', 'city' => 'ahmedabad',
            'k' => ['amts vs hoarding', 'hoarding vs amts', 'buses cheaper', 'amts or hoarding', 'bus vs hoarding ahmedabad'],
            'a' => "For city-wide reach, AMTS buses are typically a more cost-effective way to cover Ahmedabad than booking several separate hoarding sites, because one bus crosses many neighbourhoods every day and its routes repeat. A hoarding is better when you want a strong fixed presence at a specific prime location. Many brands run both.",
            'links' => [['AMTS buses', '/amts-bus-advertising-ahmedabad'], ['Hoardings', '/hoarding-advertising-ahmedabad']], 'next' => ['Plan an Ahmedabad campaign']],
        ['id' => 'compare-shelter-bus', 'media' => 'shelter', 'city' => 'ahmedabad',
            'k' => ['shelter vs bus', 'shelters with amts', 'combine shelter', 'shelter and bus', 'layer'],
            'a' => "Bus shelters and AMTS buses work well together: the moving buses build broad, repeated city-wide recall, and the shelters reinforce the same message at fixed points where people stop and have time to read it. Your brand is then seen both in motion and at rest.",
            'links' => [['Bus shelters', '/bus-shelter-advertising-ahmedabad'], ['AMTS buses', '/amts-bus-advertising-ahmedabad']], 'next' => ['Plan an Ahmedabad campaign']],
        ['id' => 'compare-train-best', 'media' => 'train', 'city' => 'mumbai',
            'k' => ['train vs best', 'best vs train', 'train and best', 'combine train', 'rail and road'],
            'a' => "In Mumbai, local trains give mass daily commuter reach along the Western and Central lines, while BEST buses reach neighbourhoods the rail network doesn't directly serve. Many brands combine a train wrap with BEST (or TMT) buses for layered reach across rail and road commuters.",
            'links' => [['Mumbai hub', '/outdoor-advertising-agency-mumbai']], 'next' => ['Plan a Mumbai campaign']],
        ['id' => 'outdoor-social', 'media' => 'social', 'city' => null,
            'k' => ['outdoor plus social', 'outdoor and social', 'combine social', 'integrated', 'offline online', 'pair', 'together', 'connected campaign', '360'],
            'a' => "Outdoor builds physical visibility, social extends it. For example: photos of the hoarding going up, short clips of the branded bus on its route, or paid social ads that echo the outdoor creative give people a second, more personal touchpoint after they've seen the campaign on the street.",
            'links' => [['Social media marketing', '/social-media-marketing-ahmedabad']], 'next' => ['Plan a campaign for me']],

        // ---- Careers / site / meta -----------------------------------------
        ['id' => 'careers', 'media' => null, 'city' => null,
            'k' => ['career', 'careers', 'job', 'jobs', 'hiring', 'vacancy', 'opening', 'openings', 'work with you', 'internship', 'join', 'apply'],
            'a' => "You can apply on the Careers page. Roles span sales, operations, design, client servicing, digital and administration, and the form takes your details and CV.",
            'links' => [['Careers at Krishna Outdoor', '/careers']], 'next' => ['Contact the team']],
        ['id' => 'pages', 'media' => null, 'city' => null,
            'k' => ['pages', 'website', 'links', 'sitemap', 'navigate', 'where can i find'],
            'a' => "Quick links:\n• Media solutions and all services\n• Hoardings, AMTS, bus shelters, GSRTC (Gujarat)\n• Mumbai agency, local trains, BEST, TMT (Mumbai and Thane)\n• Our work and network",
            'links' => [['Media solutions', '/services'], ['Our network', '/our-network'], ['Our work', '/projects'], ['Contact', '/contact']], 'next' => ['Get a free site list']],
        ['id' => 'bot-identity', 'media' => null, 'city' => null,
            'k' => ['are you a bot', 'are you human', 'who are you', 'your name', 'what are you', 'ai', 'chatbot', 'robot'],
            'a' => "I'm Krishna AI, the virtual assistant for Krishna Outdoor. I know our media, formats, offices and process, I remember what you tell me during the chat, and I can help you plan a campaign or pass your details to the team. For anything I can't answer (prices, exact availability), a human on the team will.",
            'links' => [], 'next' => ['Help me plan a campaign', 'Talk to a person']],
    ],

];
