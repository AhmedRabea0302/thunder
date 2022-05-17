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
                <h3 class="title">تفاصيل شجرة المنتج - <span class="badge" style="font-family: sans-serif; background: #f89842;">{{ $product_tree->product_tree_code }}</span></h3>
                <i class="fa fa-angle-down"></i>
            </div><!-- End Box-Item-Head -->
            <div class="box-item-content">

                <form action="{{ route('update-product-tree', ['id' => $product_tree->id]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">كود المُنتج</label>
                                <input type="text" value="{{ $product_tree->getTreeMainProduct->product_code }}" readonly id="product_type" name="product_type" class="form-control" required style="font-family: sans-serif">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">نوع المُنتج</label>
                                <input type="text" readonly
                                value="{{ $product_tree->getTreeMainProduct->product_type }}"
                                id="product_type" name="product_type" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">كود شجرة المُنتج</label>
                                <input type="text" value="{{ $product_tree->product_tree_code }}" id="product_tree_code" name="product_tree_code" class="form-control" readonly style="font-family: sans-serif">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">نوع شجرة المُنتج</label>
                                <select id="product_tree_type" name="product_tree_type" class="form-control">
                                    <option {{ $product_tree->product_tree_type == "1" ? 'selected' : ''}} value="1">آخرى</option>
                                    <option {{ $product_tree->product_tree_type == "0" ? 'selected' : ''}} value="0" class="standard-tree">قياسي</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">الوحدة</label>
                                <input type="text" value="{{ $product_tree->getTreeMainProduct->unit }}" id="product_unit" name="product_unit" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">قيمة الوحدة</label>
                                <input type="text" value="{{ $product_tree->getTreeMainProduct->unit_value }}" id="product_unit_value" name="product_unit_value" class="form-control" readonly style="font-family: sans-serif">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">الكمية</label>
                                <input type="number" value="{{ $product_tree->quantity }}" min="0" step="0.1" id="quantity" name="quantity" class="form-control" style="font-family: 'sans-serif';" required>
                            </div>
                        </div>


                    </div>

                    <br>

                    <!-- ADD PRODUCTS TO TREE -->
                    <h3>إضافة مُكون جديد</h3>
                    <div class="total-budget-shower" >
                        <select class="selectpicker" id="product_tree_picker" data-show-subtext="true" data-live-search="true" style="font-family: 'sans-serif';">
                            <option value="">إختر المُنتج</option>
                            @foreach ($treeProducts as $product)
                                <option value="{{$product->id}}" data-subtext="{{$product->product_type}}, {{substr( $product->description, 0, 50)}}" style="font-family: 'sans-serif';">{{$product->product_code}}</option>
                            @endforeach

                        </select>

                        <div style="display: flex">
                            <button class="btn btn-primary pull-right" id="claculateTotalBudgetBtn">إحسب التكلُفة</button>
                            <input type="number" value="{{ $product_tree->getTreeMainProduct->unit_value }}" readonly id="totalBudgetField" name="total_budget" class="form-control pull-right" style="font-family: sans-serif;">
                            <br>
                        </div>
                    </div>

                    <table class="table table-responsive table-striped" id="productTreeTable">
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
                            @foreach($productsInthisTree as $product)
                                <tr>

                                    <td style="display: none">
                                        <input type="hidden" name="ids[]" value="{{ $product->id }}" />
                                        <input type="hidden" name="product_id[]" value="{{ $product->product_id }}" />
                                    </td>
                                    <td style="font-family: sans-serif">{{ $product->getProductDetails->product_code }}</td>
                                    <td>{{ substr($product->getProductDetails->description, 0, 15) }}</td>
                                    <td>{{ $product->getProductDetails->product_type }}</td>
                                    <td>{{ $product->getProductDetails->unit }}</td>
                                    <td class="product_unit_value" style="font-family: sans-serif">{{ $product->getProductDetails->unit_value }}</td>
                                    <td style="font-family: sans-serif">
                                        <input type="number" min="0" value="{{ $product->quantity }}" name="product_quantity[]" class="form-control product_quantity" placeholder="الكمية" required />
                                    </td>
                                    <td style="font-family: sans-serif">
                                        <input type="number" min="0" value="{{ $product->wasted_quantity }}" name="wasted_quantity[]" class="form-control wasted_amount" placeholder="(نسبة مئوية)" required />
                                    </td>
                                    <td style="font-family: sans-serif">
                                        <input readonly type="number" min="0" value="{{ $product->total_quantity }}" name="total_quantity[]" class="form-control total" placeholder="الإجمالي" required />
                                    </td>
                                    <td>
                                        <i class="fa fa-trash-o btn btn-danger" style="cursor: pointer;"></i>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button class="btn btn-primary pull-right" id="addProductTreeBtn">تعديل شجرة المُنتج <i class="fa fa-pencil"></i></button>

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
            deleteProductFromTree: "{{ url('/delete-product-from-tree') }}",
       },
       token: "{{csrf_token()}}"
   };
</script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/product_tree/update_product_tree.js') }}"></script>
@stop
