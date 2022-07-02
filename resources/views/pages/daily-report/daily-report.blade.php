@extends('layouts.master')
@section('content')
    <style>
        .box-item-content {
            overflow-y: scroll;
        }
        .bootstrap-select{
            width: 100%;

        }
        .selectpicker button,
        .btn.dropdown-toggle.selectpicker.btn-default {
            font-family: sans-serif;
            height: 41px;
            border: 2px solid #f88045
        }
        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
            width: 100%;
        }

    </style>

    <section>
        @if(Session()->has('message'))
            <div class="alert alert-success">
                <p>{{ Session()->get('message') }}</p>
            </div>
        @endif
        <div class="box-item">
            <div class="box-item-head">
                <h3 class="title">التقرير اليومي ﻹنتاج كل قسم</h3>
            </div><!-- End Box-Item-Head -->
            <div class="box-item-content">
                <form method="post" action="{{ route('add-daily-report') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">القسم</label>
                                <select name="sector" id="sector" class="form-control">
                                    @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">تاريخ الإنتاج</label>
                                <input type="date" required name="date" id="date" class="form-control" style="font-family: sans-serif">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">الوردية </label>
                                <select name="period" id="period" class="form-control">
                                    <option value="أصلي">أصلي</option>
                                    <option value="إضافي">إضافي</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">مخن تسليم المُنتج السليم</label>
                                <select name="stock" id="stock" class="form-control">
                                    @foreach ($stocks as $stock)
                                        <option value="{{ $stock->id }}">{{ $stock->stock_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">مخن تسليم المُنتج التالف</label>
                                <select name="tainted_stock" id="tainted_stock" class="form-control">
                                    @foreach ($stocks as $stock)
                                        <option value="{{ $stock->id }}">{{ $stock->stock_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <select class="selectpicker" id="product_tree_picker" data-show-subtext="true" data-live-search="true" style="font-family: 'sans-serif';">
                            <option value="">إختر المُنتج</option>
                            @foreach ($products as $product)
                                @if (count($product->getProductTrees) && count($product->getProductPaths))
                                    <option value="{{$product->id}}" data-subtext="{{$product->product_type}}, {{substr( $product->description, 0, 50)}}" style="font-family: 'sans-serif';">{{$product->product_code}}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>

                    <br>
                    <div class="row">
                        <table class="table table-responsive table-striped" id="prodcuctsTable" style="display: none;">
                            <thead>
                                <th>كود المُنتج</th>
                                <th>الوحدة</th>
                                <th>الكمية السليمة</th>
                                <th>كمية التوالف</th>
                                <th>الوحدة</th>
                                <th>قيمة الوحدة السليمة</th>
                                <th>الإجمالي</th>
                            </thead>
                            <tbody class="daily-report-products">

                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-primary pull-right" id="addDailyReport" style="visibility: hidden">حفظ <i class="fa fa-plus"></i></button>

                </form>
            </div><!-- End Box-Item-Content -->
        </div><!-- End Box-Item -->
    </section><!--End Section-->

@stop

@section('scripts')

    <script>
        let fullDate = new Date().toLocaleString().split(',')[0];
        document.querySelector('#date').value = fullDate;
    </script>
    <script>
    // global app configuration object
    var config = {
        routes: {
            getProduct: "{{ url('/get-product-daily-report') }}",
            addDailyReport: "{{ url('/add-daily-report') }}",
        },
        token: "{{csrf_token()}}"
    };
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/dailyreport/dailyreport.js') }}"></script>
@stop
