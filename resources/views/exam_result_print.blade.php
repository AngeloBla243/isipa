<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats Académiques</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --main-bg-color: #f9f9f9;
            --container-bg-color: #fff;
            --header-bg-color: #f4f4f4;
            --button-bg-color: #27ae60;
            --button-hover-bg-color: #219653;
            --red: red;
            --green: green;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: var(--main-bg-color);
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: var(--container-bg-color);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: var(--header-bg-color);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header button {
            background-color: var(--button-bg-color);
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .header button:hover {
            background-color: var(--button-hover-bg-color);
        }

        .note-rouge {
            color: var(--red);
        }

        .note-verte {
            color: var(--green);
        }

        .footer {
            margin-top: 20px;
            text-align: left;
        }

        .certification {
            margin-top: 10px;
        }

        .school-logo {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            object-fit: cover;
        }

        .title-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .title-text {
            flex-grow: 1;
            margin-left: 20px;
            text-align: center;
        }

        .summary-table {
            width: 100%;
            margin-top: 20px;
            border: 1px solid #ddd;
            border-collapse: collapse;
            overflow: auto;
            display: block;
        }

        .summary-table th, .summary-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            background-color: var(--header-bg-color);
            min-width: 100px;
        }

        @media (max-width: 768px) {
            body {
                font-size: 14px;
            }

            .school-logo {
                width: 80px;
                height: 80px;
            }

            .title-text h2, .title-text h3 {
                font-size: 1.2em;
            }

            th, td {
                padding: 8px;
            }
        }

        @media (max-width: 480px) {
            body {
                font-size: 12px;
            }

            .school-logo {
                width: 60px;
                height: 60px;
            }
        }

        @media print {
            .header {
                display: none; /* Hide the header during print */
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <header class="header">
            <button onclick="window.print()"><i class="fa-solid fa-file-pdf"></i> Imprimer</button>
        </header>

        <div class="title-section">
            <img src="{{ $getSetting->getLogo() }}" alt="Logo de l'établissement" class="school-logo">

            <div class="title-text">
                <h2>INSTITUT SUPERIEUR D'INFORMATIQUE PROGRAMMATION ET ANALYSE</h2>
                <h3>SECRÉTARIAT GÉNÉRAL ACADÉMIQUE</h3>
                <h3>SCIENCES INFORMATIQUES</h3>
                <h3>DEPT/OPTION: GENIE LOGICIEL</h3>
                <h3>{{ $getClass->class_name }}, ANNÉE ACADÉMIQUE {{ now()->year }}</h3>
            </div>
        </div>

        <p><strong>Étudiant : {{ $getStudent->name }} {{ $getStudent->last_name }}</strong></p>

        <table>
            <thead>
                <tr>
                    <th>Matières</th>
                    <th>Pondération</th>
                    <th>Note / 20</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $Grandtotals_score = 0;
                    $full_marks = 0;
                    $echecsLourd = 0;
                    $echecsLeger = 0;
                    $hasFailed = false;
                @endphp
                @foreach ($getExamMark as $exam)
                    @php
                        $total_score = $exam['total_score'] ?? 0;
                        $Grandtotals_score += $exam['totals_score'];
                        $full_marks += $exam['full_marks'] * $exam['ponde'];

                        if (is_null($total_score) || $total_score === 0) {
                            $echecsLourd++;
                            $hasFailed = true;
                        } elseif ($total_score < 8) {
                            $echecsLourd++;
                            $hasFailed = true;
                        } elseif ($total_score >= 8 && $total_score < 10) {
                            $echecsLeger++;
                        }
                    @endphp
                    <tr>
                        <td>{{ $exam['subject_name'] }}</td>
                        <td>{{ $exam['ponde'] }}</td>
                        <td class="{{ is_null($total_score) || $total_score === 0 ? 'note-rouge' : ($total_score < 10 ? 'note-rouge' : 'note-verte') }}">
                            {{ is_null($total_score) || $total_score === 0 ? 'ND' : $total_score }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="summary-table" style="overflow: auto;">
            <tr>
                <th>Total à obtenir sur 70%</th>
                <th>Total obtenu</th>
                <th>Pourcentage</th>
                <th>Échecs Lourd</th>
                <th>Échecs Léger</th>
                <th>Décision</th>
            </tr>
            <tr>
                <td>{{ $full_marks }}</td>
                <td>
                    @php
                        echo ($hasFailed || $Grandtotals_score === 0) ? 'ND' : $Grandtotals_score;
                    @endphp
                </td>
                <td>
                    @php
                        if ($hasFailed || $Grandtotals_score === 0) {
                            echo 'ND';
                        } else {
                            $pourcentage = round(($Grandtotals_score * 100) / $full_marks);
                            echo $pourcentage . '%';
                        }
                    @endphp
                </td>
                <td>{{ $echecsLourd > 0 ? $echecsLourd : '0' }}</td>
                <td>{{ $echecsLeger > 0 ? $echecsLeger : '0' }}</td>
                <td>
                    @php
                        if ($Grandtotals_score === 0 || $hasFailed) {
                            $decision = 'AA';
                        } else {
                            $pourcentage = round(($Grandtotals_score * 100) / $full_marks);
                            $decision = ($pourcentage >= 80) ? 'GD' : (($pourcentage >= 70) ? 'D' : (($pourcentage >= 50) ? 'S' : 'A'));
                        }
                    @endphp
                    {{ $decision }}
                </td>
            </tr>
        </table>

        <div class="footer">
            <p>Décision : <strong>{{ $decision }}</strong></p>
            @if ($decision == 'A')
                <p>Vous devez repasser l'examen pour améliorer vos résultats.</p>
            @elseif($decision == 'S')
                <p>Félicitations, vous avez satisfait aux critères requis.</p>
            @elseif($decision == 'D')
                <p>Bravo, vous avez obtenu une distinction pour vos résultats !</p>
            @elseif($decision == 'GD')
                <p>Félicitations, vous avez obtenu une grande distinction !</p>
            @elseif($decision == 'AA')
                <p>Vos résultats sont assimilés à un ajournement.</p>
            @else
                <p>Pas de décision disponible.</p>
            @endif
            <p class="certification">Certifié d'après les registres de délibération</p>
        </div>

    </div>

</body>

</html>
