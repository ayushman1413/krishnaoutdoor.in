<?php

namespace App\Http\Controllers\Web;

use App\Enums\MediaType;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Services\SeoResolver;
use Exception;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    /**
     * View Locations By City
     *
     * @return mixed
     */
    public function viewByCity(string $city): mixed
    {
        try {

            $city_name = str_replace('-', ' ', $city);

            $locations = Location::where('status', true)
                ->whereRaw('LOWER(city) = ?', [strtolower($city_name)])
                ->orderBy('area')
                ->get();

            if ($locations->isEmpty()) {
                abort(404);
            }

            $media_type = MediaType::class;
            $cityName = $locations->first()->city;

            $seo = SeoResolver::forRoute(
                SeoResolver::routeNameForCity($cityName),
                $cityName . ' Locations',
                "Explore our available outdoor advertising media - billboards, bus branding, train media and more - across {$cityName}."
            );

            return view('web.pages.locations', [
                'city' => $cityName,
                'locations' => $locations,
                'media_type' => $media_type,
                'seo' => $seo,
            ]);
        } catch (Exception $exception) {
            abort(404);
        }
    }

    /**
     * All active locations as JSON
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listJson()
    {
        $locations = Location::where('status', true)
            ->orderBy('city')
            ->orderBy('area')
            ->get();

        return response()->json(['status' => 'success', 'data' => $locations]);
    }
}