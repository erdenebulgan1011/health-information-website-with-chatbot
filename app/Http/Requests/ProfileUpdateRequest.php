<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // public function rules(): array
    // {
    //     return [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => [
    //             'required',
    //             'string',
    //             'lowercase',
    //             'email',
    //             'max:255',
    //             Rule::unique(User::class)->ignore($this->user()->id),
    //         ],
    //     ];
    // }
    public function authorize(): bool
    {
        // Хэрэглэгч зөвхөн өөрийн профайлыг засах боломжтой
        return true;
    }

    /**
     * Хүсэлтэд хэрэглэгдэх шалгах дүрмүүд.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // Хэрэглэгчийн үндсэн мэдээлэл
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],

            // Профайлын мэдээлэл
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'height' => ['nullable', 'integer', 'min:50', 'max:250'],
            'is_smoker' => ['boolean'],
            'has_chronic_conditions' => ['boolean'],
            'medical_history' => ['nullable', 'string', 'max:5000'],
        ];
    }

    /**
     * Шалгах дүрмүүдийн алдааны мессежүүд.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Нэр текст байх ёстой.',
            'name.max' => 'Нэр хэт урт байна.',
            'email.email' => 'Имэйл хаяг буруу форматтай байна.',
            'email.max' => 'Имэйл хаяг хэт урт байна.',
            'email.unique' => 'Энэ имэйл хаяг бүртгэлтэй байна.',
            'birth_date.date' => 'Төрсөн огноо буруу форматтай байна.',
            'birth_date.before_or_equal' => 'Төрсөн огноо өнөөдрөөс өмнө байх ёстой.',
            'gender.in' => 'Хүйс буруу утгатай байна.',
            'height.integer' => 'Өндөр бүхэл тоо байх ёстой.',
            'height.min' => 'Өндөр хамгийн багадаа 50 см байх ёстой.',
            'height.max' => 'Өндөр хамгийн ихдээ 250 см байх ёстой.',
            'medical_history.max' => 'Эрүүл мэндийн түүх хэт урт байна.',
        ];
    }

}
