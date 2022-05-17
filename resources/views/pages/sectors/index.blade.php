@extends('layouts.master')
@section('content')
    <section>
        <div class="box-item">
            <div class="box-item-head">
                <h3 class="title"> الأقسام
                    <span class="badge badge-info" style="font-family: 'sans-serif'; background: #f89842">{{$sectorsCount}}</span>
                </h3>
                <button class="pull-right btn btn-info add-sector" data-toggle="modal" data-target="#addSectorModal" style="background: #f89842; border: none">
                    إضافة قسم <i class="fa fa-plus"></i>
                </button>
            </div><!-- End Box-Item-Head -->
            <div class="box-item-content">
                <!-- PRODUCT Filters -->
                <form action="{{route('all-sectors')}}" method="GET">

                    <div class="sectors-filter">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="sector_name" class="form-control sector_name_filter" placeholder="القسم">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">بحــث <i class="fa fa-search"></i></button>

                        </div>
                    </div>
                </form>


                @if($sectors->count() > 0)

                    <table class="table table-responsive table-striped">
                        <thead>
                            <th>#</th>
                            <th>القسم</th>
                            <th>خيارات</th>
                        </thead>

                        <tbody>
                            @foreach ($sectors as $index => $sector)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="sector-text">{{ $sector->name }}</td>
                                    <td>
                                        <button class="btn btn-success update-sector" data-toggle="modal" data-target="#updateSectorModal" data-id="{{ $sector->id }}"> تعديل <i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-danger delete-sector" disabled data-id="{{ $sector->id }}"> حذف <i class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $sectors->appends(request()->query())->links() }}


                @else
                    <h2>ﻻ توجد أقسام</h2>
                @endif

            </div><!-- End Box-Item-Content -->
        </div><!-- End Box-Item -->
    </section><!--End Section-->

    <!-- /ADD SECTOR MODAL -->
    <div id="addSectorModal" class="modal fade" tabindex="-1" role="dialog">


        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header modal-background">
              <button type="button" class="close close-color" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">إضافة قسم</h4>

            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                    <div class="meesages">
                        <div class="alert alert-success" style="display: none">تم إضافة القسم بنجاح!</div>
                        <div class="alert alert-danger" style="display: none"><ul></ul></div>
                    </div>
                </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">اسم القسم</label>
                        <input type="text" name="sector" class="form-control" style="border: 2px solid #ccc">
                    </div>
                  </div>

              </div>
            </div>
            <div class="modal-footer modal-background">
              <button type="button" class="btn btn-primary" id="post-sector">إضافة <i class="fa fa-plus"></i></button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


      <!-- UPDATE SECTOR MODAL -->
    <div id="updateSectorModal" class="modal fade" tabindex="-1" role="dialog">

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header modal-background">
              <button type="button" class="close close-color" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">تعديل القسم</h4>

            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                    <div class="meesages">
                        <div class="alert update alert-success" style="display: none">تم تعديل القسم بنجاح!</div>
                        <div class="alert update alert-danger" style="display: none"><ul></ul></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">اسم القسم</label>
                        <input type="text" name="name" id="sector_name" class="form-control sector_name" style="border: 2px solid #ccc"/>
                    </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer modal-background">
              <button type="button" class="btn btn-primary" id="post-update-sector">تعديل <i class="fa fa-pencil"></i></button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
@stop

<script>
    // global app configuration object
    var config = {
        routes: {
            addSector: "{{ url('/add-sector') }}",
            updateSector: "{{ url('/update-sector') }}",
            getSector: "{{ url('/get-sector') }}",
            deleteSector: "{{ url('/delete-sector') }}"
        },
        token: "{{csrf_token()}}"
    };
</script>
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/sectors/sectors.js') }}"></script>
@stop
