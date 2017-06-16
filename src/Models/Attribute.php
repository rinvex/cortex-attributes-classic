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
 * @property int                                 $order
 * @property string                              $group
 * @property string                              $type
 * @property bool                                $collection
 * @property string                              $default
 * @property \Carbon\Carbon                      $created_at
 * @property \Carbon\Carbon                      $updated_at
 * @property \Illuminate\Support\Collection|null $entities
 *
 * @method static \Illuminate\Database\Query\Builder|\Cortex\Attributable\Models\Attribute ordered($direction = 'asc')
 * @method static \Illuminate\Database\Query\Builder|\Cortex\Attributable\Models\Attribute whereCollection($value)
 * @method static \Illuminate\Database\Query\Builder|\Cortex\Attributable\Models\Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Cortex\Attributable\Models\Attribute whereDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\Cortex\Attributable\Models\Attribute whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Cortex\Attributable\Models\Attribute whereGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\Cortex\Attributable\Models\Attribute whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Cortex\Attributable\Models\Attribute whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Cortex\Attributable\Models\Attribute whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\Cortex\Attributable\Models\Attribute whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Cortex\Attributable\Models\Attribute whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Cortex\Attributable\Models\Attribute whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Attribute extends BaseAttribute
{
    //
}
