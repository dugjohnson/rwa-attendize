@extends('Emails.Layouts.Master')

@section('message_content')

@lang("basic.hello") {{ $attendee->first_name }},<br><br>

<p>Thank you for registering for RWA2024 in Austin, TX! We are thrilled to have you join.</p>
<p>The Conference Committee is dedicated to making this conference not only informative and engaging but also a
    memorable event for all attendees. You can look forward to an exciting lineup of speakers, interactive sessions, and
    invaluable networking opportunities.</p>

<p>In the next 24 hours, you will receive a separate email with a link to make your hotel reservations. We encourage you
    to book your stay as soon as possible to ensure you have accommodations at the conference hotel.</p>

<p>Additionally, we offer fantastic opportunities to enhance your presence at the event. Consider taking advantage of
    our co-sponsorship opportunities and display board advertising. This is a perfect chance to showcase your name,
    logo, or even a book cover in front of conference and Expo attendees.</p>

<p>We look forward to welcoming you to RWA2024 and are confident it will be an enriching and enjoyable experience for
    you.</p>

<p>If you have questions, please send them to conference@rwa.org.</p>


{{ @trans("Order_Emails.tickets_attached") }} <a href="{{route('showOrderDetails', ['order_reference' => $attendee->order->order_reference])}}">{{route('showOrderDetails', ['order_reference' => $attendee->order->order_reference])}}</a>.

<p>Best regards,</p>
<p>Conference Committee</p>

@stop
