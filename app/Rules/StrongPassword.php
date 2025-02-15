<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    public function passes($attribute, $value)
    {
        // Check if the password meets the criteria
        return preg_match('/[A-Z]/', $value) && // At least one uppercase letter
               preg_match('/[a-z]/', $value) && // At least one lowercase letter
               preg_match('/[0-9]/', $value) && // At least one number
               preg_match('/[\W_]/', $value);  // At least one special character
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->passes($attribute, $value)) {
            $fail($this->message());
        }
    }

    public function message()
    {
        return 'The :attribute must include at least one uppercase letter, one lowercase letter, one number, and one special character.';
    }
}
