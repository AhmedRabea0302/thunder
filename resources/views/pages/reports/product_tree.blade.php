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
                <h3 class="title">تقرير شجرة منتج</h3>
            </div><!-- End Box-Item-Head -->
            <div class="box-item-content">
                <form action="{{ route('print-product-tree-report') }}" method="POST">
                    @csrf
                    <div class="row">
                        <select class="selectpicker" name="product_tree" id="product_tree_picker" data-show-subtext="true" data-live-search="true" style="font-family: 'sans-serif';">
                            <option value="">إختر شجرة المُنتج</option>
                            @foreach ($product_trees as $tree)
                                <option value="{{$tree->id}}" data-subtext="" style="font-family: 'sans-serif';">{{$tree->product_tree_code}}</option>
                            @endforeach

                        </select>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                        <div class="form-group">
                                <input type="submit" name="print" id="print" class="btn btn-info" value="طباعة">
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
