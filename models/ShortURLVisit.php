<?php namespace Concreta\ShortURL\Models;

use Model;
use Config;
use Carbon\Carbon;
use Winter\Storm\Database\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ShortURLVisit.
 *
 * @property int $id
 * @property int $short_url_id
 * @property string $ip_address
 * @property string $operating_system
 * @property string $operating_system_version
 * @property string $browser
 * @property string $browser_version
 * @property string $device_type
 * @property Carbon $visited_at
 * @property string $referer_url
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ShortURLVisit extends Model
{
    use HasFactory;

    use \Winter\Storm\Database\Traits\Validation;

    use \Winter\Storm\Database\Traits\SoftDelete;

    const DEVICE_TYPE_MOBILE = 'mobile';

    const DEVICE_TYPE_DESKTOP = 'desktop';

    const DEVICE_TYPE_TABLET = 'tablet';

    const DEVICE_TYPE_ROBOT = 'robot';

    protected $dates = [
        'visited_at',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'concreta_shorturl_short_url_visits';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'short_url_id',
        'ip_address',
        'operating_system',
        'operating_system_version',
        'browser',
        'browser_version',
        'visited_at',
        'referer_url',
        'device_type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'short_url_id' => 'integer',
        'visited_at'   => 'datetime',
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [];

    public $belongsTo = [
        'shortURL' => [
            \Concreta\ShortURL\Models\ShortURL::class,
            'key' => 'short_url_id',
        ]
    ];

    /**
     * @return Factory<ShortURLVisit>
     */
    protected static function newFactory()
    {
        $factoryConfig = Config::get('concreta.shorturl::factories');

        $modelFactory = app($factoryConfig[__CLASS__]);

        return $modelFactory::new();
    }

    /**
     * A URL visit belongs to one specific shortened URL.
     *
     * @return BelongsTo<ShortURL, ShortURLVisit>
     */
    public function shortURL(): BelongsTo
    {
        return $this->belongsTo(ShortURL::class, 'short_url_id');
    }
}
