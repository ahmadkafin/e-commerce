<?php

namespace App\Services;

class ModelService
{

    /**
     * this class for generate all model behaviour such as create, update, delete, read, and etc.
     */

    /**
     * Get Data from Database
     * @param string @modelClassName
     * @param array @relation
     * @param array @select
     * 
     * @return /Illuminate/Http/Response
     */
    public function get(string $modelClassName, array $relation, array $select)
    {
        return $modelClassName::select($select)->with($relation)->get();
    }


    /**
     * Get Single Data
     * @param string $modelClassName
     * @param array $relation
     * @param string $cond1
     * @param string $cond2
     */
    public function find(string $modelClassName, array $relation, string $cond1, string $cond2) {
        return $modelClassName::where($cond1, $cond2)->with($relation)->firstOrFail();
    }


    /**
     * Create Data
     * @param string $modelClassName
     * @param array $data
     */
    public function create(string $modelClassName, array $data) {
        return $modelClassName::create($data);
    }


    /**
     * Update data
     * @param string $modelClassName
     * @param string $cond1
     * @param string $cond2
     * @param array $data
     */
    public function update(string $modelClassName, string $cond1, string $cond2, array $data){
        return $modelClassName::where($cond1, $cond2)->update($data);
    }


    /**
     * Delete data
     * @param string $modelClassName
     * @param string $cond1
     * @param string $cond2
     */
    public function delete(string $modelClassName, string $cond1, string $cond2) {
        return $modelClassName::where($cond1, $cond2)->delete();
    }
}
