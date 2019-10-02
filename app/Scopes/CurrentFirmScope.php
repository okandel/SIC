<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; 

class CurrentFirmScope  implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $firm= \CurrentFirm::get();
        //get relation path of in-direct related model to Firm
        $currentFirmRelationPath = $model->currentFirmRelationPath;
       
        if ((!isset($currentFirmRelationPath) || trim($currentFirmRelationPath) === ''))
        { 
            $builder->where('FirmId',  $firm->id);  
        }else
        { 
            $builder->whereHas($currentFirmRelationPath, function (Builder $query) use ($firm) {
                $query->where('FirmId',  $firm->id);
            });
        }
    }
}
      