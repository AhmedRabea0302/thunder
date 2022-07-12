<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Invoice styling -->
    <style>
    body {
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        text-align: center;
        color: #777;
    }

    body h1 {
        font-weight: 300;
        margin-bottom: 0px;
        padding-bottom: 0px;
        color: #000;
    }

    body h3 {
        font-weight: 300;
        margin-top: 10px;
        margin-bottom: 20px;
        font-style: italic;
        color: #555;
    }

    body h1 span {
        background-color: #232323;
        color: #fff;
        padding: 5px;
    }

    body a {
        color: #06f;
    }

    .invoice-box {
        max-width: 70%;
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
        border-collapse: collapse;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
        text-align: right;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
        text-align: inherit;
    }

    .invoiceImg {
        width: 100%;
        max-width: 100px;
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

    #invoicePrintButton {
        margin-right: 2px;
        width: 100px;
        height: 40px;
        background: #1b4b72;
        color: white;
    }

    .totals {
        margin-top: 40px;
        font-weight: bold;
        width: 100%;
        display: block;
        text-align: center;
    }

    .data {
        font-weight: bold
    }

    #fromTo {
        text-align: center
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: right;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    </style>
</head>

<body>
    <div class="invoice-box">
    
        <br>

        @if($daily_reports->isNotEmpty())
        <h3>المنتجات المُضافة في تاريخ  {{ $date }} </h3>
        <br>
        <table>
            <tr style="background: #232323; color: #fff; font-weight: bold; width: 100%">
                <td colspan="2" style="float: right;">مخزن تسليم المنتج السليم: {{ $daily_reports[0]->getHealthyStockDetails->stock_name }}</td>
                <td></td>
                <td colspan="2" style="float: right;">مخزن تسليم المنتج التالف: {{ $daily_reports[0]->getCorruptedStockDetails->stock_name }} </td>
            </tr>
        </table>
        
        <table class="items">
            <tr class="heading">
                <td></td>
                <td>كود المنتج</td>
                <td>الكمية السليمة</td>
                <td>الكمية التالفة</td>
                <td>وحدة التالف</td>
                <td>الإجمالي</td>
            </tr>
                @foreach($daily_reports as $key => $report)
                    <tr>
                        <td colspan="8" style="background: #232323; color: #fff; font-weight: bold">{{$key + 1}}</td>
                    </tr>
                    <tr>
                    @foreach($report->getDailyReportProducts as $product)
                        <tr style="background: #8c898917;">
                            <td></td>
                            <td>{{$product->getProductDetails->product_code}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>{{$product->corrupted_quantity}}</td>
                            <td>{{$product->corrupted_unit}}</td>
                            <td>{{$product->total}}</td>       
                        </tr>
                    @endforeach
                @endforeach
        </table>
        <br><br>
        <button type="button" id="invoicePrintButton" onclick="printpage()"
            class="btn btn-primary prints">طباعة</button>
        @else
            <h3>ﻻتوجد منتجات مضافة في هذا التاريخ! {{ $date }} </h3>
        @endif

        
    </div>
</body>

</html>

<script type="text/javascript">
function printpage() {
    //Get the print button and put it into a variable
    var printButton = document.getElementById("invoicePrintButton");
    //Set the print button visibility to 'hidden'
    printButton.style.visibility = 'hidden';
    //Print the page content
    window.print()
    printButton.style.visibility = 'visible';
}
</script>