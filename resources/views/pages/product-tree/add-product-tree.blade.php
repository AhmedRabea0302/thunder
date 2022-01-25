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

        .add-product-to-tree {
            border-radius: 50%;
            line-height: 10px;
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 16px;
            background: #f89842;
            border: none;
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
                <h3 class="title">إضافة شجرة مٌنتج</h3>
            </div><!-- End Box-Item-Head -->
            <div class="box-item-content">
                <form action="{{ route('add-product-tree') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">كود المُنتج</label>
                                <br>
                                <select class="selectpicker" id="product_picker" name="product_tree_id" data-show-subtext="true" data-live-search="true" style="font-family: 'sans-serif';">
                                    <option value="">إختر المُنتج</option>
                                    @foreach ($products as $product)
                                        <option value="{{$product->id}}" data-subtext="{{$product->product_type}}, {{substr( $product->description, 0, 50)}}" style="font-family: 'sans-serif';">{{$product->product_code}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">نوع المُنتج</label>
                                <input type="text" readonly id="product_type" name="product_type" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">كود شجرة المُنتج</label>
                                <input type="text" id="product_tree_code" name="product_tree_code" class="form-control" readonly style="font-family: sans-serif">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">نوع شجرة المُنتج</label>
                                <select id="product_tree_type" name="product_tree_type" class="form-control">
                                    <option value="1">آخرى</option>
                                    <option value="0" class="standard-tree">قياسي</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">الوحدة</label>
                                <input type="text" id="product_unit" name="product_unit" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">قيمة الوحدة</label>
                                <input type="text" id="product_unit_value" name="product_unit_value" class="form-control" readonly style="font-family: sans-serif">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">الكمية</label>
                                <input type="number" min="1" id="quantity" name="quantity" class="form-control" style="font-family: 'sans-serif';" required>
                            </div>
                        </div>


                    </div>

                    <br>

                    <!-- ADD PRODUCTS TO TREE -->
                    <h3>إختر مُكونات الشجرة</h3>
                    <div class="total-budget-shower" >
                        <select class="selectpicker" id="product_tree_picker" data-show-subtext="true" data-live-search="true" style="font-family: 'sans-serif';">
                            <option value="">إختر المُنتج</option>
                            @foreach ($treeProducts as $product)
                                <option value="{{$product->id}}" data-subtext="{{$product->product_type}}, {{substr( $product->description, 0, 50)}}" style="font-family: 'sans-serif';">{{$product->product_code}}</option>
                            @endforeach

                        </select>

                        <div style="display: flex">
                            <button class="btn btn-primary pull-right" id="claculateTotalBudgetBtn">إحسب التكلُفة</button>
                            <input type="number" readonly id="totalBudgetField" name="total_budget" class="form-control pull-right" style="font-family: sans-serif;">
                            <br>
                        </div>
                    </div>

                    <table class="table table-responsive table-striped" id="productTreeTable" style="display: none;">
                        <thead style="font-size: 12px">
                            <th>كود الصنف</th>
                            <th>اسم الصنف</th>
                            <th>نوع الصنف</th>
                            <th>الوحدة</th>
                            <th>قيمة الوحدة</th>
                            <th>الكمية</th>
                            <th>كمية الفاقد</th>
                            <th>الإجمالي</th>
                            <th></th>
                        </thead>
                        <tbody style="font-size: 12px;">

                        </tbody>
                    </table>

                    <button class="btn btn-primary pull-right" id="addProductTreeBtn" style="display: none">إضافة شجرة المُنتج <i class="fa fa-plus"></i></button>

                </form>
            </div><!-- End Box-Item-Content -->
        </div><!-- End Box-Item -->
    </section><!--End Section-->



@stop

@section('scripts')
    <script type="text/javascript">
         // global app configuration object
        var config = {
            routes: {
                getProduct: "{{ url('/get-product-in-tree') }}",
                addProductTree: "{{ url('/add-product-tree') }}",
            },
            token: "{{csrf_token()}}"
        };
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/product_tree/add_product_tree.js') }}"></script>
@stop
