<?php

namespace App\Tenant\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueTenant implements ValidationRule
{
    protected $table;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $table, mixed $value, Closure $fail): void
    {
        //
    }
}
