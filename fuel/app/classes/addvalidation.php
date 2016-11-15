<?php

/**
* UNIQUEのValidation追加
*/
class AddValidation
{

    public static function _validation_unique($val, $options)
    {
        list($table, $field) = explode('.', $options);

        $result = DB::select(DB::expr("LOWER (\"$field\")"))
                ->where($field, '=', Str::lower($val))
                ->from($table)->execute();

        // エラーメッセージ
        Validation::active()->set_message('unique', 'The field :label must be unique, but :value has already been used');

        return ! ($result->count() > 0);
    }

}