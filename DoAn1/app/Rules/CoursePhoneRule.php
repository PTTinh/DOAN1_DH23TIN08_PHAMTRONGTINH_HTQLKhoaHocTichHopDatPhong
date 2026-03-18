<?php

namespace App\Rules;

use App\Models\CourseRegistration;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CoursePhoneRule implements ValidationRule
{
    public function __construct(private readonly int|string|null $courseId)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($this->courseId) || empty($value)) {
            return;
        }

        $alreadyRegistered = CourseRegistration::query()
            ->where('course_id', $this->courseId)
            ->where('student_phone', (string) $value)
            ->exists();

        if ($alreadyRegistered) {
            $fail('Số điện thoại đã được đăng ký cho khóa học này.');
        }
    }
}
