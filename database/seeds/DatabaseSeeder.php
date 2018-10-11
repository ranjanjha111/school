<?php

use Illuminate\Database\Seeder;
use App\AdminUser;
use App\Role;
use App\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // disable fk constrain check
            // \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");

            // enable back fk constrain check
            // \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }


        // Seed the default permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms, 'guard_name' => 'admin']);
        }

        $this->command->info('Default Permissions added.');

        // Confirm roles needed
        if ($this->command->confirm('Create Roles for user, default is superadmin and admin? [y|N]', true)) {

            // Ask for roles from input
            $input_roles = $this->command->ask('Enter roles in comma separate format.', 'Superadmin, Admin');

            // Explode roles
            $roles_array = explode(',', $input_roles);

            // add roles
            foreach($roles_array as $role) {
                $role = Role::firstOrCreate(['name' => trim($role), 'guard_name' => 'admin']);

                if( $role->name == 'Superadmin' ) {
                    // assign all permissions
                    $role->syncPermissions(Permission::all());
                    $this->command->info('Admin granted all the permissions');
                } else {
                    // for others by default only read access
                    $role->syncPermissions(Permission::where('name', 'LIKE', '%_users')->get());
                }

                // create one user for each role
                $this->createUser($role);
            }

            $this->command->info('Roles ' . $input_roles . ' added successfully');

        } else {
            Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'admin']);
            $this->command->info('Added only default user role.');
        }
    }

    /**
     * Create a user with given role
     *
     * @param $role
     */
    private function createUser($role)
    {
//        if( $role->name == 'Admin' ) {
//            DB::table('users')->insert([
//                'name'      => 'Ranjan',
//                'email'     => 'ranjan@ebglobalventures.com',
//                'password'  => Hash::make('ranjan'),
//                'mobile'    =>'9136627100',
//                'isVerified'=>0
//            ]);
//        } else {
//            DB::table('users')->insert([
//                'name'      => 'Amar',
//                'email'     => 'amar@ebglobalventures.com',
//                'password'  => Hash::make('amar'),
//                'mobile'    =>'7860646053',
//                'isVerified'=>0
//            ]);
//        }



        $user = factory(AdminUser::class)->create();
        $user->assignRole($role->name);

        if( $role->name == 'Admin' ) {
            $this->command->info('Here is your admin details to login:');
            $this->command->warn($user->email);
            $this->command->warn('Password is "secret"');
        }
    }
}
