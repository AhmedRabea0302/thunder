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
                <h3 class="title">إضافة مسار</h3>
            </div><!-- End Box-Item-Head -->
            <div class="box-item-content">
                <form action="{{ route('add-path') }}" method="post" id="addPathForm">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">إختر القسم</label>
                                <br>
                                <select class="selectpicker" id="sector_picker" name="sector_picker_id" data-show-subtext="true" data-live-search="true" style="font-family: 'sans-serif';">
                                    <option value="">إختر القسم</option>
                                    @foreach ($sectors as $sector)
                                        <option value="{{$sector->id}}">{{$sector->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">إختر المُنتج</label>
                                <br>
                                <select class="selectpicker" id="product_picker" name="product_tree_id" data-show-subtext="true" data-live-search="true" style="font-family: 'sans-serif';">
                                    <option value="">إختر المُنتج</option>
                                    @foreach ($products as $product)
                                        @if ($product->getProductTrees->count() > 0)
                                            <option value="{{$product->id}}" data-subtext="{{$product->product_type}}, {{substr( $product->description, 0, 50)}}" style="font-family: 'sans-serif';">{{$product->product_code}}</option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">كود المسار</label>
                                <input type="text" id="path_code" name="path_code" class="form-control" readonly style="font-family: sans-serif">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">نوع المسار</label>
                                <select id="path_type" name="path_type" class="form-control">
                                    <option value="1" class="other-path">آخرى</option>
                                    <option value="0" class="standard-path">قياسي</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">وحدة المنتج</label>
                                <input type="text" id="product_unit" name="product_unit" class="form-control" readonly style="font-family: sans-serif">
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
                    <h3>إختر المراحل/المُعدات</h3>
                    <div class="total-budget-shower" >
                        <select class="selectpicker" id="equipment_picker" data-show-subtext="true" data-live-search="true" style="font-family: 'sans-serif';">
                            <option value="">إختر المعدة/المرحلة</option>
                            <option value="يدوي">يدوي</option>
                            @foreach ($equipments ?? '' as $equipment)
                                <option value="{{$equipment->id}}" style="font-family: 'sans-serif';">{{$equipment->equipment_code}}</option>
                            @endforeach

                        </select>

                        <div style="display: flex">
                            <button class="btn btn-primary pull-right" id="claculateTotalBudgetBtn">إحسب قيمة التشغيل للوحدة</button>
                            <input type="number" readonly id="totalBudgetField" name="total_budget" class="form-control pull-right" style="font-family: sans-serif;">
                            <br>
                        </div>
                    </div>

                    <table class="table table-responsive table-striped" id="pathTable" style="display: none">
                        <thead style="font-size: 12px">
                            <th>النوع</th>
                            <th>كود المُعدة</th>
                            <th>اهلاك المُعدة/س</th>
                            <th>عدد العمال</th>
                            <th>أجر العامل/س</th>
                            <th>معدل الإنتاج</th>
                            <th>المصروفات</th>
                            <th>التشغيل</th>
                            <th></th>
                        </thead>
                        <tbody style="font-size: 12px;">

                        </tbody>
                    </table>

                    <button class="btn btn-primary pull-right" id="addPathBtn" style="display: none">إضافة المسار <i class="fa fa-plus"></i></button>

                </form>
            </div><!-- End Box-Item-Content -->
        </div><!-- End Box-Item -->
    </section><!--End Section-->


    <!-- ADD EXPENSES MODAL -->
    <div id="addExpensesModal" class="modal fade" tabindex="-1" role="dialog">

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header modal-background">
              <button type="button" class="close close-color" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">إضافة المصروفات</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="meesages">
                            <div class="alert update alert-success" style="display: none">تم تعديل المُعدة بنجاح!</div>
                            <div class="alert update alert-danger" style="display: none"><ul></ul></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="all-expenses">

                        </div>
                        <div style="display: flex; align-items: center; flex-direction: row; justify-content: space-between;">
                            <button class="btn btn-primary" id="addExpense"><i class="fa fa-plus"></i> </button>
                            <span class="modal-total-expenses badge pull-right" id="modalTotalExpenses" style="display: none"></span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer modal-background">
                <button type="button" class="btn btn-primary pull-left" id="addExpenses">إضافة <i class="fa fa-plus"></i></button>
                <i class="fa fa-calculator check-expense" id="check-expense" style="display: none"></i>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


@stop

@section('scripts')
    <script type="text/javascript">
         // global app configuration object
        var config = {
            routes: {
                getEquipment: "{{ url('/get-equipment') }}",
                addPath: "{{ url('/add-path') }}",
                checkProductPaths: "{{ url('/check-standard-path-for-the-product') }}",
                getProduct: "{{ url('/get-product') }}"
            },
            token: "{{csrf_token()}}"
        };
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/paths/add_path.js') }}"></script>
@stop
