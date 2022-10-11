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
                        <th>Employee Name Surname</th>
                        <th>Employee Email</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Plate</th>
                        <th>Employee Name Surname</th>
                        <th>Employee Email</th>
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
                    url: '/api/employees/cars',
                    datatype: "json",
                    contentType: "application/json; charset=utf-8",
                    success: function (response) {
                        var data = response.data;
                        $.each(data, function (i, item) {

                            var html='<button class="btn btn-danger" data-action="delete" data-id="'+item.id+'"> Delete Car Embezzlement </button>'
                            mytable.rows.add([[item.brand, item.model, item.plate,  item.employee.name+" "+item.employee.surname,item.employee.email,html]]);
                        })
                        mytable.draw();
                    }
                });
            }

            tableData();

            $('body').on('click','button[data-action="delete"]', function () {
                $.ajax({
                    url: '/api/employees/delete-employee-car/'+$(this).data('id'),
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
