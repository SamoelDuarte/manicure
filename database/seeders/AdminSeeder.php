<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // gets all permissions via Gate::before rule; see AuthServiceProvider
        Role::create(['name' => 'admin']);

        $admin = User::create([
            'first_name' => 'samoel',
            'last_name' => 'duarte pedroza',
            'username' => 'samoel',
            'email' => 'samoelduarte@betasolucao.com.br',
            'phone' => '11986123660',
            'password' => bcrypt('528963Sam.'),
            'email_verified_at' => Carbon::now(),
        ]);

        $admin->assignRole('admin');
    }
}
