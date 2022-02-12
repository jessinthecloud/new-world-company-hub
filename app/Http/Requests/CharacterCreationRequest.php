<?php

namespace App\Http\Requests;

use App\Enums\WeaponType;
use App\Models\Characters\Skill;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CharacterCreationRequest extends FormRequest
{
    public function rules() : array
    {
        // get skill ids from table as comma delimited string
        $valid_skill_ids_string = Skill::select('id')->get()->pluck('id')->implode(',');
    
        $rules = [
           'name' => ['required', 'string', 'max:255'], 
           'slug' => ['nullable', 'string', 'max:255'],
//           'level' => ['required', 'numeric', 'max:60'],
           'class' => ['required', 'numeric', 'exists:character_classes,id'],
           // define the valid array keys (skill ids) 
           'skills' => ['array:'.$valid_skill_ids_string, 'nullable'],
        ];
        
        if(isset($this->skills)){
            // check each item of input array
            foreach($this->skills as $skill_id => $level){
                // set nested rules with dot notation
                $rules ['skills.'.$skill_id]= ['numeric', 'max:100000', 'nullable'];
            }
        }
       
        return $rules;
    }
}