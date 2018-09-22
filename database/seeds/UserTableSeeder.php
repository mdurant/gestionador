<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
        //
    $user = new User();
    $user->name = 'Administrador';
    $user->email = 'admin@correo.com';
    $user->password = bcrypt('1q2w3e');
    $user->save();

    $user = new User();
    $user->name = 'Usuario';
    $user->email = 'user@correo.com';
    $user->password = bcrypt('1q2w3e');
    $user->save();


  }
}
