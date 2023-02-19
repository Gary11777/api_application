<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class NewPasswordRequest extends FormRequest
{

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // 'false' - for only registered users, 'true' - for all users
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            "token" => [
                "exists:reset_passwords,token",
                function ($attribute, $value, $fail) {
                    $start_date = date('Y-m-d H:i:s', strtotime('-2 hour'));
                    $date = DB::table('reset_passwords')->where('token', $attribute)->value('updated_at');
                    if ($date > $start_date) {
                        $fail('The '.$attribute.' is invalid.');
                    }
                },
            ],
            "password" => "required"
        ];
    }
}
