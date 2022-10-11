@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Cars</h4>
        </div>

        <div class="card-content ">
            <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap table-striped table-bordered">
                {{ Form::open(array('id'=>'form')) }}
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            {{Form::text('id', '',['class'=>'form-control','hidden'=>'hidden'])}}
                            <div class="col-md-4">
                                {{Form::label('brand', 'Brand')}}
                                {{Form::text('brand', '',['class'=>'form-control','disabled'=>'disabled'])}}
                            </div>
                            <div class="col-md-4">
                                {{Form::label('model', 'Model')}}
                                {{Form::text('model', '',['class'=>'form-control','disabled'=>'disabled'])}}
                            </div>
                            <div class="col-md-4">
                                {{Form::label('plate', 'Plate')}}
                                {{Form::text('plate', '',['class'=>'form-control','disabled'=>'disabled'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        {{Form::label('employee', 'Employee')}}<br>
                        <select name="employee_id" class="js-data-example-ajax" style="width: 100%;"></select>
                    </div>

                </div>


                <button type="submit" class="btn btn-success mt-1">{{__('Save')}}</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@endpush

@push('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>

        $(document).ready(function () {
            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '/api/employees/search',
                    dataType: 'json',
                    processResults: function (response) {
                        var arr=[];
                        $.each(response.data,function (i,item){
                           var ar={id:item.id,text:(item.name+" "+item.surname)};
                           arr.push(ar);
                        });
                        return {
                            results: arr
                        };
                    },
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                }
            });
            var id=window.location.href.split('/')[5];
            if(id){
                $.ajax({
                    type: "GET",
                    url: '/api/cars/get/'+id,
                    dataType: "json",
                    success: function (response) {
                        if(response.status=='success'){
                            $.each(response.data, function(i, item) {
                                $('input[name="'+i+'"]').val(item);
                            });

                        }
                    },
                    error: function (jqXHR, exception) {

                    },
                });
            }

            $('#form input, #form select').jqBootstrapValidation({
                preventSubmit: false,
                submitSuccess: function ($form, event) {
                    event.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: '/api/employees/give-car',
                        dataType: "json",
                        data:{"car_id":$('input[name="id"]').val(),"employee_id":$('.js-data-example-ajax').select2('val')},
                        success: function (response) {
                            if(response.status=='success'){
                                toastr.success(response.message);
                                $('#form')[0].reset();
                            }
                        },
                        error: function (jqXHR, exception) {
                            if(jqXHR.status==422){
                                $.each(jqXHR.responseJSON.errors,function (i,item){
                                    toastr.error(item);
                                });

                            }
                        },
                    });
                }
            });


        });
    </script>
@endpush
