@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Employees</h4>
        </div>

        <div class="card-content ">
            <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap table-striped table-bordered">
                <table id="example" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Plate</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Plate</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
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

            var mytable = $('#example').DataTable({});

            function tableData() {
                $.ajax({
                    url: '/api/cars/list',
                    datatype: "json",
                    contentType: "application/json; charset=utf-8",
                    success: function (response) {
                        var data = response.data;
                        $.each(data, function (i, item) {
                            var html = '<button type="button" data-id="' + item.id + '" data-action="delete" class="btn btn-danger">Delete</button>' +
                                '<a href="/cars/edit/' + item.id + '" class="btn btn-success">Edit</a>'+
                                '<a href="/employees/give-car" class="btn btn-info">Assign car to employee</a>'

                            ;
                            mytable.rows.add([[item.brand, item.model, item.plate,  html]]);
                        })
                        mytable.draw();
                    }
                });
            }

            tableData();

            $('body').on('click','button[data-action="delete"]', function () {
                $.ajax({
                    url: '/api/cars/delete/'+$(this).data('id'),
                    type:"DELETE",
                    datatype: "json",
                    contentType: "application/json; charset=utf-8",
                    success: function (response) {
                        if(response.status=='success'){
                            toastr.success(response.message);
                            mytable.clear().draw();
                            tableData();
                        }
                    }
                });
            });

        });
    </script>
@endpush
