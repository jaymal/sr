<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MailableExist implements Rule
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
        $files = scandir(base_path('app/Mail'));
        $needle  = $value.'.php';
        return in_array($needle, $files);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute file does not seem to exist within the app/Mail directory.';
    }
}
