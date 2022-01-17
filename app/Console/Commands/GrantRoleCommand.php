<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

class GrantRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:grant {user} {roleName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign a role to a user';

    public function handle()
    {
        $user = User::where( 'slug', $this->argument( 'user' ) )->first();

        if ( empty( $user->name ) ) {
            $this->error( 'User ' . $this->argument( 'user' ) . ' does not exist.' );
            $this->comment( 'Note: Remember User must be an existing user\'s slug form the users table.' );
            return;
        }

        try {
            $user->assignRole( $this->argument( 'roleName' ) );
        } catch ( RoleDoesNotExist ) {
            $this->error( 'Role ' . $this->argument( 'roleName' ) . ' does not exist.' );
            $this->comment( 'You can view all available roles with 
php artisan permission:show' );
            return;
        }

        $this->info(
            $user->name . ' was granted the role of '
            . Str::title( $this->argument( 'roleName' ) )
        );
    }
}
