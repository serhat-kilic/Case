@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Employees</h4>
        </div>

        <div class="card-content ">
            <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap table-striped table-bordered">
                {{ Form::open(array('id'=>'form')) }}
                {{Form::label('name', 'Name')}}
                {{Form::text('name', '',['class'=>'form-control'])}}
                {{Form::label('surname', 'Surname')}}
                {{Form::text('surname', '',['class'=>'form-control'])}}
                {{Form::label('email', 'Email')}}
                {{Form::email('email', '',['class'=>'form-control'])}}
                {{Form::label('age', 'Age')}}
                {{Form::text('age', '',['class'=>'form-control'])}}

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
            var id=window.location.href.split('/')[5];
            if(id){
                $.ajax({
                    type: "GET",
                    url: '/api/employees/get/'+id,
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
                $('#form input, #form select').jqBootstrapValidation({
                    preventSubmit: false,
                    submitSuccess: function ($form, event) {
                        event.preventDefault();
                        $.ajax({
                            type: "PUT",
                            url: '/api/employees/edit/'+id,
                            dataType: "json",
                            data: $('#form').serialize(),
                            success: function (response) {
                                if(response.status=='success'){
                                    toastr.success(response.message);
                                }
                            },
                            error: function (jqXHR, exception) {

                            },
                        });
                    }
                });
            }else{
                $('#form input, #form select').jqBootstrapValidation({
                    preventSubmit: false,
                    submitSuccess: function ($form, event) {
                        event.preventDefault();
                        $.ajax({
                            type: "POST",
                            url: '/api/employees/create',
                            dataType: "json",
                            data: $('#form').serialize(),
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
            }


        });
    </script>
@endpush
