@extends('Emails.Layouts.Master')

@section('message_content')
    @lang("basic.hello"),<br><br>

    {!! @trans("Order_Emails.successful_order", ["name"=>$order->event->title]) !!}<br><br>

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


    {{ @trans("Order_Emails.tickets_attached") }} <a
            href="{{route('showOrderDetails', ['order_reference' => $order->order_reference])}}">{{route('showOrderDetails', ['order_reference' => $order->order_reference])}}</a>.

    @if(!$order->is_payment_received)
        <br><br>
        <strong>{{ @trans("Order_Emails.order_still_awaiting_payment") }}</strong>
        <br><br>
        {{ $order->event->offline_payment_instructions }}
        <br><br>
    @endif

    <h3>Order Details</h3>
    Order Reference: <strong>{{$order->order_reference}}</strong><br>
    Order Name: <strong>{{$order->full_name}}</strong><br>
    Order Date: <strong>{{$order->created_at->format(config('attendize.default_datetime_format'))}}</strong><br>
    Order Email: <strong>{{$order->email}}</strong><br>
    <a href="{!! route('downloadCalendarIcs', ['event_id' => $order->event->id]) !!}">Add To Calendar</a>

    @if ($order->is_business)
        <h3>Business Details</h3>
        @if ($order->business_name)
            @lang("Public_ViewEvent.business_name"): <strong>{{$order->business_name}}</strong><br>
        @endif
        @if ($order->business_tax_number)
            @lang("Public_ViewEvent.business_tax_number"): <strong>{{$order->business_tax_number}}</strong><br>
        @endif
        @if ($order->business_address_line_one)
            @lang("Public_ViewEvent.business_address_line1"): <strong>{{$order->business_address_line_one}}</strong><br>
        @endif
        @if ($order->business_address_line_two)
            @lang("Public_ViewEvent.business_address_line2"): <strong>{{$order->business_address_line_two}}</strong><br>
        @endif
        @if ($order->business_address_state_province)
            @lang("Public_ViewEvent.business_address_state_province"):
            <strong>{{$order->business_address_state_province}}</strong><br>
        @endif
        @if ($order->business_address_city)
            @lang("Public_ViewEvent.business_address_city"): <strong>{{$order->business_address_city}}</strong><br>
        @endif
        @if ($order->business_address_code)
            @lang("Public_ViewEvent.business_address_code"): <strong>{{$order->business_address_code}}</strong><br>
        @endif
    @endif

    <h3>Order Items</h3>
    <div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
        <table style="width:100%; margin:10px;">
            <tr>
                <td>
                    <strong>Ticket</strong>
                </td>
                <td>
                    <strong>Qty.</strong>
                </td>
                <td>
                    <strong>Price</strong>
                </td>
                <td>
                    <strong>Fee</strong>
                </td>
                <td>
                    <strong>Total</strong>
                </td>
            </tr>
            @foreach($order->orderItems as $order_item)
                <tr>
                    <td>{{$order_item->title}}</td>
                    <td>{{$order_item->quantity}}</td>
                    <td>
                        @isFree($order_item->unit_price)
                        FREE
                        @else
                            {{money($order_item->unit_price, $order->event->currency)}}
                        @endif
                    </td>
                    <td>
                        @isFree($order_item->unit_price)
                        -
                        @else
                            {{money($order_item->unit_booking_fee, $order->event->currency)}}
                        @endif
                    </td>
                    <td>
                        @isFree($order_item->unit_price)
                        FREE
                        @else
                            {{money(($order_item->unit_price + $order_item->unit_booking_fee) * ($order_item->quantity),
                            $order->event->currency)}}
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"></td>
                <td><strong>Sub Total</strong></td>
                <td colspan="2">
                    {{$orderService->getOrderTotalWithBookingFee(true)}}
                </td>
            </tr>
            @if($order->event->organiser->charge_tax == 1)
                <tr>
                    <td colspan="3"></td>
                    <td>
                        <strong>{{$order->event->organiser->tax_name}}</strong><em>({{$order->event->organiser->tax_value}}
                            %)</em>
                    </td>
                    <td colspan="2">
                        {{$orderService->getTaxAmount(true)}}
                    </td>
                </tr>
            @endif
            <tr>
                <td colspan="3"></td>
                <td><strong>Total</strong></td>
                <td colspan="2">
                    {{$orderService->getGrandTotal(true)}}
                </td>
            </tr>
        </table>
        <br><br>
    </div>
    <br><br>
    Thank you
@stop
