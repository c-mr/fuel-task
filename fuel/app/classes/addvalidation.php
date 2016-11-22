<?php

/**
* UNIQUEのValidation追加
*/
class AddValidation
{

    public static function _validation_unique($val, $options, $id = null)
    {
        list($table, $field) = explode('.', $options);

        // $idに値があれば$idのIDは除外
        $check_id = "";
        if(isset($id)){
            $check_id = ' id <> '.$id.' AND';
        }

        $sql = DB::query(sprintf(
                'SELECT LOWER(%s) FROM `%s`'
                .' WHERE%s %s = %s AND deleted_at IS NULL'
                , $field
                , $table
                , $check_id
                , $field
                , Str::lower($val)
            ));


        $result = $sql->execute();

        // エラーメッセージ
        Validation::active()->set_message('unique', 'The field :label must be unique, but :value has already been used');

        return !($result->count() > 0);
    }

}