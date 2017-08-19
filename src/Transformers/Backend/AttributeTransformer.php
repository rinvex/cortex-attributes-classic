<?php

declare(strict_types=1);

namespace Cortex\Attributable\Transformers\Backend;

use League\Fractal\TransformerAbstract;
use Cortex\Attributable\Models\Attribute;

class AttributeTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(Attribute $attribute)
    {
        return [
            'id' => (int) $attribute->id,
            'name' => (string) $attribute->name,
            'type' => (string) $attribute->type,
            'slug' => (string) $attribute->slug,
            'group' => (string) $attribute->group,
            'is_collection' => (bool) $attribute->is_collection,
            'default' => (string) $attribute->default,
            'created_at' => (string) $attribute->created_at,
            'updated_at' => (string) $attribute->updated_at,
        ];
    }
}
