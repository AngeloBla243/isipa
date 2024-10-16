<?php

namespace App\Http\Controllers;

use App\Models\ExamScheduleModel;

use App\Models\AssignClassTeacherModel; // Modèle pour les classes assignées
use Illuminate\Support\Facades\Auth; //

use Illuminate\Http\Request;
use App\Models\recours;

class RecoursController extends Controller
{
    public function list()
    {
        // Récupérer tous les recours avec les étudiants, classes et matières associés
        $recours = Recours::getAllRecours();
        // dd($recours);

        foreach ($recours as $recour) {
            $examId = ExamScheduleModel::getExamIdBySubject($recour->subject_id, $recour->class_id);
            // verifier toujours
            $recour->exam_id = $examId; // Ajoutez l'ID d'examen au recours
            //
        }

        // Passer les données à la vue
        return view('admin.recours.list', compact('recours'));
    }


    public function listForTeacher()
    {
        // Récupérer l'ID de l'enseignant connecté
        $teacherId = Auth::id();

        // Récupérer les classes assignées à cet enseignant
        $assignedClasses = AssignClassTeacherModel::where('teacher_id', $teacherId)
            ->pluck('class_id')
            ->toArray();

        // Récupérer les recours pour les classes assignées
        $recours = Recours::whereIn('class_id', $assignedClasses)
            ->with(['student', 'class', 'subject']) // Charger les relations
            ->get();

        foreach ($recours as $recour) {
            $examId = ExamScheduleModel::getExamIdBySubject($recour->subject_id, $recour->class_id);
            $recour->exam_id = $examId; // Ajoutez l'ID d'examen au recours
        }


        // Passer les données à la vue
        return view('teacher.recours.list', compact('recours'));
    }
}
