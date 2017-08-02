<?php

declare(strict_types=1);

namespace Cortex\Attributable\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Attributable\Models\Attribute as BaseAttribute;

/**
 * Cortex\Attributable\Models\Attribute.
 *
 * @property int                                                                                 $id
 * @property string                                                                              $slug
 * @property string                                                                              $name
 * @property string                                                                              $description
 * @property int                                                                                 $sort_order
 * @property string|null                                                                         $group
 * @property string                                                                              $type
 * @property int                                                                                 $is_required
 * @property int                                                                                 $is_collection
 * @property string|null                                                                         $default
 * @property \Carbon\Carbon|null                                                                 $created_at
 * @property \Carbon\Carbon|null                                                                 $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property \Illuminate\Support\Collection|null                                                 $entities
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Attributable\Models\Attribute ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributable\Models\Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributable\Models\Attribute whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributable\Models\Attribute whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributable\Models\Attribute whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributable\Models\Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributable\Models\Attribute whereIsCollection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributable\Models\Attribute whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributable\Models\Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributable\Models\Attribute whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributable\Models\Attribute whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributable\Models\Attribute whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributable\Models\Attribute whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Attribute extends BaseAttribute
{
    use LogsActivity;

    /**
     * Indicates whether to log only dirty attributes or all.
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * The attributes that are logged on change.
     *
     * @var array
     */
    protected static $logAttributes = [
        'name',
        'slug',
        'description',
        'sort_order',
        'group',
        'type',
        'entities',
        'is_required',
        'is_collection',
        'default',
    ];

    /**
     * The attributes that are ignored on change.
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
