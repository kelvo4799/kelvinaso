<?
namespace App\Services;

use Illuminate\Support\Facades\Cache;

class BaseCacheService {

     /**
     * Define the default cache duration (e.g., 24 hours).
     * Child classes can override this if they want!
     */
    protected int $defaultTtlHours = 24;

    /**
     * A unified wrapper for remembering data.
     */
    protected function remember(string $key, ?int $ttlHours = null, \Closure $callback)
    {
        $hours = $ttlHours ?? $this->defaultTtlHours;
        return Cache::remember($key, now()->addHours($hours), $callback);
    }

    /**
     * A unified wrapper for getting data with a default fallback.
     */
    protected function get(string $key, mixed $default = null)
    {
        return Cache::get($key, $default);
    }

    /**
     * A unified wrapper for setting data.
     */
    protected function put(string $key, mixed $value, ?int $ttlHours = null): void
    {
        if ($ttlHours) {
            Cache::put($key, $value, now()->addHours($ttlHours));
        } else {
            Cache::forever($key, $value); // Default to forever for global settings
        }
    }

    /**
     * A unified wrapper for deleting data.
     */
    protected function forget(string $key): void
    {
        Cache::forget($key);
    }

    
}