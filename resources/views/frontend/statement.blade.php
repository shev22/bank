<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Invoice #6</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }
    </style>
</head>
<body>

    <table class="order-details">
        <thead>
            <tr>
                <th width="50%" colspan="2">
                    <h2 class="text-start">Bell Bank</h2>
                </th>
                <th width="50%" colspan="2" class="text-end company-data">
                    <span>Invoice Id: #6</span> <br>
                    <span>Date: 24 / 09 / 2022</span> <br>
                    <span>Zip code : 560077</span> <br>
                    <span>Address: #555, Main road, shivaji nagar, Bangalore, India</span> <br>
                </th>
            </tr>

            <tr class="bg-blue">
                <th width="50%" colspan="2">Statement Details</th>
                <th width="50%" colspan="2">Customer Details</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($collection as $item) --}}
            <tr>
                <td>Order Id:</td>
                <td>6</td>

                <td>Full Name:</td>
                <td>{{ ucwords(strtolower(Auth::user()->name)) }}</td>
            </tr>
            <tr>
                <td>Tracking Id/No.:</td>
                <td>funda-CRheOqspbA</td>

                <td>Email Id:</td>
                <td>{{ Auth::user()->email }}</td>
            </tr>
            <tr>
                <td>Ordered Date:</td>
                <td>{{ date('d-m-y H:m:s') }}</td>

                <td>Phone:</td>
                <td>8889997775</td>
            </tr>
            <tr>
                <td>Transaction Period:</td>
                <td>{{$request->start .' - '. $request->end }}</td>

                <td>Address:</td>
                <td>asda asdad asdad adsasd</td>
            </tr>
            <tr>
                <td>Number of Transactions:</td>
                <td>{{ $total_transactions }}</td>

                <td>Pin code:</td>
                <td>566999</td>
            </tr>
            {{-- @endforeach --}}
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                   Transactions
                </th>
            </tr>
            <tr class="bg-blue">
                <th class="text-center" width="10px">№</th>
                <th class="text-center">TRANSACTION ID</th>
                <th class="text-center">ACCOUNT NUMBER</th>
                <th class="text-center">OPERATION</th>
                <th class="text-center">ACCOUNT CURRENCY</th>
                <th class="text-center">STATUS</th>
                <th class="text-center">DATE</th>
                <th class="text-center">AMOUNT</th>
                <th class="text-center">BALANCE</th>
            </tr>
        </thead>
        <tbody>
            @php
            $No = 1;
            @endphp
            @foreach ($transactions as $transaction)
            <tr>
                <td width="3%">{{ $No++ }}</td>
                <td width="10%" class="text-center" >{{ $transaction->transaction_id }}</td>
                <td width="10%" class="text-center" >{{ $transaction->account_number }}</td>
                <td width="10%" class="fw-bold text-center">{{ $transaction->operation }}</td>
                <td width="10%" class="text-center">{{ $transaction->currency }}</td>
                <td width="10%" class="text-center ">{{ $transaction->status}}</td>
                <td width="10%" class="text-center">{{ $transaction->created_at }}</td>
                <td width="10%" class="text-center"> @if ($transaction->operation == 'Withdrawal' || str_contains($transaction->comment, 'Debited') )
                    <span class="text-secondary text-xs font-weight-bold text-danger">-{{ $transaction->amount }}</span>
                    @else
                    <span class="text-secondary text-xs font-weight-bold text-success">+{{ $transaction->amount }}</span>
                    @endif</td>
                <td width="10%" class="fw-bold text-center">{{ $transaction->currency }}{{ $transaction->available_balance }}</td>
            </tr>
            @endforeach


            <tr>
                <td colspan="4" class="total-heading">Total Amount for the selected period- <small>Inc. all vat/tax</small> :</td>
                <td colspan="1" class="total-heading">${{ $total }}</td>
            </tr>
        </tbody>
    </table>

    <br>
    <p class="text-center">
        Thank your for banking with us
    </p>

</body>
</html>