@extends('layouts.app')
@section('style')

<style type="text/css">
  .fc-daygrid-event {
    white-space: normal;
    word-wrap: break-word; /* Assure que le texte long soit correctement cassé */
  }

  /* Style de base pour le calendrier */
  #calendar {
    font-size: 1rem; /* Taille de police par défaut */
  }

  /* Ajustements pour les petits écrans */
  @media (max-width: 768px) {
    #calendar {
      font-size: 0.9rem; /* Réduction de la taille de police */
    }
  }

  @media (max-width: 480px) {
    #calendar {
      font-size: 0.8rem; /* Réduction supplémentaire pour les très petits écrans */
    }
  }

  /* Ajustement de la couleur du titre */
  .content-header h1 span {
    color: blue; /* Couleur du nom de l'étudiant */
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
                    <h1>My Calendar <span style="color: blue;">( {{ $getStudent->name }} {{ $getStudent->last_name }} )</span></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div id="calendar"></div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>

@endsection

@section('script')
<script src='{{ url('public/dist/fullcalendar/index.global.js') }}'></script>

<script type="text/javascript">
    var events = [];

    @foreach($getMyTimetable as $value)
        @foreach($value['week'] as $week)
            events.push({
                title: '{{ $value['name'] }}',
                daysOfWeek: [{{ $week['fullcalendar_day']}}],
                startTime: '{{ $week['start_time'] }}',
                endTime: '{{ $week['end_time'] }}',
            });
        @endforeach
    @endforeach

    @foreach($getExamTimetable as $valueE)
        @foreach($valueE['exam'] as $exam)
            events.push({
                title: '{{ $valueE['name'] }} - {{ $exam['subject_name'] }} ({{ date('h:i A',strtotime($exam['start_time'])) }} à {{ date('h:i A',strtotime($exam['end_time'])) }})',
                start: '{{ $exam['exam_date'] }}',
                end: '{{ $exam['exam_date'] }}',
                color: 'red'
            });
        @endforeach
    @endforeach

    document.addEventListener('DOMContentLoaded', function() {
        var calendarID = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarID, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            initialDate: '<?= date('Y-m-d') ?>',
            navLinks: true,
            editable: false,
            events: events,
            height: 'auto', // Adapte la hauteur automatiquement
            eventDisplay: 'block' // Affiche les événements en blocs pour une meilleure lisibilité
        });

        calendar.render();
    });
</script>
@endsection
