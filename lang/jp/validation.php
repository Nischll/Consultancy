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
 
    'accepted' => ':attribute を承認する必要があります',
    'accepted_if' => ':other が :value の場合 :attribute を承認する必要があります',
    'active_url' => ':attribute は有効なＵＲＬではありません',
    'after' => ':attribute は :date より後の日付でなければなりません',
    'after_or_equal' => ':attribute は :date 以降の日付である必要があります',
    'alpha' => ':attribute には文字のみを入力してください',
    'alpha_dash' => ':attribute は文字 数字 ダッシュ _ を入力してください',
    'alpha_num' => ':attribute は文字 数字を入力してください',
    'array' => ':attribute は配列を入力してください',
    'ascii' => ':attribute は半角数字、半角文字を入力してください',
    'before' => ':attribute は :date より前の日付である必要があります',
    'before_or_equal' => ':attribute は :date 以前の日付である必要があります',
    'between' => [
        'array' => ':attribute は :min から :max までの項目が必要です',
        'file' => ':attribute は :min から :max キロバイトまでの範囲にする必要があります',
        'numeric' => ':attribute は :min と :max の間になければなりません',
        'string' => ':attribute は :min 文字から :max 文字までの範囲でなければなりません',
    ],
    'boolean' => ':attribute は真偽値でなければなりません',
    'confirmed' => ':attribute が一致しません',
    'current_password' => 'パスワードが間違っています',
    'date' => ':attribute は有効な日付ではありません',
    'date_equals' => ':attribute は :date と同じ日付である必要があります',
    'date_format' => ':attribute が形式 :format と一致しません',
    'decimal' => ':attribute は小数点以下 :decimal 桁が必要です',
    'declined' => ':attribute は拒否されなければなりません',
    'declined_if' => ':other が :value の場合 :attribute は拒否されなければなりません',
    'different' => ':attribute と :other は異なる必要があります',
    'digits' => ':attribute は :digits 桁必要です',
    'digits_between' => ':attribute は :min 桁から :max 桁までの範囲でなければなりません',
    'dimensions' => ':attribute の画像サイズが不正です',
    'distinct' => ':attribute に重複した値があります',
    'doesnt_end_with' => ':attribute は次の何れかで終わることはできません: :values',
    'doesnt_start_with' => ':attribute は次のいずれかで始まることはできません: :values',
    'email' => ':attribute は有効なメールアドレスではありません',
    'ends_with' => ':attribute は、次の何れかで終わる必要があります: :values',
    'enum' => '選択した :attribute は無効です',
    'exists' => '選択した :attribute は無効です',
    'file' => ':attribute はファイルである必要があります',
    'filled' => ':attribute 欄は必須です',
    'gt' => [
        'array' => ':attribute には :value 項目以上が必要です',
        'file' => ':attribute は :value キロバイトより大きくなければなりません',
        'numeric' => ':attribute は :value より大きくなければなりません',
        'string' => ':attribute は :value 文字以上でなければなりません',
    ],
    'gte' => [
        'array' => ':attribute には :value 項目以上が必要です',
        'file' => ':attribute は :value キロバイト以上である必要があります',
        'numeric' => ':attribute は :value 以上である必要があります',
        'string' => ':attribute は :value 文字以上である必要があります',
    ],
    'image' => ':attribute は画像である必要があります',
    'in' => '選択された :attribute は無効です',
    'in_array' => ':attribute は :other に存在しません',
    'integer' => ':attribute は整数である必要があります',
    'ip' => ':attribute は有効なIPアドレスである必要があります',
    'ipv4' => ':attribute は有効なIPv4アドレスである必要があります',
    'ipv6' => ':attribute は有効なIPv6アドレスである必要があります',
    'json' => ':attribute は有効なJSONである必要があります',
    'lowercase' => ':attribute は小文字でなければなりません',
    'lt' => [
        'array' => ':attribute は :value 項目より少ない項目が必要です',
        'file' => ':attribute は :value キロバイト未満である必要があります',
        'numeric' => ':attribute は :value より小さくなければなりません。',
        'string' => ':attribute は :value 文字未満である必要があります',
    ],
    'lte' => [
        'array' => ':attribute は :value 項目以上を含めることはできません',
        'file' => ':attribute は :value キロバイト以下である必要があります',
        'numeric' => ':attribute は :value 以下である必要があります',
        'string' => ':attribute は :value 文字以下である必要があります',
    ],
    'mac_address' => ':attribute は有効な MACアドレスである必要があります',
    'max' => [
        'array' => ':attribute は :max を超える項目を含めることはできません',
        'file' => ':attribute は :max キロバイトを超えてはなりません',
        'numeric' => ':attribute は :max より大きくてはいけません',
        'string' => ':attribute は :max 文字を超えてはなりません',
    ],
    'max_digits' => ':attribute は :max 桁を超えてはなりません。',
    'mimes' => ':attribute は、タイプ: :values のファイルである必要があります',
    'mimetypes' => ':attribute は、タイプ: :values のファイルである必要があります',
    'min' => [
        'array' => ':attribute は少なくとも :min 個の項目が必要です',
        'file' => ':attribute は少なくとも :min キロバイトである必要があります',
        'numeric' => ':attribute は少なくとも :min である必要があります',
        'string' => ':attribute は少なくとも :min 文字である必要があります',
    ],
    'min_digits' => ':attribute には少なくとも :min 桁が必要です',
    'missing' => ':attribute は存在してはいけません',
    'missing_if' => ':other が :value のとき、:attribute は存在していてはいけません',
    'missing_unless' => ':other が :value でないかぎり、:attribute は存在していてはいけません',
    'missing_with' => ':values が存在する場合、:attribute は存在していてはいけません。',
    'missing_with_all' => ':values が存在している場合、:attribute は存在していてはいけません',
    'multiple_of' => ':attribute は :value の倍数でなければなりません',
    'not_in' => '選択された :attribute は無効です',
    'not_regex' => ':attribute の形式が無効です',
    'numeric' => ':attribute は数値でなければなりません',
    'password' => [
        'letters' => ':attribute には少なくとも １文字の英字を含める必要があります',
        'mixed' => ':attribute には少なくとも1文字の大文字と1文字の小文字を含める必要があります',
        'numbers' => ':attribute には少なくとも1つの数字を含める必要があります',
        'symbols' => ':attribute には少なくとも1つの記号を含める必要があります',
        'uncompromised' => '指定された :attribute は過去のデータ漏えいに含まれていました。別の :attribute を選択してください',
    ],
    'present' => ':attribute は必須です',
    'prohibited' => ':attribute の入力は許可されていません',
    'prohibited_if' => ':other が :value の場合、:attribute の入力は許可されていません',
    'prohibited_unless' => ':other が :values のいずれかでない限り、:attribute の入力は許可されていません',
    'prohibits' => ':attribute が入力されている場合は、:other は入力してはいけません',
    'regex' => ':attribute の形式が無効です',
    'required' => ':attribute は必須です',
    'required_array_keys' => ':attribute は、次の項目（:values）に対応する入力が含まれている必要があります',
    'required_if' => ':other が :value の場合、:attribute は必須です',
    'required_if_accepted' => ':other が承認されている場合、:attribute は必須です',
    'required_unless' => ':other が :values のいずれかに含まれていないかぎり、:attribute は必須です',
    'required_with' => ':values が存在する場合、:attribute は必須です',
    'required_with_all' => ':values が存在している場合、:attribute は必須です',
    'required_without' => ':values が存在しない場合、:attribute は必須です',
    'required_without_all' => ':values のいずれも存在しない場合、:attribute は必須です',
    'same' => ':attribute と :other は一致していなければなりません',
    'size' => [
        'array' => ':attribute には :size 個の項目を含める必要があります',
        'file' => ':attribute は :size キロバイトでなければなりません',
        'numeric' => ':attribute は :size でなければなりません',
        'string' => ':attribute は :size 文字でなければなりません',
    ],
    'starts_with' => ':attribute は次のいずれかで始まっていなければなりません: :values',
    'string' => ':attribute は文字列でなければなりません',
    'timezone' => ':attribute は有効なタイムゾーンでなければなりません',
    'unique' => ':attribute はすでに使用されています',
    'uploaded' => ':attribute のアップロードに失敗しました',
    'uppercase' => ':attribute は大文字でなければなりません',
    'url' => ':attribute は有効なURLでなければなりません',
    'ulid' => ':attribute は有効な ULID でなければなりません',
    'uuid' => ':attribute は有効な UUID でなければなりません',
 
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
