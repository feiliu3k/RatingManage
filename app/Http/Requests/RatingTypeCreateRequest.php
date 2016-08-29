<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RatingTypeCreateRequest; extends Request
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
        return [
            'rating_type' => 'required|unique:ratingtypes,rating_type',

        ];
    }
}
