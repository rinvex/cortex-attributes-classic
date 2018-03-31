<?php

declare(strict_types=1);

namespace Cortex\Attributes\Transformers\Adminarea;

use Rinvex\Support\Traits\Escaper;
use Cortex\Attributes\Models\Attribute;
use League\Fractal\TransformerAbstract;

class AttributeTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * @return array
     */
    public function transform(Attribute $attribute): array
    {
        return $this->escapeRow([
            'id' => (string) $attribute->getRouteKey(),
            'name' => (string) $attribute->name,
            'type' => (string) $attribute->type,
            'group' => (string) $attribute->group,
            'is_collection' => (bool) $attribute->is_collection,
            'is_required' => (bool) $attribute->is_required,
            'created_at' => (string) $attribute->created_at,
            'updated_at' => (string) $attribute->updated_at,
        ]);
    }
}
