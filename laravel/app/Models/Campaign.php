<?php

namespace App\Models;

use App\Traits\HasSeoMeta;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Campaign extends Model
{
    use HasFactory, HasUuids, SoftDeletes, HasSeoMeta;

    protected $casts = [
        'gallery' => 'array',
    ];

    /**
     * Every campaign has a stable URL slug (/projects/{slug}) and its own
     * SeoMeta row, so it shows up in the SEO admin panel without set-up.
     */
    protected static function booted(): void
    {
        static::creating(function (Campaign $campaign) {
            if (!$campaign->slug) {
                $campaign->slug = static::uniqueSlug($campaign->name, $campaign->city);
            }
        });

        static::created(function (Campaign $campaign) {
            if (!$campaign->seo()->exists()) {
                $campaign->seo()->create([]);
            }
        });
    }

    public static function uniqueSlug(string $name, ?string $city = null, ?string $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'campaign';
        $candidates = [$base, Str::slug($base . ' ' . $city)];
        foreach ($candidates as $candidate) {
            if ($candidate !== '' && !static::slugTaken($candidate, $ignoreId)) {
                return $candidate;
            }
        }
        for ($i = 2; ; $i++) {
            if (!static::slugTaken($base . '-' . $i, $ignoreId)) {
                return $base . '-' . $i;
            }
        }
    }

    private static function slugTaken(string $slug, ?string $ignoreId): bool
    {
        return static::withTrashed()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists();
    }

    public function mediaLabel(): string
    {
        return config('campaigns.media_labels')[$this->media_type] ?? ucfirst((string) $this->media_type);
    }

    public function url(): string
    {
        return route('view.project.show', ['slug' => $this->slug]);
    }

    /** Lower-case letters and digits only, so "Kala-Kendra" matches "Kala Kendra". */
    public static function normalize(string $name): string
    {
        return preg_replace('/[^a-z0-9]+/', '', strtolower($name));
    }

    public function matches(string $brand): bool
    {
        $needle = static::normalize($brand);

        return $needle !== '' && str_contains(static::normalize($this->name), $needle);
    }

    /**
     * Route name of the keyword page this case study proves (the first page in
     * config/campaigns.php that lists it), or null.
     */
    public function keywordRoute(): ?string
    {
        foreach (config('campaigns.keyword_pages') as $route => $brands) {
            foreach ($brands as $brand) {
                if ($this->matches($brand)) {
                    return $route;
                }
            }
        }

        return null;
    }

    /**
     * Active campaigns a keyword page lists, in the order configured.
     *
     * @return Collection<int, Campaign>
     */
    public static function forKeywordPage(string $route): Collection
    {
        $brands = config('campaigns.keyword_pages')[$route] ?? [];
        $campaigns = static::where('status', true)->get();

        return collect($brands)
            ->map(fn ($brand) => $campaigns->first(fn (Campaign $campaign) => $campaign->matches($brand)))
            ->filter()
            ->unique('id')
            ->values();
    }

    /** Alt text for the main image: the admin's, else format + city + brand. */
    public function imageAlt(): string
    {
        return $this->image_alt ?: "{$this->name} {$this->mediaLabel()} campaign in {$this->city} – Krishna Outdoor";
    }
}
