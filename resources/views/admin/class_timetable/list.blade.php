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
            <h1>Class Timetable</h1>
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
                <h3 class="card-title">Search Class Timetable</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">


                  <div class="form-group col-md-3">
                    <label>Class Name</label>
                    <select class="form-control getClass" name="class_id" required>
                        <option value="">Select</option>
                        @foreach($getClass as $class)
                          <option {{ (Request::get('class_id') == $class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>

                  </div>

                  <div class="form-group col-md-3">
                    <label>Subject Name</label>
                    <select class="form-control getSubject" name="subject_id" required>
                        <option value="">Select</option>
                        @if(!empty($getSubject))
                           @foreach($getSubject as $subject)
                            <option {{ (Request::get('subject_id') == $subject->subject_id) ? 'selected' : '' }} value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                          @endforeach
                        @endif
                    </select>
                  </div>


                  <div class="form-group col-md-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                    <a href="{{ url('admin/class_timetable/list') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>

                  </div>

                  </div>
                </div>
              </form>
            </div>


            @if(!empty(Request::get('class_id')) && !empty(Request::get('subject_id')))
            <form action="{{ url('admin/class_timetable/add') }}" method="post">
               {{ csrf_field() }}
                <input type="hidden" name="subject_id" value="{{ Request::get('subject_id') }}">
                <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Class Timetable</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow: auto;">
                <table class="table styled-table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Week</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Room Number</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $i = 1;
                    @endphp
                    @foreach($week as $value)
                      <tr>
                          <th>
                             <input type="hidden" name="timetable[{{ $i }}][week_id]" value="{{ $value['week_id'] }}">
                            {{ $value['week_name'] }}
                          </th>
                          <td>
                            <input type="time" name="timetable[{{ $i }}][start_time]" value="{{ $value['start_time'] }}" class="form-control">
                          </td>
                          <td>
                            <input type="time" name="timetable[{{ $i }}][end_time]" value="{{ $value['end_time'] }}" class="form-control">
                          </td>
                          <td>
                            <input type="text" style="width: 200px;" value="{{ $value['room_number'] }}" name="timetable[{{ $i }}][room_number]" class="form-control">
                          </td>
                      </tr>
                    @php
                    $i++;
                    @endphp
                    @endforeach
                  </tbody>
                </table>

                <div style="text-align: center; padding: 20px;">
                <button class="btn btn-primary">Submit</button>
                </div>


              </div>

              <!-- /.card-body -->
            </div>

            </form>

            @endif


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


@section('script')

<script type="text/javascript">
    $('.getClass').change(function() {
        var class_id = $(this).val();
        $.ajax({
          url: "{{ url('assign_class_teacher/get_subjects_by_class') }}",
          type: "POST",
          data:{
            "_token": "{{ csrf_token() }}",
            class_id:class_id,
           },
           dataType:"json",
           success:function(response){
              $('.getSubject').html(response.html);
           },
      });

    });
</script>

@endsection