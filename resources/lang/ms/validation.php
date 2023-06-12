<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute mesti diterima',
    'accepted_if' => ':attribute mesti diterima apabila :other ialah :value',
    'active_url' => ':attribute bukan URL yang sah',
    'after' => ':attribute mestilah tarikh selepas :date',
    'after_or_equal' => ':attribute mestilah tarikh selepas atau sama dengan :date',
    'alpha' => ':attribute hanya boleh mengandungi huruf',
    'alpha_dash' => ':attribute hanya boleh mengandungi huruf, nombor, sempang dan garis bawah',
    'alpha_num' => ':attribute hanya boleh mengandungi huruf dan nombor',
    'array' => ':attribute mestilah tatasusun (array)',
    'before' => ':attribute mestilah tarikh sebelum :date',
    'before_or_equal' => ':attribute mestilah tarikh sebelum atau sama dengan :date',
    'between' => [
        'array' => ':attribute mesti mempunyai item antara :min dan :max',
        'file' => ':attribute mestilah antara :min dan :max kilobait',
        'numeric' => ':attribute mestilah antara :min dan :max',
        'string' => ':attribute mestilah antara :min dan :max aksara',
    ],
    'boolean' => 'Ruangan :attribute mestilah benar atau salah',
    'confirmed' => 'Pengesahan :attribute tidak sepadan',
    'current_password' => 'Kata laluan salah',
    'date' => ':attribute bukan tarikh yang sah',
    'date_equals' => ':attribute mestilah tarikh bersamaan dengan :date',
    'date_format' => ':attribute tidak sepadan dengan format :format',
    'declined' => ':attribute mesti ditolak',
    'declined_if' => ':attribute mesti ditolak apabila :other ialah :value',
    'different' => ':attribute dan :other mestilah berbeza',
    'digits' => ':attribute mestilah :digits digit',
    'digits_between' => ':attribute mestilah antara :min dan :max digit',
    'dimensions' => ':attribute mempunyai dimensi imej yang tidak sah',
    'distinct' => 'Ruangan :attribute mempunyai nilai pendua (duplicate)',
    'doesnt_end_with' => ':attribute tidak boleh berakhir dengan salah satu daripada yang berikut: :values',
    'doesnt_start_with' => ':attribute tidak boleh bermula dengan salah satu daripada yang berikut: :values',
    'email' => ':attribute mestilah alamat e-mel yang sah',
    'ends_with' => ':attribute mesti berakhir dengan salah satu daripada yang berikut: :values',
    'enum' => ':attribute yang dipilih tidak sah',
    'exists' => ':attribute yang dipilih tidak sah',
    'file' => ':attribute mestilah fail',
    'filled' => 'Ruangan :attribute mesti mempunyai nilai',
    'gt' => [
        'array' => ':attribute mesti mempunyai lebih daripada :value item',
        'file' => ':attribute mestilah lebih besar daripada :value kilobait',
        'numeric' => ':attribute mestilah lebih besar daripada :value',
        'string' => ':attribute mestilah lebih besar daripada :value aksara',
    ],
    'gte' => [
        'array' => ':attribute mesti mempunyai :value item atau lebih',
        'file' => ':attribute mestilah lebih besar atau sama dengan :value kilobait',
        'numeric' => ':attribute mestilah lebih besar atau sama dengan :value',
        'string' => ':attribute mestilah lebih besar atau sama dengan :value aksara',
    ],
    'image' => ':attribute mestilah imej',
    'in' => ':attribute yang dipilih tidak sah',
    'in_array' => 'Ruangan :attribute tidak wujud dalam :other',
    'integer' => ':attribute mestilah nombor bulat (integer)',
    'ip' => ':attribute mestilah alamat IP yang sah',
    'ipv4' => ':attribute mestilah alamat IPv4 yang sah',
    'ipv6' => ':attribute mestilah alamat IPv6 yang sah',
    'json' => ':attribute mestilah rentetan JSON yang sah',
    'lt' => [
        'array' => ':attribute mesti mempunyai kurang daripada :value item',
        'file' => ':attribute mestilah kurang daripada :value kilobait',
        'numeric' => ':attribute mestilah kurang daripada :value',
        'string' => ':attribute mestilah kurang daripada :value aksara',
    ],
    'lte' => [
        'array' => ':attribute mestilah tidak mempunyai lebih daripada :value item',
        'file' => ':attribute mestilah kurang atau sama dengan :value kilobait',
        'numeric' => ':attribute mestilah kurang atau sama dengan :value',
        'string' => ':attribute mestilah kurang atau sama dengan :value aksara',
    ],
    'mac_address' => ':attribute mestilah alamat MAC yang sah',
    'max' => [
        'array' => ':attribute mestilah tidak mempunyai lebih daripada :max item',
        'file' => ':attribute mestilah tidak lebih besar daripada :max kilobait',
        'numeric' => ':attribute mestilah tidak lebih besar daripada :max',
        'string' => ':attribute mestilah tidak lebih besar daripada :max aksara',
    ],
    'mimes' => ':attribute mestilah fail jenis: :values',
    'mimetypes' => ':attribute mestilah fail jenis: :values',
    'min' => [
        'array' => ':attribute mesti mempunyai sekurang-kurangnya :min item',
        'file' => ':attribute mestilah sekurang-kurangnya :min kilobait',
        'numeric' => ':attribute mestilah sekurang-kurangnya :min',
        'string' => ':attribute mestilah sekurang-kurangnya :min aksara',
    ],
    'multiple_of' => ':attribute mestilah gandaan :value',
    'not_in' => ':attribute yang dipilih tidak sah',
    'not_regex' => 'Format :attribute tidak sah',
    'numeric' => ':attribute mestilah nombor',
    'password' => [
        'letters' => ':attribute mesti mengandungi sekurang-kurangnya satu huruf',
        'mixed' => ':attribute mesti mengandungi sekurang-kurangnya satu huruf besar dan satu huruf kecil',
        'numbers' => ':attribute mesti mengandungi sekurang-kurangnya satu nombor',
        'symbols' => ':attribute mesti mengandungi sekurang-kurangnya satu simbol',
        'uncompromised' => ':attribute diberikan telah muncul dalam kebocoran data. Sila pilih :attribute yang berbeza',
    ],
    'present' => 'Ruangan :attribute mesti wujud',
    'prohibited' => 'Ruangan :attribute adalah dilarang',
    'prohibited_if' => 'Ruangan :attribute adalah dilarang apabila :other ialah :value',
    'prohibited_unless' => 'Ruangan :attribute adalah dilarang melainkan :other terdapat dalam :values',
    'prohibits' => 'Ruangan :attribute melarang :other daripada wujud',
    'regex' => 'Format :attribute tidak sah',
    'required' => 'Ruangan :attribute diperlukan',
    'required_array_keys' => 'Ruangan :attribute mesti mengandungi entri untuk: :values',
    'required_if' => 'Ruangan :attribute diperlukan apabila :other ialah :value',
    'required_unless' => 'Ruangan :attribute diperlukan melainkan :other terdapat dalam :values',
    'required_with' => 'Ruangan :attribute diperlukan apabila :values wujud',
    'required_with_all' => 'Ruangan :attribute diperlukan apabila kesemua :values wujud',
    'required_without' => 'Ruangan :attribute diperlukan apabila :values tidak wujud',
    'required_without_all' => 'Ruangan :attribute diperlukan apabila tiada :values yang wujud',
    'same' => ':attribute dan :other mesti sepadan',
    'size' => [
        'array' => ':attribute mesti mengandungi :size item',
        'file' => ':attribute mestilah :size kilobait',
        'numeric' => ':attribute mestilah :size',
        'string' => ':attribute mestilah :size aksara',
    ],
    'starts_with' => ':attribute mesti bermula dengan salah satu daripada berikut: :values',
    'string' => ':attribute mestilah rentetan (string)',
    'timezone' => ':attribute mestilah zon waktu yang sah',
    'unique' => ':attribute telah pun diguna pakai',
    'uploaded' => ':attribute gagal dimuat naik',
    'url' => ':attribute mestilah URL yang sah',
    'uuid' => ':attribute mestilah UUID yang sah',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
