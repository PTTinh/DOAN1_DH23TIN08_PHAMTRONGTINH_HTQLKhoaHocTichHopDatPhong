<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\RoomBooking;
use App\Models\News;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class OverviewStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    protected ?string $heading = 'Tổng quan hệ thống';
    
    protected static ?int $sort = 3; // Hiển thị đầu tiên
    
    protected function getStats(): array
    {
        // Tổng số user
        $totalUsers = User::count();
        
        // Tổng khóa học
        $totalCourses = Course::count();
        
        // Tổng đăng ký
        $totalRegistrations = CourseRegistration::count();
        
        // Tổng đặt phòng
        $totalBookings = RoomBooking::count();
        
        // Tổng tin tức
        $totalNews = News::count();

        //Tổng doanh thu từ khóa học
        $totalRevenue = CourseRegistration::sum('actual_price');

        // Tổng doanh thu từ đặt phòng đã duyệt và đã thanh toán
        $totalBookingRevenue = RoomBooking::where('status', 'approved')
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        return [
            Stat::make('Người dùng', $totalUsers)
                ->description('Tổng số tài khoản')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
                
            Stat::make('Khóa học', $totalCourses)
                ->description('Tổng số khóa học')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('success'),
                
            Stat::make('Đăng ký', $totalRegistrations)
                ->description('Tổng số đăng ký')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),
                
            Stat::make('Đặt phòng', $totalBookings)
                ->description('Tổng số đặt phòng')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning'),
                
            Stat::make('Tin tức', $totalNews)
                ->description('Tổng số bài viết')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('primary'),
            
            Stat::make('Doanh thu khóa học', number_format($totalRevenue, 0, ',', '.'))
                ->description('Tổng doanh thu từ khóa học')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
                
            Stat::make('Doanh thu đặt phòng', number_format($totalBookingRevenue, 0, ',', '.'))
                ->description('Tổng doanh thu từ đặt phòng')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),
        ];
    }
}
