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
                <h3 class="title">مسارات الإنتاج</h3>
                <a href="{{ route('get-add-path') }}" class="pull-right btn btn-info add-product" style="background: #f89842; border: none">
                    إضافة مسار <i class="fa fa-plus"></i>
                </a>
            </div><!-- End Box-Item-Head -->
            <div class="box-item-content">

                <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>كود المسار</th>
                        <th>كود  المُنتج</th>
                        <th>القسم</th>
                        <th>الكمية</th>
                        <th>تكلفة القطعة</th>
                        <th>مصروفات</th>
                        <th>
                            خيارات
                        </th>
                    </thead>

                    <tbody>
                        @foreach ($paths as $index => $path)
                            <tr>
                                <td style="font-family: sans-serif">{{$index + 1}}</td>
                                <td style="font-family: sans-serif">{{ $path->path_code }}</td>
                                <td style="font-family: sans-serif">{{ $path->getPathMainProduct->product_code }}</td>
                                <td>{{ $path->getPathSector->name }}</td>
                                <td style="font-family: sans-serif">{{ $path->path_quantity }}</td>
                                <td style="font-family: sans-serif">{{ $path->piece_total_budget }}</td>
                                <td style="font-family: sans-serif">{{ $path->getPathExpenses->sum('expense_value') }}</td>
                                <td>
                                    <a href="{{ route('get-path-details', ['id' => $path->id]) }}" class="btn btn-primary btn-small">
                                        تفاصيل
                                         <i class="fa fa-file"></i>
                                    </a>
                                    <a disabled href="{{ route('delete-product-tree', ['id' => $path->id]) }}" class="btn btn-danger btn-small">
                                        حذف
                                         <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $paths->render("pagination::default")}}


            </div><!-- End Box-Item-Content -->
        </div><!-- End Box-Item -->
    </section><!--End Section-->

@stop

@section('scripts')

@stop
