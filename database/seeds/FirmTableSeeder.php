<?php

use App\Firm;
use App\FirmLogin;
use Illuminate\Database\Seeder;

class FirmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firmLogin = new Firm();
        $firmLogin->PlanId =1;
        $firmLogin->CustomCssId = null;
        $firmLogin->TimezoneId =0;
        $firmLogin->domain = 'localhost:6001';
        $firmLogin->contact_person = 'test firm 1';
        $firmLogin->display_name ='Firm 1';
        $firmLogin->email ='contact@firm1.com'; 
        $firmLogin->phone ='232323'; 
        $firmLogin->save(); 

        $firmLogin = new Firm();
        $firmLogin->PlanId =1;
        $firmLogin->CustomCssId = null;
        $firmLogin->TimezoneId =0;
        $firmLogin->domain = 'localhost:6002';
        $firmLogin->contact_person = 'test firm 2';
        $firmLogin->display_name ='Firm 2';
        $firmLogin->email ='contact@firm2.com'; 
        $firmLogin->phone ='232323'; 
        $firmLogin->save();
 
        //////////////////////////////

        $firmLogin = new FirmLogin();
        $firmLogin->FirmId =1;
        $firmLogin->first_name ='Admin';
        $firmLogin->last_name ='';
        $firmLogin->email ='admin@firm1.com';
        $firmLogin->password =bcrypt('password');
        $firmLogin->phone ='232323';
        $firmLogin->email_verified =1;
        $firmLogin->phone_verified =1; 
        $firmLogin->save();




        $firmLogin = new FirmLogin();
        $firmLogin->FirmId =2;
        $firmLogin->first_name ='Admin';
        $firmLogin->last_name ='';
        $firmLogin->email ='admin@firm2.com';
        $firmLogin->password =bcrypt('password');
        $firmLogin->phone ='232323';
        $firmLogin->email_verified =1;
        $firmLogin->phone_verified =1; 
        $firmLogin->save();
    }
}
