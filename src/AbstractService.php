<?php

namespace AstroDaniel\Bosque;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Fluent;

abstract class AbstractService{

    public function __construct(private Model $record){}

    /**
     * update record
     * @return self
     */
    public function update(array $data):self{
        $this->record->update($data);
        return $this;
    }
    
    /**
     * delete record from database
     * @return bool|null
     */
    public function delete():bool|null{
        return $this->record->delete();
    }

    /**
     * force delete a record from database
     * @return bool|null
     */
    public function forceDelete() : bool|null {
        return $this->record->forceDelete();
    }

    /**
     * get record
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getRecord(): Model{
        return $this->record;
    }

    /**
     * get a fluent with data of record
     * @return \Illuminate\Support\Fluent
     */
    public function getRecordData(): Fluent{
        return new Fluent($this->record->toArray());
    }
}
