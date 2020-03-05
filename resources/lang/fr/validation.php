<?php

return [
    'accepted'              => 'Le :attribute doit être accepté.',
    'active_url'            => 'Le :attribute n\'est pas une URL valide.',
    'after'                 => 'Le :attribute doit être une date après :date.',
    'after_or_equal'        => 'Le :attribute doit être une date postérieure ou égale à :date.',
    'alpha'                 => 'Le :attribute ne peut contenir que des lettres.',
    'alpha_dash'            => 'Le :attribute ne peut contenir que des lettres, des chiffres et des tirets.',
    'alpha_num'             => 'Le :attribute ne peut contenir que des lettres et des chiffres.',
    'array'                 => 'Le :attribute doit être un tableau.',
    'before'                => 'Le :attribute doit être une date avant :date.',
    'before_or_equal'       => 'Le :attribute doit être une date antérieure ou égale à :date.',
    'between'               => [
        'array'     => 'Le :attribute doit avoir entre :min et :max articles.',
        'file'      => 'Le :attribute doit être comprise entre :min et :max kilo-octets.',
        'numeric'   => 'Le :attribute doit être comprise entre :min et :max.',
        'string'    => 'Le :attribute doit être comprise entre :min et :max caractères.',
    ],
    'boolean'               => 'Le :attribute champ doit être vrai ou faux.',
    'confirmed'             => 'Le :attribute confirmation ne correspond pas.',
    'country'               => 'Sélectionnés :attribute n\'existe pas,ou invalide',
    'custom'                => [
        'attribute-name'    => [
            'rule-name' => 'personnalisé-message',
        ],
    ],
    'date'                  => 'Le :attribute n\'est pas une date valide.',
    'date_format'           => 'Le :attribute ne correspond pas au format :format.',
    'different'             => 'Le :attribute et :other doit être différent.',
    'digits'                => 'Le :attribute doit être :digits chiffres.',
    'digits_between'        => 'Le :attribute doit être comprise entre :min et :max chiffres.',
    'dimensions'            => 'Le :attribute est non valide les dimensions de l\'image.',
    'distinct'              => 'Le :attribute champ a une valeur en double.',
    'email'                 => 'Le :attribute doit être une adresse email valide.',
    'exists'                => 'Sélectionnés :attribute n\'est pas valide.',
    'file'                  => 'Le :attribute doit être un fichier.',
    'filled'                => 'Le :attribute champ doit avoir une valeur.',
    'image'                 => 'Le :attribute doit être une image.',
    'in'                    => 'Sélectionnés :attribute n\'est pas valide.',
    'in_array'              => 'Le :attribute champ n\'existe pas dans :other.',
    'integer'               => 'Le :attribute doit être un entier.',
    'ip'                    => 'Le :attribute doit être une adresse IP valide.',
    'ipv4'                  => 'Le :attribute doit être valide, une adresse IPv4.',
    'ipv6'                  => 'Le :attribute doit être une adresse IPv6 valide.',
    'json'                  => 'Le :attribute doit être une chaîne JSON valide.',
    'max'                   => [
        'array'     => 'Le :attribute ne peut pas avoir plus de :max articles.',
        'file'      => 'Le :attribute ne peut pas être supérieure à :max kilo-octets.',
        'numeric'   => 'Le :attribute ne peut pas être supérieure à :max.',
        'string'    => 'Le :attribute ne peut pas être supérieure à :max caractères.',
    ],
    'mimes'                 => 'Le :attribute doit être un fichier de type: :values.',
    'mimetypes'             => 'Le :attribute doit être un fichier de type: :values.',
    'min'                   => [
        'array'     => 'Le :attribute doit avoir au moins :min articles.',
        'file'      => 'Le :attribute doit être d\'au moins :min kilo-octets.',
        'numeric'   => 'Le :attribute doit être d\'au moins :min.',
        'string'    => 'Le :attribute doit être d\'au moins :min caractères.',
    ],
    'not_in'                => 'Sélectionnés :attribute n\'est pas valide.',
    'numeric'               => 'Le :attribute doit être un nombre.',
    'present'               => 'Le :attribute champ doit être présent.',
    'regex'                 => 'Le :attribute format n\'est pas valide.',
    'required'              => 'Le :attribute champ est requis.',
    'required_if'           => 'Le :attribute champ est requis lorsque :other :value.',
    'required_unless'       => 'Le :attribute champ est requis, à moins que :other dans :values.',
    'required_with'         => 'Le :attribute champ est requis lorsque :values est présent.',
    'required_with_all'     => 'Le :attribute champ est requis lorsque :values est présent.',
    'required_without'      => 'Le :attribute champ est requis lorsque :values n\'est pas présent.',
    'required_without_all'  => 'Le :attribute champ est requis lorsque aucun de :values sont présents.',
    'same'                  => 'Le :attribute et :other doivent correspondre.',
    'size'                  => [
        'array'     => 'Le :attribute doit contenir :size articles.',
        'file'      => 'Le :attribute doit être :size kilo-octets.',
        'numeric'   => 'Le :attribute doit être :size.',
        'string'    => 'Le :attribute doit être :size caractères.',
    ],
    'string'                => 'Le :attribute doit être une chaîne de caractères.',
    'timezone'              => 'Le :attribute doit être une zone valide.',
    'unique'                => 'Le :attribute a déjà été prises.',
    'uploaded'              => 'Le :attribute impossible de télécharger.',
    'url'                   => 'Le :attribute format n\'est pas valide.',
];
