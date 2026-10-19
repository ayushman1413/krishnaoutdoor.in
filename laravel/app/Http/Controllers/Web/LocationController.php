<?php

namespace App\Http\Controllers\Web;

use App\Enums\MediaType;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Services\LocationPageGate;
use App\Services\SchemaBuilder;
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

            // Describe only the media actually listed for this city.
            $types = $locations->pluck('media_type')->unique()
                ->map(fn ($type) => strtolower($media_type::tryFrom($type)?->label() ?? $type))->values()->all();
            $seo = SeoResolver::forRoute(
                SeoResolver::routeNameForCity($cityName),
                $cityName . ' Locations',
                "Krishna Outdoor advertising sites in {$cityName}: " . implode(', ', $types) . '.'
            );

            // Thin listings stay out of the index until they carry real inventory.
            if (!LocationPageGate::passes($locations, $seo->meta)) {
                $seo->forceNoindex();
            }

            SchemaBuilder::setBreadcrumbs([
                ['name' => 'Our Network', 'url' => route('view.network')],
                ['name' => $cityName . ' Locations', 'url' => $seo->canonicalUrl],
            ]);

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