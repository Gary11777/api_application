<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\DB;

class Timeoftoken implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $start_date = date('Y-m-d H:i:s', strtotime('-2 hour'));
        $date = DB::table('reset_passwords')->where('token', $attribute)->value('updated_at');
        if ($date > $start_date) {
            $fail('The '.$attribute.' is invalid.');
        }
    }
}
