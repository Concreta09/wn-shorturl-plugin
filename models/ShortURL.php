<?php namespace Concreta\ShortURL\Models;

use Model;
use Config;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ShortURL.
 *
 * @property int $id
 * @property string $destination_url
 * @property string $default_short_url
 * @property string $url_key
 * @property bool $single_use
 * @property bool $forward_query_params
 * @property bool $track_visits
 * @property int $redirect_status_code
 * @property bool $track_ip_address
 * @property bool $track_operating_system
 * @property bool $track_operating_system_version
 * @property bool $track_browser
 * @property bool $track_browser_version
 * @property bool $track_referer_url
 * @property bool $track_device_type
 * @property Carbon|null $activated_at
 * @property Carbon|null $deactivated_at
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ShortURL extends Model
{

    use HasFactory;

    use \Winter\Storm\Database\Traits\Validation;

    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $fillable = [
        'destination_url',
        'default_short_url',
        'url_key',
        'single_use',
        'forward_query_params',
        'track_visits',
        'redirect_status_code',
        'track_ip_address',
        'track_operating_system',
        'track_operating_system_version',
        'track_browser',
        'track_browser_version',
        'track_referer_url',
        'track_device_type',
        'activated_at',
        'deactivated_at',
    ];


    protected $dates = [
        'activated_at',
        'deactivated_at',
        'deleted_at',
        'created_at',
        'updated_at',
    ];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'concreta_shorturl_shorturls';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'single_use'                     => 'boolean',
        'forward_query_parameters'       => 'boolean',
        'track_visits'                   => 'boolean',
        'track_ip_address'               => 'boolean',
        'track_operating_system'         => 'boolean',
        'track_operating_system_version' => 'boolean',
        'track_browser'                  => 'boolean',
        'track_browser_version'          => 'boolean',
        'track_referer_url'              => 'boolean',
        'track_device_type'              => 'boolean',
        'activated_at'                   => 'datetime',
        'deactivated_at'                 => 'datetime',
    ];

    /**
     * A short URL can be visited many times.
     */
    public $hasMany = [
        'visits' => [
            \Concreta\ShortURL\Models\ShortURLVisit::class,
            'key' => 'short_url_id'
        ]
    ];


    /**
     * @return Factory<ShortURL>
     */
    protected static function newFactory()
    {
        $factoryConfig = Config::get('concreta.shorturl::factories');
         
        $modelFactory = app($factoryConfig[__CLASS__]);

        return $modelFactory::new();
    }

    /**
     * A helper method that can be used for finding
     * a ShortURL model with the given URL key.
     *
     * @param  string  $URLKey
     * @return ShortURL|null
     */
    public static function findByKey(string $URLKey): ?self
    {
        return self::where('url_key', $URLKey)->first();
    }

    /**
     * A helper method that can be used for finding
     * all of the ShortURL models with the given
     * destination URL.
     *
     * @param  string  $destinationURL
     * @return Collection<int, ShortURL>
     */
    public static function findByDestinationURL(string $destinationURL): Collection
    {
        return self::where('destination_url', $destinationURL)->get();
    }

    /**
     * A helper method to determine whether if tracking
     * is currently enabled for the short URL.
     *
     * @return bool
     */
    public function trackingEnabled(): bool
    {
        return $this->track_visits;
    }

    /**
     * Return an array containing the fields that are
     * set to be tracked for the short URL.
     *
     * @return array
     */
    public function trackingFields(): array
    {
        $fields = [];

        if ($this->track_ip_address) {
            $fields[] = 'ip_address';
        }

        if ($this->track_operating_system) {
            $fields[] = 'operating_system';
        }

        if ($this->track_operating_system_version) {
            $fields[] = 'operating_system_version';
        }

        if ($this->track_browser) {
            $fields[] = 'browser';
        }

        if ($this->track_browser_version) {
            $fields[] = 'browser_version';
        }

        if ($this->track_referer_url) {
            $fields[] = 'referer_url';
        }

        if ($this->track_device_type) {
            $fields[] = 'device_type';
        }

        return $fields;
    }
}
