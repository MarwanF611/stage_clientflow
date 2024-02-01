@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>
        Invoice {{ $invoice->id }}
    </title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://raw.githubusercontent.com/MarwanF611/stage_clientflow/main/public/logo_clientflow_transparent.png"
                                    style="width: 100%; max-width: 200px" />
                            </td>

                            <td>
                                Invoice #: {{ $invoice->id }}<br />
                                Created: {{ Carbon::now()->format('F d, Y') }}<br />
                                Due: {{ $invoice->expiration_date }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                Sparksuite, Inc.<br />
                                12345 Sunny Road<br />
                                Sunnyville, CA 12345
                            </td>

                            <td>
                                {{ $invoice->customer->company_name }}.<br />
                                {{ $invoice->customer->street_name }} {{ $invoice->customer->house_number }},
                                {{ $invoice->customer->postcode }}<br />
                                Tel. {{ $invoice->customer->phone_number }}<br />

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Payment Method</td>

                <td colspan="4">
                    Check #
                </td>
            </tr>

            <tr class="details">
                <td>{{ ucfirst($invoice->payment_method) }}</td>

                <td colspan="4">1000</td>
            </tr>

            <tr class="heading">
                <td>Item</td>
                <td>Amount</td>
                <td>Price per unit</td>
                <td colspan="4">Price</td>

            </tr>

            @foreach ($products as $product)
                <tr class="item {{ $loop->last ? 'last' : '' }}">
                    <td>{{ $product->details->name }} </td>
                    <td>{{ $product->amount }}x</td>
                    <td>{{ $product->details->price }} EUR</td>
                    <td colspan="4">{{ $product->details->price * $product->amount }} EUR</td>
                </tr>
            @endforeach



            <tr class="total">
                <td></td>

                <td colspan="3">
                    Total:
                    @php
                        $total = 0;
                        foreach ($products as $product) {
                            $total += $product->details->price * $product->amount;
                        }
                        echo '€' . $total . ',-';
                    @endphp
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
