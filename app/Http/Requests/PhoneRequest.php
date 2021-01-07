<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\UsersPhones;
use Auth;
class PhoneRequest extends FormRequest
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
        if ($this->method() == 'PUT'){
            return [
                'phone'=>'required | unique:users_phones,phone,'.$this->route()->phone.',id,deleted_at,NULL| digits:11 | starts_with:011,012,010'
            ];
        }else{
            return [
                'phone'=>'required | unique:users_phones,phone,NULL,id,deleted_at,NULL| digits:11 | starts_with:011,012,010'
            ];
        }
    }
}
