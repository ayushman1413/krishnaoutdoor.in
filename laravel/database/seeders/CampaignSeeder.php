<?php

namespace Database\Seeders;

use App\Models\Campaign;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    public function run(): void
    {
        if (Campaign::count() > 0) return;

        $rows = [
            ['Outdoor Campaign', 'Launching a New Campaign', 'outdoor', 'Ahmedabad', 'A premium outdoor campaign designed to build awareness and visibility across a high-traffic city corridor.', 'ooh-hoarding-campaign-01.png'],
            ['Jio', 'Expanding Market Presence', 'transit', 'Mumbai', 'Transit visibility designed to reach commuters repeatedly across high-frequency urban movement corridors.', 'digital-billboard-campaign-03.png'],
            ['Havells', 'Building Brand Recall', 'outdoor', 'Ahmedabad', 'High-visibility outdoor placement built to reinforce brand recall where audiences travel every day.', 'outdoor-campaign-02.png'],
            ['Brand Campaign', 'Driving Footfall', 'transit', 'Ahmedabad', 'A high-frequency city environment used to create repeated exposure and stronger everyday visibility.', 'transit-bus-campaign-06.jpg'],
            ['Premium OOH', 'Launching a New Project', 'outdoor', 'Mumbai', 'A premium digital outdoor placement combining strong creative presence with an urban night audience.', 'premium-outdoor-campaign-05.png'],
            ['Hyundai', 'Showcasing a New Possibility', 'integrated', 'Other Markets', 'An integrated visibility approach connecting outdoor impact with broader campaign touchpoints.', 'brand-billboard-campaign-04.png'],
        ];

        foreach ($rows as [$name, $tagline, $type, $city, $desc, $img]) {
            Campaign::forceCreate([
                'name' => $name,
                'tagline' => $tagline,
                'media_type' => $type,
                'city' => $city,
                'description' => $desc,
                'image' => 'campaigns/' . $img,
                'status' => true,
            ]);
        }
    }
}