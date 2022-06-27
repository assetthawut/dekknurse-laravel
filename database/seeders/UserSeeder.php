<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $startId = 106;
        // $normalId = 1;
        // $username = "chingchong-cryptodotcom";
        // $password = 'cryptodotcom';
        // DB::table("users")->insert([
        //     "id" => $startId, 
        //     "email" => "$username@worldnftevent.com",
        //     "name" => $username,
        //     "role_id" => $normalId,
        //     "password" => Hash::make($password),
        //     "platform_id" => 4
        // ]);

        $startId = 237; 
        for($i=1; $i<=30; $i++){
            $normalId = 1;
            $exclusiveId = 2;
            $randomName = $this->gen_uid(5); 
            // $username = "chingchong-crypto-$randomName";
            $password = $this->gen_uid(10);
            // $user = DB::table("users")->where("name",$username)->first();
            do {
                $randomName = $this->gen_uid(5); 
                $username = "chingchong-$randomName";
                $password = $this->gen_uid(10);
                // echo "user: $username \n";
                // echo "password: $password \n";
                $user = DB::table("users")->where("name",$username)->first();
            } while (!empty($user));

            $paras = 1;
            $crypto = 4;

            DB::table("users")->insert([
                "id" => $startId, 
                "email" => "$username@worldnftevent.com",
                "name" => $username,
                "role_id" => $normalId,
                "password" => Hash::make($password),
                "platform_id" => $paras
            ]);
            $startId = $startId + 1; 
            echo "user: $username \n";
            echo "password: $password \n";
        }        
    }

    function gen_uid($l=5){
        return strtolower(substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 10, $l));
     }
    //  echo gen_uid();
}
