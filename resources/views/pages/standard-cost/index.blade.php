@extends('layouts.master')
@section('content')
    <style>
        .box-item-content {
            overflow-y: scroll;
        }

        .bootstrap-select{
            width: 100%;
        }

        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
            width: 100%;
        }

        .selectpicker button,
        .btn.dropdown-toggle.selectpicker.btn-default {
            font-family: sans-serif;
            height: 41px;
            border: 2px solid #f88045
        }
    </style>
    <section>
        <div class="box-item">

            @if(Session()->has('message'))
                <div class="alert alert-success">
                    <p>{{ Session()->get('message') }}</p>
                </div>
            @endif
            
            <div class="box-item-head">
                <h3 class="title"> التكلُفة المعيارية</h3>
            </div><!-- End Box-Item-Head -->

            <div class="box-item-content" style="padding: 30px 15px">

                <div class="select-product-box">
                    <label for="">إختر المُنتج لحساب التكلُفة المعيارية</label>
                    <select class="selectpicker" id="product_picker" data-show-subtext="true" data-live-search="true" style="font-family: 'sans-serif';">
                        <option value="">إختر المُنتج</option>
                        @foreach ($products as $product)
                        @if ($product->getProductTrees->count() > 0 && $product->getProductPaths->count() > 0)
                            <option value="{{$product->id}}" data-subtext="{{$product->product_type}}, {{substr( $product->description, 0, 50)}}" style="font-family: 'sans-serif';">{{$product->product_code}}</option>
                        @endif
                        @endforeach

                    </select>
                    <br>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="calculate-standard-cost">
                                <div class="tree-paster col-md-6 draggable">
                                    <span class="tree-code" style="font-family: 'sans-serif';"></span>
                                    <span class="tree-budget" style="font-family: 'sans-serif';"></span>
                                </div>
                                <div class="path-paster col-md-6 draggable">
                                    <span class="path-code" style="font-family: 'sans-serif';"></span>
                                    <span class="path-budget" style="font-family: 'sans-serif';"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="" id="standardCost" class="form-control" style="font-family: 'sans-serif'; width:100%">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="trees">
                                
                                <ul class="list-unstyled trees-list">

                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="paths">
                                <ul class="list-unstyled paths-list">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>

                <div class="row">
                   <div class="col-md-12">
                    <div class="form-group">
                            <input type="submit" class="btn btn-info change-product-price" value="تحديد السعر">
                        </div>
                   </div>
                </div>
                <br><br><br><br>
            </div><!-- End Box-Item-Content -->
        </div><!-- End Box-Item -->
    </section><!--End Section-->

@stop

@section('scripts')
<script type="text/javascript">
    // global app configuration object
    var config = {
        routes: {
            getProductPathsAndTrees: "{{ url('/get-product-paths-and-trees') }}",
            updateProductStandardCost: "{{ url('/update-product-standard-cost') }}"
        },
        token: "{{csrf_token()}}"
    };
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/standard-cost/stdcost.js') }}"></script>
@stop
