<?php

declare(strict_types=1);

namespace Cortex\Attributes\Http\Requests\Adminarea;

use Illuminate\Foundation\Http\FormRequest;

class AttributeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $attribute = $this->route('attribute') ?? app('rinvex.attributes.attribute');
        $attribute->updateRulesUniques();

        return $attribute->getRules();
    }
}
