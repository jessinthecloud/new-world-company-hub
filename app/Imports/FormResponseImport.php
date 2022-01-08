<?php

namespace App\Imports;

use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Company;
use App\Models\DiscordData;
use App\Models\Loadout;
use App\Models\User;
use App\Models\BaseWeapon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FormResponseImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    /**
     * @var \App\Models\Company 
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

        //  heading keys are formatted with the Laravel str_slug() helper.
        // E.g. this means all spaces are converted to _
        foreach ($rows as $row) 
        {
//        dump($row);
            // find or create eloquent user
            $user = User::updateOrCreate(
                // full discord username
                [ 'discord_name' => $row['discord_user_name_ex_discord1234'], ],
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
            
            $character = Character::updateOrCreate(
                [ 
                    'name' => $row['in_game_name'],
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
            
            $loadout = Loadout::updateOrCreate(
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
            );
            
        }
        
    }
    
    public function headingRow(): int
    {
        return 1;
    }
}
