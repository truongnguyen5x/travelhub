<?php

namespace App\Rules;
use Carbon;
use Illuminate\Contracts\Validation\Rule;

class AfterNow implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Carbon::createFromFormat('d-m-Y H:i', $value)> now();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Thời gian khởi hành cần sau hiện tại';
    }
}
