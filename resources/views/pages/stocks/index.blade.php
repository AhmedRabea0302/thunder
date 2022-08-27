@extends('layouts.master')
@section('content')
    <section>
        <div class="box-item">
            <div class="box-item-head">
                <h3 class="title"> المخازن
                    <span class="badge badge-info" style="font-family: 'sans-serif'; background: #f89842">{{$stocksCount}}</span>
                </h3>
                <button class="pull-right btn btn-info add-stock" data-toggle="modal" data-target="#addStockModal" style="background: #f89842; border: none">
                    إضافة مخزن <i class="fa fa-plus"></i>
                </button>
            </div><!-- End Box-Item-Head -->
            <div class="box-item-content">
                <!-- PRODUCT Filters -->
                <form action="{{route('all-stocks')}}" method="GET">

                    <div class="stocks-filter">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="stock_name" class="form-control stock_name_filter" placeholder="المخزن">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">بحــث <i class="fa fa-search"></i></button>

                        </div>
                    </div>
                </form>


                @if($stocks->count() > 0)

                    <table class="table table-responsive table-striped">
                        <thead>
                            <th>#</th>
                            <th>كود المخزن</th>
                            <th>اسم المخزن</th>
                            <th>مكان المخزن</th>
                            <th>أمين المخزن</th>
                            <th>خيارات</th>
                        </thead>

                        <tbody>
                            @foreach ($stocks as $index => $stock)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td style="font-family: sans-serif" class="stock-table-code">{{ $stock->stock_code }}</td>
                                    <td class="stock-table-name">{{ $stock->stock_name }}</td>
                                    <td class="stock-table-place">{{ $stock->stock_place }} </td>
                                    <td class="stock-table-manager">{{ $stock->stock_manager }}</td>
                                    <td>
                                        <button class="btn btn-success update-stock" data-toggle="modal" data-target="#updateStockModal" data-id="{{ $stock->id }}"> تعديل <i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-danger delete-stock" disabled data-id="{{ $stock->id }}"> حذف <i class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $stocks->appends(request()->query())->links() }}


                @else
                    <h2>ﻻ توجد أقسام</h2>
                @endif

            </div><!-- End Box-Item-Content -->
        </div><!-- End Box-Item -->
    </section><!--End Section-->

    <!-- /ADD stock MODAL -->
    <div id="addStockModal" class="modal fade" tabindex="-1" role="dialog">


        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header modal-background">
              <button type="button" class="close close-color" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">إضافة مخزن</h4>

            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                    <div class="meesages">
                        <div class="alert alert-success" style="display: none">تم إضافة المخزن بنجاح!</div>
                        <div class="alert alert-danger" style="display: none"><ul></ul></div>
                    </div>
                </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">كود المخزن</label>
                        <input type="text" name="stock_code_modal" class="form-control stock_code_modal" style="border: 2px solid #ccc; font-family: sans-serif">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">اسم المخزن</label>
                        <input type="text" name="stock_name_modal" class="form-control" style="border: 2px solid #ccc">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">مكان المخزن</label>
                        <input type="text" name="stock_place" class="form-control" style="border: 2px solid #ccc">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">أمين المخزن</label>
                        <input type="text" name="stock_manager" class="form-control" style="border: 2px solid #ccc">
                    </div>
                  </div>

              </div>
            </div>
            <div class="modal-footer modal-background">
              <button type="button" class="btn btn-primary" id="post-stock">إضافة <i class="fa fa-plus"></i></button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


      <!-- UPDATE stock MODAL -->
    <div id="updateStockModal" class="modal fade" tabindex="-1" role="dialog">

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header modal-background">
              <button type="button" class="close close-color" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">تعديل المخزن</h4>

            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                    <div class="meesages">
                        <div class="alert update alert-success" style="display: none">تم تعديل المخزن بنجاح!</div>
                        <div class="alert update alert-danger" style="display: none"><ul></ul></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">كود المخزن</label>
                        <input type="text" readonly name="stock_code_update_modal" class="form-control stock_code_modal" style="border: 2px solid #ccc; font-family: sans-serif">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">اسم المخزن</label>
                        <input type="text" name="stock_name_update_modal" class="form-control" style="border: 2px solid #ccc">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">مكان المخزن</label>
                        <input type="text" name="stock_place_update_modal" class="form-control" style="border: 2px solid #ccc">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">أمين المخزن</label>
                        <input type="text" name="stock_manager_update_modal" class="form-control" style="border: 2px solid #ccc">
                    </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer modal-background">
              <button type="button" class="btn btn-primary" id="post-update-stock">تعديل <i class="fa fa-pencil"></i></button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
@stop

<script>
    // global app configuration object
    var config = {
        routes: {
            addStock: "{{ url('/add-stock') }}",
            updateStock: "{{ url('/update-stock') }}",
            getStock: "{{ url('/get-stock') }}",
            deleteStock: "{{ url('/delete-stock') }}"
        },
        token: "{{csrf_token()}}"
    };
</script>
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/stocks/stocks.js') }}"></script>
@stop
