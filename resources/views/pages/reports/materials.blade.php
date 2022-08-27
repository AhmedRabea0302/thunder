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
                <h3 class="title">تقرير الخامات المستخدمة في فترة: </h3>
            </div><!-- End Box-Item-Head -->
            <div class="box-item-content">
                <form action="{{ route('print-materilas-report') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">بداية من:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" style="font-family: sans-serif" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">إلى: </label>
                                <input type="date" name="end_date" id="end_date" class="form-control" style="font-family: sans-serif" required>
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

