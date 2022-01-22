<?php

namespace App\Imports;

use App\Models\Characters\Character;
use App\Models\Characters\CharacterClass;
use App\Models\Companies\Company;
use App\Models\DiscordData;
use App\Models\Items\BaseWeapon;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FormResponseImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    /**
     * @var \App\Models\Companies\Company 
     */
    private Company $company;

    public function __construct( string $company )
    {
        $this->company = Company::find($company);
    }

    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
//        dump('Form Response Import Class');
//        dump($rows);

        // remove duplicates, keeping newest
        // check uniqueness via in game name and discord name
        $rows = $rows->sortByDesc('timestamp')->unique(function ($item) {
            return $item['in_game_name'];
        })->filter();

        
        //  heading keys are formatted with the Laravel str_slug() helper.
        // E.g. this means all spaces are converted to _
        foreach ($rows as $row) 
        {
            if(!isset($row['in_game_name']) || str_contains($row['discord_user_name_ex_discord1234'], ' ') 
                || !str_contains($row['discord_user_name_ex_discord1234'], '#') ){
                // no name is set, or discord name is invalid, so skip
                continue;
            }    

            // find or create eloquent user
            $user = User::updateOrCreate(
                // full discord username
                [ 
                    'discord_name' => $row['discord_user_name_ex_discord1234'],
                    'slug' => Str::slug($row['in_game_name']), 
                ],
                [
                    'name' => $row['in_game_name'],
                    'slug' => Str::slug($row['in_game_name']),
                    'email' => $row['email'] ?? null, // doesn't exist yet
                    'discord_name' => $row['discord_user_name_ex_discord1234'],
                ]
            );
            
            // if existing account, it should be tied to any matching discord data
            $discord = DiscordData::where('name', $user->discord_name)->first();
            $discord?->user()?->associate($user);
            $discord?->save();
            
            $class = CharacterClass::firstWhere('name', $row['class_you_play']);
            
            // create user's character and tie to them+company
            $character = Character::updateOrCreate(
                [ 
                    'name' => $row['in_game_name'],
                    'slug' => Str::slug($row['in_game_name']),
                    'user_id' => $user->id,
                ],
                [
                    'name' => $row['in_game_name'],
                    'slug' => Str::slug($row['in_game_name']),
                    'user_id' => $user->id,
                    'company_id' => $this->company->id,
                    'character_class_id' => $class->id,
                     'level' => $row['level'] ?? null, // on the other sheet
                     'rank_id' => $row['rank'] ?? null, // on the other sheet
                ]
            );
                         
            $mainhand = BaseWeapon::firstWhere( 'name', 'like', $row['main_hand_weapon']);
            $offhand = BaseWeapon::firstWhere( 'name', 'like', $row['offhand_weapon']);
            
            /*$loadout = Loadout::updateOrCreate(
                [
                    'character_id' => $character->id,
                    'main_hand_id' => $mainhand->id,
                    'offhand_id' => $offhand->id,
                ],
                [
                    'weight' => $row['weight'] ?? 0,
                    'character_id' => $character->id,
                    'main_hand_id' => $mainhand->id,
                    'offhand_id' => $offhand->id,
                ],
            );*/
            
        }
        
    }
    
    public function headingRow(): int
    {
        return 1;
    }
}
