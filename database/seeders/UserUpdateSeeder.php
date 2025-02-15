<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->get();
        $totalUsers = $users->count();
    
        // Define the distribution of users for each month (total should be <= $totalUsers)
        $userDistribution = [
            'January' => 80,
            'February' => 120,
            'March' => 60,
            'April' => 100,
            'May' => 50,
            'June' => 90,
            'July' => 70,
            'August' => 110,
            'September' => 150,
            'October' => 80,
            'November' => 100,
            'December' => 0,  // Adjust according to your needs
        ];
    
        $startDate = Carbon::create(2020, 1, 1); // Starting from January 2020
        $currentMonthIndex = 0;
        $currentMonthName = '';
    
        foreach ($users as $key => $user) {
            // Find which month we are currently updating
            foreach ($userDistribution as $month => $userCount) {
                if ($currentMonthIndex < count($userDistribution) && $key < array_sum(array_slice($userDistribution, 0, $currentMonthIndex + 1))) {
                    $currentMonthName = $month;
                    break;
                }
                $currentMonthIndex++;
            }
    
            // Calculate new created_at date
            $newDate = $startDate->copy()->addMonths($currentMonthIndex); // Add month based on index
    
            // Update the user with the new created_at date
            DB::table('users')
                ->where('id', $user->id)
                ->update(['created_at' => $newDate]);
    
            // Output progress (optional)
            echo "User ID {$user->id} updated with created_at: {$newDate} for month: {$currentMonthName}\n";
        }
    
        echo "Users updated successfully.";

    }
}
