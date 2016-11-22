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
        if(isset($id)){
            $sql = DB::query(
                'SELECT LOWER('.$field.') FROM '.$table
                .' WHERE '.$field.' = :val AND'
                .' id <> :id'
                .' AND deleted_at IS NULL'
            );
            $sql->bind('id', $id);
        }else{
            $sql = DB::query(
                'SELECT LOWER('.$field.') FROM '.$table
                .' WHERE '.$field.' = :val'
                .' AND deleted_at IS NULL'
            );
        }

        $sql->bind('table', $table);
        $sql->bind('check_id', $check_id);
        $val = Str::lower($val);
        $sql->bind('val', $val);


        $result = $sql->execute();

        // エラーメッセージ
        Validation::active()->set_message('unique', 'The field :label must be unique, but :value has already been used');

        return !($result->count() > 0);
    }

}