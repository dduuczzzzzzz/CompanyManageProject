<x-mail::message>
# Thông báo có đơn xin nghỉ mới!

Từ người gửi: {{$email}} <br>

Loại đơn xin nghỉ: {{$type_name}} <br>

Thời gian: Từ ngày {{$start_date}} đến {{$end_date}},{{$start_time}} giờ đến {{$end_time}} giờ<br>

Lý do xin nghỉ: {{$reason}} <br>

Cảm ơn,<br>
{{ $name }}
</x-mail::message>
