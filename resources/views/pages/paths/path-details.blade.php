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
            <h3 class="title">تفاصيل المسار</h3>
        </div><!-- End Box-Item-Head -->
        <div class="box-item-content">
            <form action="{{ route('update-path') }}" method="post" id="updatePathForm">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">تعديل القسم</label>
                            <br>
                            <select class="selectpicker" id="sector_picker" name="sector_picker_id" data-show-subtext="true" data-live-search="true" style="font-family: 'sans-serif';">
                                <option value="">تعيل القسم</option>
                                @foreach ($sectors as $sector)
                                    <option value="{{$sector->id}}" {{ $path->getPathSector->id == $sector->id ? 'selected' : '' }}>{{$sector->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="">كود المُنتج</label>
                            <input type="text" id="product_code" name="product_code" class="form-control" value="{{ $path->getPathMainProduct->product_code }}" readonly style="font-family: sans-serif">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">كود المسار</label>
                            <input type="text" id="path_code" name="path_code" class="form-control" data-id="{{ $path->id }}" value="{{ $path->path_code }}" readonly style="font-family: sans-serif">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">نوع المسار</label>
                            <select id="path_type" name="path_type" class="form-control">
                                <option value="1" {{ $path->path_type == 1 ? 'selected' : '' }}>آخرى</option>
                                <option value="0" {{ $path->path_type == 0 ? 'selected' : '' }}  class="standard-tree">قياسي</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">الكمية</label>
                            <input type="number" min="1" id="quantity" name="quantity" value="{{ $path->path_quantity }}" class="form-control" style="font-family: 'sans-serif';" required>
                        </div>
                    </div>


                </div>

                <br>

                <!-- ADD PRODUCTS TO TREE -->
                <h3>إضافة المراحل/المُعدات</h3>
                <div class="total-budget-shower" >
                    <select class="selectpicker" id="equipment_picker" data-show-subtext="true" data-live-search="true" style="font-family: 'sans-serif';">
                        <option value="">إضافة المعدة/المرحلة</option>
                        <option value="يدوي">يدوي</option>
                        @foreach ($equipments ?? '' as $equipment)
                            <option value="{{$equipment->id}}" style="font-family: 'sans-serif';">{{$equipment->equipment_code}}</option>
                        @endforeach

                    </select>

                    <div style="display: flex">
                        <button class="btn btn-primary pull-right" id="claculateTotalBudgetBtn">إحسب قيمة التشغيل للقطعة</button>
                        <input type="number" readonly id="totalBudgetField" name="total_budget" class="form-control pull-right" style="font-family: sans-serif;">
                        <br>
                    </div>
                </div>

                <table class="table table-responsive table-striped" id="pathTable">
                    <thead style="font-size: 12px">
                        <tr>
                            <th>النوع</th>
                            <th>كود المُعدة</th>
                            <th>اهلاك المُعدة/س</th>
                            <th>عدد العمال</th>
                            <th>أجر العامل/س</th>
                            <th>معدل الإنتاج</th>
                            <th>المصروفات</th>
                            <th>التشغيل/ساعة</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 12px;">
                        @foreach ($pathSteps as $step)
                            <tr>
                                {{-- <td >{{ $step->step_type }}</td>
                                <td style="font-family: 'sans-serif';">{{ ($step->step_type == "آلي") ? $step->equipmentDetails->equipment_code : '-' }}</td>
                                <td style="font-family: 'sans-serif';">{{ ($step->step_type == "آلي") ? $step->equipmentDetails->waste_per_hour : '-' }}</td>
                                <td style="font-family: 'sans-serif';">{{ ($step->step_type == "آلي") ? $step->equipmentDetails->workers_number : $step->workers_number }}</td>
                                <td style="font-family: 'sans-serif';">{{ ($step->step_type == "آلي") ? $step->equipmentDetails->worker_hour_pay : $step->worker_hour_pay }}</td>
                                <td style="font-family: 'sans-serif';">{{ $step->production_time_rate }}</td>
                                <td style="font-family: 'sans-serif';">{{ $step->stepExpenses->sum('expense_value') }}</td>
                                <td style="font-family: 'sans-serif';">{{ $step->step_total_budget }}</td> --}}


                                <td style="display: none"><input type="hidden" name="equipment_id[]" class="equipment_id" value="{{ $step->equipment_id }}" /></td>
                                <td>
                                    <input type="text" readonly name="types[]" class="form-control type" value="{{ $step->step_type }}" required />
                                </td>
                                <td style="font-family: sans-serif">
                                    <input type="text" readonly name="equipment_codes[]" class="form-control equipment_code" value="{{ ($step->step_type == "آلي") ? $step->equipmentDetails->equipment_code : '-' }}" required />
                                </td>
                                <td class="" style="font-family: sans-serif">
                                    <input type="text" readonly name="wastes_per_hour[]" class="form-control waste_per_hour" value="{{ ($step->step_type == "آلي") ? $step->equipmentDetails->waste_per_hour : '-' }}" required />
                                </td>
                                <td class="">
                                    <input type="number" min="1" readonly name="workers_numbers[]" class="form-control workers_number" value="{{ ($step->step_type == "آلي") ? $step->equipmentDetails->workers_number : $step->workers_number }}" required />
                                </td>
                                <td class="">
                                    <input type="number" readonly name="worker_hour_pays[]" class="form-control worker_hour_pay" value="{{ ($step->step_type == "آلي") ? $step->equipmentDetails->worker_hour_pay : $step->worker_hour_pay }}" required />
                                </td>
                                <td style="font-family: sans-serif">
                                    <input type="number" min="0" name="production_time_rate[]" class="form-control production_time_rate" placeholder="مُعدل الإنتاج بالدقيقة" value="{{ $step->production_time_rate }}"required />
                                </td>
                                <td style="font-family: sans-serif; display: flex; align-items: center">
                                    <input type="number" min="0" readonly name="expenses[]" class="form-control expenses" placeholder="(المصروفات)" required value="{{ $step->stepExpenses->sum('expense_value') }}" />
                                    <i class="fa fa-plus add-expenses" data-toggle="modal" data-target="#addExpensesModal"></i>
                                </td>
                                <td style="font-family: sans-serif">
                                    <input readonly type="number" min="0" name="total_for_row[]" class="form-control total" value="{{ $step->step_total_budget}}" placeholder="قيمة التشغيل/س" required />
                                </td>
                                <td>
                                    <i class="fa fa-trash-o btn btn-danger delete-step" style="cursor: pointer;"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button class="btn btn-primary pull-right" id="addPathBtn">تعديل المسار  <i class="fa fa-pencil"></i></button>

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
@endsection

@section('scripts')
    <script type="text/javascript">
         // global app configuration object
        pathId = document.getElementById('path_code').getAttribute('data-id');
        var config = {
            routes: {
                getEquipment: "{{ url('/get-equipment') }}",
                addPath: "{{ url('/add-path') }}",
                getAllPathExpenses: "{{ url('/get-path-expenses/') }}"+ '/' + pathId
            },
            token: "{{csrf_token()}}"
        };
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/paths/update-path.js') }}"></script>
@stop
