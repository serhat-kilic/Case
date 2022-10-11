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
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Sex</th>
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
            var columns = [
                {"data": "name", "title": "Name"},
                {"data": "surname"},
                {"data": "email"},
                {"data": "age"},
                {"data": "sex"},
            ];

            var mytable = $('#example').DataTable({});

            function tableData() {
                $.ajax({
                    url: 'api/employees/list',
                    datatype: "json",
                    contentType: "application/json; charset=utf-8",
                    success: function (response) {
                        var data = response.data;
                        $.each(data, function (i, item) {
                            var html = '<button type="button" data-id="' + item.id + '" data-action="delete" class="btn btn-danger">Delete</button>' +
                                '<a href="/employees/edit/' + item.id + '" class="btn btn-success">Edit</a>';
                            mytable.rows.add([[item.name, item.surname, item.email, item.age, item.sex, html]]);
                        })
                        mytable.draw();
                    }
                });
            }

            tableData();

            $('body').on('click','button[data-action="delete"]', function () {
                $.ajax({
                    url: 'api/employees/delete/'+$(this).data('id'),
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
