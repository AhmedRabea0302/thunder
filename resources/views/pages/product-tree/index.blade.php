@extends('layouts.master')
@section('content')

    <section>
        @if(Session()->has('message'))
            <div class="alert alert-success">
                <p>{{ Session()->get('message') }}</p>
            </div>
        @endif
        <div class="box-item">
            <div class="box-item-head">
                <h3 class="title">شجرة المُنتج</h3>
                <a href="{{ route('get-add-product-tree') }}" class="pull-right btn btn-info add-product" style="background: #f89842; border: none">
                    إضافة شجرة مٌنتج <i class="fa fa-plus"></i>
                </a>
            </div><!-- End Box-Item-Head -->
            <div class="box-item-content">

                <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>كود الشجرة</th>
                        <th>كود  المُنتج</th>
                        <th>إسم المُنتج</th>
                        <th>نوع شجرة المُنتج</th>
                        <th>عدد المكونات</th>
                        <th>
                            خيارات
                        </th>
                    </thead>

                    <tbody>
                        @foreach ($product_trees as $index => $product_tree)
                            <tr>
                                <td style="font-family: sans-serif">{{$index + 1}}</td>
                                <td style="font-family: sans-serif">{{ $product_tree->product_tree_code }}</td>
                                <td style="font-family: sans-serif">{{ $product_tree->getTreeMainProduct->product_code }}</td>
                                <td>{{ substr($product_tree->getTreeMainProduct->description, 0, 15) }}</td>
                                <td>{{ $product_tree->getTreeMainProduct->product_tree_type == 0 ? 'آخرى' : 'قياسي' }}</td>
                                <td style="font-family: sans-serif">{{ $product_tree->prouctTreeProucts->count() }}</td>
                                <td>
                                    <a href="{{ route('get-product-tree-details', ['id' => $product_tree->id]) }}" class="btn btn-primary btn-small">
                                        تفاصيل
                                         <i class="fa fa-file"></i>
                                    </a>
                                    <a href="{{ route('delete-product-tree', ['id' => $product_tree->id]) }}" class="btn btn-danger btn-small">
                                        حذف
                                         <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $product_trees->render("pagination::default")}}


            </div><!-- End Box-Item-Content -->
        </div><!-- End Box-Item -->
    </section><!--End Section-->

@stop

@section('scripts')

@stop
