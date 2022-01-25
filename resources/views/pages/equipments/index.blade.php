@extends('layouts.master')
@section('content')
    <section>
        <div class="box-item">
            <div class="box-item-head">
                <h3 class="title"> المُعدات
                    <span class="badge badge-info" style="font-family: 'sans-serif'; background: #f89842">{{$equipmentsCount}}</span>
                </h3>
                <button class="pull-right btn btn-info add-equipment" data-toggle="modal" data-target="#addEquipmentModal" style="background: #f89842; border: none">
                    إضافة مُعدة <i class="fa fa-plus"></i>
                </button>
            </div><!-- End Box-Item-Head -->
            <div class="box-item-content">
                <!-- PRODUCT Filters -->
                <form action="{{route('all-equipments')}}" method="GET">

                    <div class="sectors-filter">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="equipment_code" class="form-control equipment_code_filter" placeholder="كود المُعدة">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">بحــث <i class="fa fa-search"></i></button>

                        </div>
                    </div>
                </form>


                @if($equipments->count() > 0)

                    <table class="table table-responsive table-striped">
                        <thead>
                            <th>#</th>
                            <th>كود المُعدة</th>
                            <th>عدد العمال</th>
                            <th>أجر العامل بالساعة</th>
                            <th>اهلاك المُعدة بالساعة</th>
                            <th>وصف المُعدة</th>
                            <th>خيارات</th>
                        </thead>

                        <tbody>
                            @foreach ($equipments as $index => $equipment)
                                <tr>
                                    <td  style="font-family: 'sans-serif'">{{ $index + 1 }}</td>
                                    <td  style="font-family: 'sans-serif'">{{ $equipment->equipment_code }}</td>
                                    <td  style="font-family: 'sans-serif'">{{ $equipment->workers_number }}</td>
                                    <td  style="font-family: 'sans-serif'">{{ $equipment->worker_hour_pay }}</td>
                                    <td  style="font-family: 'sans-serif'">{{ $equipment->waste_per_hour }}</td>
                                    <td>{{ $equipment->description ? substr($equipment->description, 0, 9) .' ...' : '' }}</td>
                                    <td>
                                        <button class="btn btn-success update-equipment" data-toggle="modal" data-target="#updateEquipmentModal" data-id="{{ $equipment->id }}"> تعديل <i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-danger delete-equipment" disabled data-id="{{ $equipment->id }}"> حذف <i class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $equipments->appends(request()->query())->links() }}


                @else
                    <h2>ﻻ توجد مُعدات</h2>
                @endif

            </div><!-- End Box-Item-Content -->
        </div><!-- End Box-Item -->
    </section><!--End Section-->

    <!-- /ADD EQUIPMENT MODAL -->
    <div id="addEquipmentModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header modal-background">
              <button type="button" class="close close-color" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">إضافة مُعدة</h4>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="meesages">
                            <div class="alert alert-success" style="display: none">تم إضافة المُنتج بنجاح!</div>
                            <div class="alert alert-danger" style="display: none"><ul></ul></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="">كود المُعدة</label>
                          <input type="text" disabled name="equipment_codeadd" class="form-control" style="font-family: 'sans-serif'">
                      </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">عد العمال</label>
                            <input type="number" min="1" name="workers_number" class="form-control" style="font-family: 'sans-serif'">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">أجر العامل بالساعة</label>
                            <input type="number" min="1" name="worker_hour_pay" class="form-control" style="font-family: 'sans-serif'">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">إهلاك المُعدة بالساعة</label>
                            <input type="number" min="1" name="equipment_waste" class="form-control" style="font-family: 'sans-serif'">
                        </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">وصف المُعدة</label>
                          <textarea name="description" id="description" class="form-control" cols="30" rows="4"></textarea>
                      </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modal-background">
              <button type="button" class="btn btn-primary" id="post-equipment">إضافة <i class="fa fa-plus"></i></button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


      <!-- UPDATE Equipment MODAL -->
    <div id="updateEquipmentModal" class="modal fade" tabindex="-1" role="dialog">

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header modal-background">
              <button type="button" class="close close-color" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">تعديل المُعدة</h4>

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
                        <div class="meesages">
                            <div class="alert alert-success" style="display: none">تم تعديل المُنتج بنجاح!</div>
                            <div class="alert alert-danger" style="display: none"><ul></ul></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="">كود المُعدة</label>
                          <input type="text" disabled name="equipment_code_update" class="form-control" style="font-family: 'sans-serif'">
                      </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">عد العمال</label>
                            <input type="number" min="1" name="workers_number_update" class="form-control" style="font-family: 'sans-serif'">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">أجر العامل بالساعة</label>
                            <input type="number" min="1" name="worker_hour_pay_update" class="form-control" style="font-family: 'sans-serif'">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">إهلاك المُعدة بالساعة</label>
                            <input type="number" min="1" name="equipment_waste_update" class="form-control" style="font-family: 'sans-serif'">
                        </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">وصف المُعدة</label>
                          <textarea name="description_update" id="description" class="form-control" cols="30" rows="4"></textarea>
                      </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modal-background">
              <button type="button" class="btn btn-primary" id="post-update-equipment">تعديل <i class="fa fa-pencil"></i></button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
@stop

<script>
    // global app configuration object
    var config = {
        routes: {
            addEquipment: "{{ url('/add-equipment') }}",
            updateEquipment: "{{ url('/update-equipment') }}",
            getEquipment: "{{ url('/get-equipment') }}",
            deleteEquipment: "{{ url('/delete-equipment') }}"
        },
        token: "{{csrf_token()}}"
    };
</script>
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/equipments/equipments.js') }}"></script>
@stop
