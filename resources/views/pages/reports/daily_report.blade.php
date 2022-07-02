@extends('layouts.master')
    @section('content')
    <style>
        .box-item-content {
            overflow-y: scroll;
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
                <h3 class="title">تقرير المنتجات اليومية</h3>
            </div><!-- End Box-Item-Head -->
            <div class="box-item-content">
                <form action="{{ route('print-products-report') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">تاريخ اليوم</label>
                                <input type="date" name="date" id="date" class="form-control" style="font-family: sans-serif" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        <div class="form-group">
                                <input type="submit" name="prin" id="print" class="btn btn-info" value="طباعة">
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- End Box-Item-Content -->
        </div><!-- End Box-Item -->
    </section><!--End Section-->

@stop

<!-- @section('scripts')
    <script type="text/javascript">
         // global app configuration object
        var config = {
            routes: {
                getEquipment: "{{ url('/get-equipment') }}",
                addPath: "{{ url('/add-path') }}",
                checkProductPaths: "{{ url('/check-standard-path-for-the-product') }}",
            },
            token: "{{csrf_token()}}"
        };
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/paths/add_path.js') }}"></script>
@stop -->
