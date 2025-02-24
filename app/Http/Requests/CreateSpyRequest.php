<?php

namespace App\Http\Requests;

use App\Domain\ValueObjects\Agency;
use App\Rules\UniqueSpyNameRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateSpyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //handled by sanctum
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255', new UniqueSpyNameRule()],
            'last_name' => ['required', 'string', 'max:255', new UniqueSpyNameRule()],
            'agency' => ['required', new Enum(Agency::class)],
            'country_of_operation' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'date_of_death' => ['nullable', 'date', 'after:date_of_birth', 'before:today'],
        ];
    }
}
