<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if ($type === 'booking')
            Thông báo đặt phòng mới
        @elseif($type === 'registration')
            Thông báo đăng ký khóa học mới
        @else
            Thông báo mới
        @endif
    </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border: 1px solid #dee2e6;
        }

        .details {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }

        .detail-row {
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
        }

        .label {
            font-weight: bold;
            color: #495057;
        }

        .value {
            color: #6c757d;
        }

        .footer {
            background-color: #6c757d;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 0 0 5px 5px;
            font-size: 14px;
        }

        .status {
            background-color: #ffc107;
            color: #212529;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>
            @if ($type === 'booking')
                🏠 Thông báo đặt phòng mới
            @elseif($type === 'consultation')
                📚 Thông báo đăng ký tư vấn khóa học mới
            @else
                📢 Thông báo mới
            @endif
        </h1>
    </div>

    <div class="content">
        <p>Xin chào Admin,</p>

        <p>
            @if ($type === 'booking')
                Có một yêu cầu đặt phòng mới cần được xem xét và xử lý.
            @elseif($type === 'consultation')
                Có một yêu cầu đăng ký tư vấn khóa học mới cần được xem xét và xử lý.
            @else
                Có một thông báo mới cần được xem xét và xử lý.
            @endif
        </p>

        <div class="details">
            @if ($type === 'booking')
                <h3>📋 Chi tiết đặt phòng:</h3>

                <div class="detail-row">
                    <span class="label">Mã đặt phòng:</span>
                    <span class="value">{{ $bookingCode }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">Người đặt:</span>
                    <span class="value">{{ $customerName }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">Phòng:</span>
                    <span class="value">{{ $roomName }}</span>
                </div>

                @if ($roomLocation)
                    <div class="detail-row">
                        <span class="label">Vị trí:</span>
                        <span class="value">{{ $roomLocation }}</span>
                    </div>
                @endif

                <div class="detail-row">
                    <span class="label">Ngày bắt đầu:</span>
                    <span class="value">{{ $startDate }}</span>
                </div>

                @if ($endDate)
                    <div class="detail-row">
                        <span class="label">Ngày kết thúc:</span>
                        <span class="value">{{ $endDate }}</span>
                    </div>
                @endif

                @if ($reason)
                    <div class="detail-row">
                        <span class="label">Lý do:</span>
                        <span class="value">{{ $reason }}</span>
                    </div>
                @endif
                @if (count($bookingDetails) > 0)
                    <div class="details-box">
                        <h3 style="margin-top: 0; color: #4b5563;">📅 Chi tiết lịch đặt phòng:</h3>
                        <table class="details-table">
                            <thead>
                                <tr>
                                    <th>📅 Ngày</th>
                                    <th>⏰ Thời gian</th>
                                    <th>📊 Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookingDetails as $detail)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($detail->booking_date)->format('d/m/Y') }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($detail->start_time)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($detail->end_time)->format('H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @elseif($type === 'consultation')
                <h3>📋 Chi tiết đăng ký tư vấn khóa học:</h3>

                <div class="detail-row">
                    <span class="label">Người đăng ký:</span>
                    <span class="value">{{ $customerName }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">Số điện thoại:</span>
                    <span class="value">{{ $customerPhone }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">Email:</span>
                    <span class="value">{{ $customerEmail }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">Khóa học:</span>
                    <span class="value">{{ $courseName }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">Ngày bắt đầu:</span>
                    <span class="value">{{ $startDate }}</span>
                </div>

                @if ($endDate)
                    <div class="detail-row">
                        <span class="label">Ngày kết thúc:</span>
                        <span class="value">{{ $endDate }}</span>
                    </div>
                @endif

            @endif

            <div class="detail-row">
                <span class="label">Trạng thái:</span>
                <span class="status">{{ $status }}</span>
            </div>

            <div class="detail-row">
                <span class="label">Thời gian tạo:</span>
                <span class="value">{{ $createdAt }}</span>
            </div>
        </div>

        <p><strong>Vui lòng đăng nhập vào hệ thống để xem chi tiết và xử lý yêu cầu này.</strong></p>

        <p>Trân trọng,<br>
            {{ $centerName }}</p>
    </div>

    <div class="footer">
        <p>
            Email này là xác nhận tự động về việc đăng ký khóa học của bạn.<br>
            Vui lòng không trả lời email này.
        </p>
        <p>
            © {{ date('Y') }} {{ $centerName }}. All rights reserved.
        </p>
    </div>
</body>

</html>
