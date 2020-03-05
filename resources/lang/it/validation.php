<?php

return [
    'accepted'              => ':attribute deve essere accettato.',
    'active_url'            => ':attribute non è un URL valido.',
    'after'                 => ':attribute deve essere una data dopo la :date.',
    'after_or_equal'        => ':attribute deve essere una data successiva o uguale a :date.',
    'alpha'                 => ':attribute può contenere solo lettere.',
    'alpha_dash'            => ':attribute può contenere solo lettere, numeri e trattini.',
    'alpha_num'             => ':attribute può contenere solo lettere e numeri.',
    'array'                 => ':attribute deve essere un array.',
    'before'                => ':attribute deve essere una data prima di :date.',
    'before_or_equal'       => ':attribute deve essere una data precedente o uguale a :date.',
    'between'               => [
        'array'     => ':attribute deve essere compresa tra :min e :max elementi.',
        'file'      => ':attribute deve essere compresa tra :min e :max kilobyte.',
        'numeric'   => ':attribute deve essere compresa tra :min e :max.',
        'string'    => ':attribute deve essere compresa tra :min e :max caratteri.',
    ],
    'boolean'               => ':attribute il campo deve essere true o false.',
    'confirmed'             => ':attribute la conferma non corrisponde.',
    'country'               => 'Selezionato :attribute non esiste,o non valido',
    'custom'                => [
        'attribute-name'    => [
            'rule-name' => 'custom-messaggio',
        ],
    ],
    'date'                  => ':attribute non è una data valida.',
    'date_format'           => ':attribute non corrisponde al formato :format.',
    'different'             => ':attribute e :other deve essere diverso.',
    'digits'                => ':attribute deve essere :digits cifre.',
    'digits_between'        => ':attribute deve essere compresa tra :min e :max cifre.',
    'dimensions'            => ':attribute non valido per le dimensioni dell\'immagine.',
    'distinct'              => ':attribute il campo ha un valore duplicato.',
    'email'                 => ':attribute deve essere un indirizzo email valido.',
    'exists'                => 'Selezionato :attribute non è valido.',
    'file'                  => ':attribute deve essere un file.',
    'filled'                => ':attribute campo deve avere un valore.',
    'image'                 => ':attribute deve essere un immagine.',
    'in'                    => 'Selezionato :attribute non è valido.',
    'in_array'              => ':attribute campo non esiste in :other.',
    'integer'               => ':attribute deve essere un numero intero.',
    'ip'                    => ':attribute deve essere un indirizzo IP valido.',
    'ipv4'                  => ':attribute deve essere un indirizzo IPv4 valido.',
    'ipv6'                  => ':attribute deve essere un valido indirizzo IPv6.',
    'json'                  => ':attribute deve essere un valido stringa JSON.',
    'max'                   => [
        'array'     => ':attribute non può avere più di :max elementi.',
        'file'      => ':attribute non può essere maggiore di :max kilobyte.',
        'numeric'   => ':attribute non può essere maggiore di :max.',
        'string'    => ':attribute non può essere maggiore di :max caratteri.',
    ],
    'mimes'                 => ':attribute deve essere un file di tipo: :values.',
    'mimetypes'             => ':attribute deve essere un file di tipo: :values.',
    'min'                   => [
        'array'     => ':attribute deve avere almeno :min elementi.',
        'file'      => ':attribute deve essere di almeno :min kilobyte.',
        'numeric'   => ':attribute deve essere di almeno :min.',
        'string'    => ':attribute deve essere di almeno :min caratteri.',
    ],
    'not_in'                => 'Selezionato :attribute non è valido.',
    'numeric'               => ':attribute deve essere un numero.',
    'present'               => ':attribute il campo deve essere presente.',
    'regex'                 => ':attribute formato non è valido.',
    'required'              => ':attribute campo è obbligatorio.',
    'required_if'           => ':attribute campo è obbligatorio quando :other :value.',
    'required_unless'       => ':attribute il campo è obbligatorio a meno che :other :values.',
    'required_with'         => ':attribute campo è obbligatorio quando :values è presente.',
    'required_with_all'     => ':attribute campo è obbligatorio quando :values è presente.',
    'required_without'      => ':attribute campo è obbligatorio quando :values non è presente.',
    'required_without_all'  => ':attribute campo è obbligatorio se nessuno di :values sono presenti.',
    'same'                  => ':attribute e :other devono corrispondere.',
    'size'                  => [
        'array'     => ':attribute deve contenere :size elementi.',
        'file'      => ':attribute deve essere :size kilobyte.',
        'numeric'   => ':attribute deve essere :size.',
        'string'    => ':attribute deve essere :size caratteri.',
    ],
    'string'                => ':attribute deve essere una stringa.',
    'timezone'              => ':attribute deve essere una zona valida.',
    'unique'                => ':attribute è già stata presa.',
    'uploaded'              => ':attribute non è riuscito a caricare.',
    'url'                   => ':attribute formato non è valido.',
];
