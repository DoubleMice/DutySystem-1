<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Basics
        $this->call(UsersTableSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(TimeNodeSeeder::class);
        
        // Fake Data
        $this->call(CarRecordSeeder::class);
        $this->call(CardRecordSeeder::class);
        
        // No so useful
        // $this->call(RecordSeeder::class);
        // $this->call(ActionRecordSeeder::class);
        // $this->call(DailyCheckStatusSeeder::class);
        // $this->call(HolidayDateSeeder::class);
        // $this->call(AbsenceValidRecordSeeder::class);
    }
}
