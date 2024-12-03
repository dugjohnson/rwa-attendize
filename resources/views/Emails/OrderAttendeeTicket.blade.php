@extends('Emails.Layouts.Master')

@section('message_content')

@lang("basic.hello") {{ $attendee->first_name }},<br><br>

<p>Thank you for registering for RWA2025 in Niagara Falls Fallsview, Ontario, Canada! We’re excited to have you
    join us.</p>
<p>To complete your registration, please look for an invoice from PayPal in your inbox. Full payment is required to
    finalize your registration. If you selected the payment plan, your first payment will be billed now, and the
    second payment will be billed 45 days later.</p>
<p>Here’s a preview of the tentative conference schedule (please note that the schedule is subject to change):</p>
<p> Wednesday, July 16: Retreats, Focused Intense Workshops, Welcome Reception (Keynote speaker TBA)</p>
<p>Thursday, July 17: Workshops, After-Hours Meet-ups</p>
<p>Friday, July 18: Workshops, After-Hours Party</p>
<p> Saturday, July 19: Awards Ceremony, Pitch Sessions, Expo</p>
<p>A separate email with hotel reservation details will follow. We recommend booking early to secure your stay at
    the conference hotel.</p>
<p>If you have any questions, please contact us at conference@rwa.org.</p>
<p>We look forward to seeing you at RWA2025 for an inspiring and memorable event!</p>
<p>Best regards,<br>
    The RWA Team<br>
    Conference Committee</p>

{{ @trans("Order_Emails.tickets_attached") }} <a href="{{route('showOrderDetails', ['order_reference' => $attendee->order->order_reference])}}">{{route('showOrderDetails', ['order_reference' => $attendee->order->order_reference])}}</a>.

<p>Best regards,</p>
<p>Conference Committee</p>

@stop
