<?php

namespace App\Enums;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EnumGeneral
{
    public static function getEnumValues($table, $column) {
        try{
            $type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type ;
            preg_match('/^enum\((.*)\)$/', $type, $matches);
            $enum = array();
            foreach( explode(',', $matches[1]) as $value )
            {
                $v = trim( $value, "'" );
                $enum = Arr::add($enum, $v, $v);
            }
            return $enum;
        }catch(\Illuminate\Database\QueryException $ex){
        dd($ex->getMessage());
            // Note any method of class PDOException can be called on $ex.
        }

    }
}
