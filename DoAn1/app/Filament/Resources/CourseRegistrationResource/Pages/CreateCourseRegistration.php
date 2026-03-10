<?php

namespace App\Filament\Resources\CourseRegistrationResource\Pages;

use App\Filament\Resources\CourseRegistrationResource;
use App\Mail\CourseRegistrationNotification;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CreateCourseRegistration extends CreateRecord
{
    protected static string $resource = CourseRegistrationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Tự động gán người tạo là user hiện tại nếu chưa có
        if (!isset($data['created_by']) || !$data['created_by']) {
            $data['created_by'] = Auth::id();
        }

        return $data;
    }
    protected function afterCreate(): void
    {
        $record = $this->record;
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
