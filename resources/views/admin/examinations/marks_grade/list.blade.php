@extends('layouts.app')
@section('style')

<style type="text/css">
.styled-table {
    border-collapse: collapse;
    margin: 25px 0;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    border-radius: 8px;
    overflow: hidden;
}
.styled-table thead tr {
    background-color: #009879;
    color: #ffffff;
    text-align: left;
}
.styled-table th,
.styled-table td {
    padding: 12px 15px;
}
.styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}

/* Effet survol (hover) */
.styled-table tbody tr:hover {
    background-color: #f1f1f1;
    cursor: pointer;
}

</style>

@endsection
@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Marks Grade</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
              <a href="{{ url('admin/examinations/marks_grade/add') }}" class="btn btn-info"><i class="fa-solid fa-file-circle-plus"></i> Add New Marks Grade</a>
          </div>



        </div>
      </div><!-- /.container-fluid -->
    </section>




    <!-- Main content -->
    <section class="content">


      <div class="container-fluid">
        <div class="row">

          <!-- /.col -->
          <div class="col-md-12">




            @include('_message')


            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Marks Grade List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow: auto;">
                <table class="table styled-table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Grade Name</th>
                      <th>Percent From</th>
                      <th>Percent To</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                       @foreach($getRecord as $value)
                        <tr>
                          <td>{{ $value->name }}</td>
                          <td>{{ $value->percent_from }}</td>
                          <td>{{ $value->percent_to }}</td>
                          <td>{{ $value->created_name }}</td>
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          <td>
                            <a href="{{ url('admin/examinations/marks_grade/edit/'.$value->id) }}" class="btn btn-info"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <a href="{{ url('admin/examinations/marks_grade/delete/'.$value->id) }}" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>


              </div>

              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
