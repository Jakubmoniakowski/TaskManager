<?php

return [
    'custom' => [
        'title' => [
            'required' => 'Pole tytuł jest wymagane',
            'string'   => 'Tytuł musi być tekstem',
            'max'      => 'Tytuł nie może być dłuższy niż 255 znaków',
        ],
        'description' => [
            'required' => 'Pole opis jest wymagane',
            'string' => 'Opis musi być tekstem',
            'max'    => 'Opis nie może być dłuższy niż 255 znaków',
        ],
        'status_task_id' => [
            'required' => 'Pole status jest wymagane',
            'exists'   => 'Wybrany status jest niepoprawny',
        ],
        'due_date' => [
            'required' => 'Pole data jest wymagane',
            'date' => 'Pole termin musi być poprawną datą',
        ],
        'observer_id' => [
            'exists' => 'Wybrany obserwator jest niepoprawny',
        ],
    ],

    'attributes' => [
        'title' => 'tytuł',
        'description' => 'opis',
        'status_task_id' => 'status',
        'due_date' => 'termin',
        'observer_id' => 'obserwator',
    ],

];

