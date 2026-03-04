<?php

namespace App\Mail;

use App\Helpers\SettingHelper;
use App\Models\CourseRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CourseRegistrationNotification extends Mailable
{
    use Queueable, SerializesModels;
    
    //tư vấn và đăng ký khóa học
    public $type;
    public $courseRegistration;

    /**
     * Create a new message instance.
     */
    // type: consultation hoặc registration
    public function __construct(CourseRegistration $courseRegistration, $type = 'registration')
    {
        $this->courseRegistration = $courseRegistration;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $centerName = SettingHelper::get('center_name', 'Hệ thống quản lý học tập');
        $subject = match ($this->type) {
            'consultation' => 'Thông báo tư vấn khóa học - ' . $centerName,
            default => 'Thông báo đăng ký khóa học - ' . $centerName,
        };
        return new Envelope(
            subject: $subject,
            from: new Address(
                config('mail.from.address', 'noreply@example.com'),
                $centerName
            ),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if($this->type === 'consultation') {
            $view = 'emails.course-registration-consultation';
        } else {
            $view = 'emails.course-registration';
        }
        return new Content(
            view: $view,
            with: [
                'studentName' => $this->courseRegistration->student_name,
                'courseTitle' => $this->courseRegistration->course->title,
                'categoryName' => $this->courseRegistration->course->category->name,
                'registrationDate' => $this->courseRegistration->registration_date->format('d/m/Y'),
                'coursePrice' => number_format($this->courseRegistration->course->price, 0, ',', '.'),
                'actualPrice' => number_format($this->courseRegistration->actual_price, 0, ',', '.'),
                'paymentStatus' => $this->courseRegistration->payment_status,
                'status' => $this->courseRegistration->status,
                'courseStartDate' => $this->courseRegistration->course->start_date?->format('d/m/Y'),
                'centerName' => SettingHelper::get('center_name', 'Hệ thống quản lý học tập'),
                'centerPhone' => SettingHelper::get('center_phone', ''),
                'centerEmail' => SettingHelper::get('center_email', ''),
                'centerAddress' => SettingHelper::get('center_address', ''),
            ]
        );
           
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
