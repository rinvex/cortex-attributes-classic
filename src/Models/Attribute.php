<?php

declare(strict_types=1);

namespace Cortex\Attributes\Models;

use Illuminate\Support\Str;
use Rinvex\Tenants\Traits\Tenantable;
use Cortex\Foundation\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Rinvex\Support\Traits\HashidsTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Cortex\Attributes\Events\AttributeCreated;
use Cortex\Attributes\Events\AttributeDeleted;
use Cortex\Attributes\Events\AttributeUpdated;
use Cortex\Attributes\Events\AttributeRestored;
use Rinvex\Attributes\Models\Attribute as BaseAttribute;

/**
 * Cortex\Attributes\Models\Attribute.
 *
 * @property int                                                                               $id
 * @property string                                                                            $slug
 * @property string                                                                            $name
 * @property array                                                                             $description
 * @property int                                                                               $sort_order
 * @property string                                                                            $group
 * @property string                                                                            $type
 * @property bool                                                                              $is_required
 * @property bool                                                                              $is_collection
 * @property string                                                                            $default
 * @property \Carbon\Carbon|null                                                               $created_at
 * @property \Carbon\Carbon|null                                                               $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[]     $activity
 * @property array                                                                             $entities
 * @property-read \Rinvex\Attributes\Support\ValueCollection|\Rinvex\Attributes\Models\Value[] $values
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributes\Models\Attribute ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributes\Models\Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributes\Models\Attribute whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributes\Models\Attribute whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributes\Models\Attribute whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributes\Models\Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributes\Models\Attribute whereIsCollection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributes\Models\Attribute whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributes\Models\Attribute whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributes\Models\Attribute whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributes\Models\Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributes\Models\Attribute whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Attributes\Models\Attribute whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Attribute extends BaseAttribute
{
    use Auditable;
    use Tenantable;
    use HashidsTrait;
    use LogsActivity;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => AttributeCreated::class,
        'updated' => AttributeUpdated::class,
        'deleted' => AttributeDeleted::class,
        'restored' => AttributeRestored::class,
    ];

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
    protected static $logFillable = true;

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

    /**
     * Get the route key for the model.
     *
     * @param \Illuminate\Database\Eloquent\Model $entity
     * @param string                              $accessArea
     *
     * @return \Illuminate\View\View
     */
    public function render(Model $entity, string $accessArea): string
    {
        $default = '';
        $selected = '';

        switch ($this->type) {
            case 'select':

                $default = collect(array_map('trans', array_map('trim', explode("\n", $this->default))))->map(function ($item) use (&$selected) {
                    if (mb_strpos($item, '=')) {
                        $key = mb_strstr($item, '=', true);
                        $value = Str::replaceFirst('=', '', mb_strstr($item, '='));

                        // Check for SELECTED itmes (marked by asterisk)
                        ! Str::contains($value, '*') || $selected = $key;
                        ! Str::contains($value, '*') || $value = Str::replaceLast('*', '', $value);
                    } else {
                        $key = $value = $item;

                        // Check for SELECTED itmes (marked by asterisk)
                        ! Str::contains($value, '*') || $key = $value = $selected = Str::replaceLast('*', '', $value);
                    }

                    return [$key => $value];
                })->collapse();

                return view("cortex/attributes::{$accessArea}.types.".$this->type, ['attribute' => $this, 'entity' => $entity, 'default' => $default, 'selected' => $selected])->render();

            case 'check':

                $default = collect(array_map('trans', array_map('trim', explode("\n", $this->default))))->map(function ($item) use ($entity) {
                    $details = [
                        'label' => '',
                        'status' => false,
                    ];

                    if (mb_strpos($item, '=')) {
                        $details['label'] = mb_strstr($item, '=', true);
                        $item = Str::replaceFirst('=', '', mb_strstr($item, '='));

                        // Check for SELECTED itmes (marked by asterisk)
                        ! Str::contains($item, '*') || $details['status'] = true;
                        ! Str::contains($item, '*') || $item = Str::replaceLast('*', '', $item);

                        ! $entity->exists || $details['status'] = $entity->{$this->slug}->search($item) !== false;
                    } else {
                        $details['label'] = $item;

                        // Check for SELECTED itmes (marked by asterisk)
                        ! Str::contains($item, '*') || $details['status'] = true;
                        ! Str::contains($item, '*') || $details['label'] = $item = Str::replaceLast('*', '', $item);

                        ! $entity->exists || $details['status'] = $entity->{$this->slug}->search($item) !== false;
                    }

                    return [$item => $details];
                })->collapse();

                return view("cortex/attributes::{$accessArea}.types.".$this->type, ['attribute' => $this, 'entity' => $entity, 'default' => $default])->render();

            default:
                return view("cortex/attributes::{$accessArea}.types.".$this->type, ['attribute' => $this, 'entity' => $entity, 'default' => $default])->render();
        }
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
