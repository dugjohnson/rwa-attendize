@extends('Emails.Layouts.Master')

@section('message_content')
    @lang("basic.hello"),<br><br>

    {!! @trans("Order_Emails.successful_order", ["name"=>$order->event->title]) !!}<br><br>

    <p>Thank you for registering for #RWA2024 in Austin, TX! We're excited to have you join us for a series of
        informative and interactive sessions designed to advance your romance writing career.</p>
    <p>Volunteering at the conference is a fantastic way to enhance your experience and connect with fellow attendees.
        Plus, all conference volunteers are entered into a chance drawing for a free conference registration for next
        year's annual conference (certain rules apply). To sign up as a conference volunteer, 
        <a href="https://forms.gle/wTiFkcruRQUnu8XC6" target="_blank">please use this link.</a></p>
    <p>In addition to the workshops, we are thrilled to announce the RWA2024 Scavenger Hunt with fabulous prizes. The
        rules will be posted on the conference website soon, so stay tuned!</p>
    <p>We also have a planned special excursion trip to the Erin Condren store in Austin, TX, followed by a delightful
        dinner on Sunday, October 13, from 4:00 PM to 9:00 PM. Please note that there is an additional charge for this
        excursion and space is limited. For more details, feel free to email us at 
        <a href="mailto:conference@rwa.org"> conference@rwa.org.</a></p>
    <p>Don't miss the chance to get your logo or book covers in front of conference and Expo attendees through our
        display boards. <a href="https://www.rwa.org/rwa-annual-conference-display-board" target="_blank">For more information, click here.</a></p>
    <p>You can also get your name and logo in front of conference attendees through our co-sponsorship opportunities,
        <a href="https://www.rwa.org/rwa-annual-conference-sponsorship-opportunities" target="_blank">which you can learn more about here.</a></p>
    <p>Thank you again for your support, and we look forward to seeing you at the conference!</p>
    <p>Best regards,<br>
        RWA Board of Directors<br>
        RWA Conference Committee</p>

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
