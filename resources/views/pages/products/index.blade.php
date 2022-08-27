@extends('layouts.master')
@section('content')
    <section>
        <div class="box-item">
            <div class="box-item-head">
                <h3 class="title"> المنتجات
                    <span class="badge badge-info" style="font-family: 'sans-serif'; background: #f89842">{{$productsCount}}</span>
                </h3>
                <button class="pull-right btn btn-info add-product" data-toggle="modal" data-target="#addProductModal" style="background: #f89842; border: none">
                    إضافة مٌنتج <i class="fa fa-plus"></i>
                </button>
            </div><!-- End Box-Item-Head -->
            <div class="box-item-content">
                <!-- PRODUCT Filters -->
                <form action="{{route('products')}}" method="GET">

                    <div class="products-filters">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="product_code" class="form-control product_code_filter" placeholder="كود المُنتج">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">بحــث <i class="fa fa-search"></i></button>

                        </div>
                    </div>
                </form>


                @if($products->count() > 0)

                    <table class="table table-responsive table-striped">
                        <thead>
                            <th>#</th>
                            <th>كود المُنتج</th>
                            <th>نوع المُنتج</th>
                            <th>وصف المُنتج</th>
                            <th>الوحدة</th>
                            <th>قيمة الوحدة</th>
                            <th>خيارات</th>
                        </thead>

                        <tbody>
                            @foreach ($products as $index => $product)
                                <tr>
                                    <td style="font-family: 'sans-serif'">{{ $index +1 }}</td>
                                    <td style="font-family: 'sans-serif'">{{ $product->product_code }}</td>
                                    <td>{{ $product->product_type }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td style="font-family: 'sans-serif'">{{ $product->unit_value }}</td>
                                    <td>
                                        <button class="btn btn-success update-product" data-toggle="modal" data-target="#updateProductModal" data-id="{{ $product->id }}"> تعديل <i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-danger delete-product" disabled> حذف <i class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->appends(request()->query())->links() }}


                @else
                    <h2>ﻻ توجد منتجات</h2>
                @endif

            </div><!-- End Box-Item-Content -->
        </div><!-- End Box-Item -->
    </section><!--End Section-->

    <!-- /ADD PRODUCT MODAL -->
    <div id="addProductModal" class="modal fade" tabindex="-1" role="dialog">


        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header modal-background">
              <button type="button" class="close close-color" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">إضافة مٌنتج</h4>
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
                        <label for="">كود المُنتج</label>
                        <input type="text" name="product_code" class="form-control product_code_modal" style="font-family: 'sans-serif'">
                        <small>لابد أن يكون أطول من 8 حروف وأقل من 16 حرف</small>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">نوع المُنتج</label>
                        <select name="product_type" id="product_type" class="form-control">
                            <option value="تام">تام</option>
                            <option value="نصف مُصنع">نصف مُصنع</option>
                            <option value="خامات">خامات</option>
                            <option value="تعبئة و تغليف">تعبئة و تغليف</option>
                            <option value="إعادة تشغيل">إعادة تشغيل</option>
                            <option value="تالف">تالف</option>
                        </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">الوحدة</label>
                        <input type="text" name="unit" class="form-control">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">قيمة الوحدة</label>
                        <input type="number" min="1" name="unit_value" class="form-control" style="font-family: 'sans-serif'">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">وصف المُنتج</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="4"></textarea>
                    </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer modal-background">
              <button type="button" class="btn btn-primary" id="post-product">إضافة <i class="fa fa-plus"></i></button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


      <!-- UPDATE PRODUCT MODAL -->
    <div id="updateProductModal" class="modal fade" tabindex="-1" role="dialog">

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header modal-background">
              <button type="button" class="close close-color" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">تعديل المٌنتج</h4>

            </div>
            <div class="modal-body">

              <div class="row">
                  <div class="col-md-12">
                    <div class="meesages">
                        <div class="alert update alert-success" style="display: none">تم تعديل المُنتج بنجاح!</div>
                        <div class="alert update alert-danger" style="display: none"><ul></ul></div>
                      </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">كود المُنتج</label>
                        <input type="text" disabled name="product_code" class="form-control product_code_update" style="font-family: 'sans-serif'">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">نوع المُنتج</label>
                        <select name="product_type" id="product_type" class="form-control product_type_update">
                            <option value="تام">تام</option>
                            <option value="نصف مُصنع">نصف مُصنع</option>
                            <option value="تعبئة و تغليف">تعبئة و تغليف</option>
                            <option value="إعادة تشغيل">إعادة تشغيل</option>
                            <option value="تالف">تالف</option>
                        </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">الوحدة</label>
                        <input type="text" name="unit" class="form-control unit_update">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">قيمة الوحدة</label>
                        <input type="number" min="1" name="unit_value" class="form-control unit_value_update" style="font-family: 'sans-serif'">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">وصف المُنتج</label>
                        <textarea name="description" id="description" class="form-control description_update" cols="30" rows="4"></textarea>
                    </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer modal-background">
              <button type="button" class="btn btn-primary" id="post-update-product">تعديل <i class="fa fa-pencil"></i></button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
@stop

<script>
    // global app configuration object
    var config = {
        routes: {
            addProduct: "{{ url('/add-product') }}",
            updateProduct: "{{ url('/update-product') }}",
            getProduct: "{{ url('/get-product') }}",
            deleteProduct: "{{ url('/delete-product') }}"
        },
        token: "{{csrf_token()}}"
    };
</script>
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/products/products.js') }}"></script>
@stop
