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
            <h1>My Student List</h1>
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

            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Student List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow: auto;">
                <table class="table styled-table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th style="min-width: 150px;">Profile Pic</th>
                      <th style="min-width: 150px;">Student Name</th>
                      <th>Email</th>
                      <th style="min-width: 200px;">Admission Number</th>
                      <th style="min-width: 150px;">Roll Number</th>
                      <th>Class</th>
                      <th>Gender</th>
                      <th style="min-width: 150px;">Date of Birth </th>
                      <th>Caste </th>
                      <th>Religion</th>
                      <th style="min-width: 150px;">Mobile Number</th>
                      <th style="min-width: 150px;">Admission Date</th>
                      <th style="min-width: 150px;">Blood Group</th>
                      <th>Height</th>
                      <th>Weight</th>
                      <th style="min-width: 150px;">Created Date</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($getRecord as $value)
                        <tr>
                            <td style="min-width: 150px;">{{ ($getRecord->currentPage() - 1) * $getRecord->perPage() + $loop->iteration }}</td>
                          <td style="min-width: 150px;">
                            @if(!empty($value->getProfile()))
                            <img src="{{ $value->getProfile() }}" style="height: 50px; width:50px; border-radius: 50px;">
                            @endif
                          </td>

                          <td style="min-width: 150px;">{{ $value->name }} {{ $value->last_name }}</td>
                          <td style="min-width: 150px;">{{ $value->email }}</td>
                          <td style="min-width: 150px;">{{ $value->admission_number }}</td>
                          <td style="min-width: 150px;">{{ $value->roll_number }}</td>
                          <td style="min-width: 150px;">{{ $value->class_name }}</td>
                          <td style="min-width: 150px;">{{ $value->gender }}</td>
                          <td style="min-width: 150px;">
                              @if(!empty($value->date_of_birth))
                                {{ date('d-m-Y', strtotime($value->date_of_birth)) }}
                              @endif
                          </td>
                          <td style="min-width: 150px;">{{ $value->caste }}</td>
                          <td style="min-width: 150px;">{{ $value->religion }}</td>
                          <td style="min-width: 150px;">{{ $value->mobile_number }}</td>
                          <td style="min-width: 150px;">
                            @if(!empty($value->admission_date))
                              {{ date('d-m-Y', strtotime($value->admission_date)) }}
                              @endif
                          </td>
                          <td style="min-width: 150px;">{{ $value->blood_group }}</td>
                          <td style="min-width: 150px;">{{ $value->height }}</td>
                          <td style="min-width: 150px;">{{ $value->weight }}</td>
                          <td style="min-width: 150px;">{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>

                        </tr>
                      @endforeach
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;">
                    {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                </div>

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
