<?php

use App\Domain\Account\Repositories\UserRepository;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the permissions table to database.
     *
     * @param UserRepository $repository
     * @return void
     */
    public function run(UserRepository $repository)
    {
        $userRole = Role::create(['name' => 'user']);
        $adminRole = Role::create(['name' => 'admin']);

        // create user
        $user = $repository->create([
            'name' => 'Administrador',
            'email' => 'rodrigo.pinheiroa@hotmail.com',
            'password' => bcrypt('123')
        ]);
        $user->assignRole('admin');
    }
}
