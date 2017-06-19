<?php

declare(strict_types=1);

namespace Cortex\Attributable\Models;

use Rinvex\Attributable\Models\Attribute as BaseAttribute;

/**
 * Cortex\Attributable\Models\Attribute.
 *
 * @property int                                 $id
 * @property string                              $slug
 * @property array                               $name
 * @property array                               $description
 * @property int                                 $sort_order
 * @property string|null                         $group
 * @property string                              $type
 * @property int                                 $is_required
 * @property int                                 $is_collection
 * @property string|null                         $default
 * @property \Carbon\Carbon|null                 $created_at
 * @property \Carbon\Carbon|null                 $updated_at
 * @property \Illuminate\Support\Collection|null $entities
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
    //
}
