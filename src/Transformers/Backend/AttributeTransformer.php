<?php

declare(strict_types=1);

namespace Cortex\Attributable\Transformers\Backend;

use Cortex\Attributable\Models\Attribute;
use League\Fractal\TransformerAbstract;

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
            'collection' => (bool) $attribute->collection,
            'default' => (string) $attribute->default,
            'created_at' => (string) $attribute->created_at,
            'updated_at' => (string) $attribute->updated_at,
        ];
    }
}
