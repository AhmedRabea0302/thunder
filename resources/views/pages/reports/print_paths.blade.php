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
        max-width: 90%;
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
        <h1><span class="tree_code">{{ $path->path_code }}</span> - المسار</h1><br />

        <table>
            <tr style="background: #232323; color: #fff; font-weight: bold; width: 100%">
                <td colspan="2" style="float: right;">نوع المسار: {{ $path->path_type == 0 ? 'قياسي' : 'غير قياسي' }}</td>
                <td></td>
                <td colspan="2" style="float: right;">الكمية: {{ $path->path_quantity }} </td>
                <td></td>
                <td colspan="2" style="float: right;">تكلفة المنتج: {{ $path->piece_total_budget }} </td>
            </tr>
        </table>

        <br>
        <div class="row">
            <h2 class="text-center">مراحل المسار</h2>
        </div>
        <table class="items">
            <tr class="heading">
                <td></td>
                <td>كود المُعدة</td>
                <td>نوع المرحلة</td>
                <td>عدد العمال</td>
                <td>أجر العامل/س</td>
                <td>معدل الإنتاج/س</td>
                <td>تكلفة المرحلة</td>
            </tr>

            @if($path_steps->isNotEmpty())
                @foreach($path_steps as $key => $step)
                    <tr>
                        <td colspan="8" style="background: #232323; color: #fff; font-weight: bold">{{$key + 1}}</td>
                    </tr>
                    <tr>
                    <tr style="background: #8c898917;">
                        <td></td>
                        <td>{{$step->equipmentDetails->equipment_code ?? '-'}}</td>
                        <td>{{$step->step_type}}</td>
                        <td>{{$step->workers_number}}</td>
                        <td>{{$step->worker_hour_pay}}</td>
                        <td>{{$step->production_time_rate}}</td>       
                        <td>{{$step->step_total_budget}}</td>       
                    </tr>
                @endforeach

            @endif
        </table>
        <br><br>

        <div class="row">
            <h2 class="text-center">مصرفات المسار</h2>
        </div>

        @if($path_expenses->isNotEmpty())
            <table class="items">
                <tr class="heading">
                    <td></td>
                    <td>البند</td>
                    <td>المصروف</td>
                </tr>
                    @foreach($path_expenses as $key => $expense)
                        <tr>
                            <td colspan="8" style="background: #232323; color: #fff; font-weight: bold">{{$key + 1}}</td>
                        </tr>
                        <tr>
                        <tr style="background: #8c898917;">
                            <td></td>
                            <td>{{$expense->expense_type}}</td>
                            <td>{{$expense->expense_value}}</td>
                        </tr>
                    @endforeach
            </table>
        @endif

        <button type="button" id="invoicePrintButton" onclick="printpage()"
            class="btn btn-primary prints">طباعة</button>
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