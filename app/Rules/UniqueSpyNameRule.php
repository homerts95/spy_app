<?php

namespace App\Rules;

use App\Infrastructure\EloquentModel\SpyEloquentModel;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueSpyNameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $exists = SpyEloquentModel::query()
            ->where('first_name', request()->get('first_name'))
            ->where('last_name', request()->get('last_name'))
            ->exists();

        if ($exists) {
            $fail("This spy's full name  already exists.");
        }
    }
}
