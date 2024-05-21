<x-mail::message>
# Đơn xin nghỉ đã được phê duyệt

@if($status == 1)
Đơn xin nghỉ của bạn đã được chấp nhận!
@else
Đơn xin nghỉ của bạn đã bị từ chối!
@endif
<br>
Lời nhắn: {{$result}} 

Trân trọng,<br>
{{ $name }}
</x-mail::message>
