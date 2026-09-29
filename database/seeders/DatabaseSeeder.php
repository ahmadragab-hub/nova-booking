<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Service;
use App\Models\StaffDayOff;
use App\Models\StaffProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NovaSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        $admin = User::create([
            'name' => 'NOVA Admin',
            'email' => 'admin@nova.test',
            'password' => Hash::make('Password123!'),
            'role' => 'admin',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Staff
        |--------------------------------------------------------------------------
        */

        $sarahUser = User::create([
            'name' => 'Sarah Ahmed',
            'email' => 'sarah@nova.test',
            'password' => Hash::make('Password123!'),
            'role' => 'staff',
        ]);

        $sarah = StaffProfile::create([
            'user_id' => $sarahUser->id,
            'phone' => '55510001',
            'job_title' => 'Senior Beautician',
            'active' => true,
        ]);

        $linaUser = User::create([
            'name' => 'Lina Mohamed',
            'email' => 'lina@nova.test',
            'password' => Hash::make('Password123!'),
            'role' => 'staff',
        ]);

        $lina = StaffProfile::create([
            'user_id' => $linaUser->id,
            'phone' => '55510002',
            'job_title' => 'Hair Specialist',
            'active' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $hair = Category::create([
            'name' => 'Hair',
            'description' => 'Hair styling and treatment services.',
            'active' => true,
        ]);

        $beauty = Category::create([
            'name' => 'Beauty',
            'description' => 'Beauty and skincare services.',
            'active' => true,
        ]);

        $nails = Category::create([
            'name' => 'Nails',
            'description' => 'Manicure and nail care services.',
            'active' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        */

        $haircut = Service::create([
            'category_id' => $hair->id,
            'name' => 'Haircut & Styling',
            'description' => 'Professional haircut and styling.',
            'duration_minutes' => 60,
            'price' => 15.00,
            'active' => true,
        ]);

        $hairColor = Service::create([
            'category_id' => $hair->id,
            'name' => 'Hair Coloring',
            'description' => 'Professional hair coloring service.',
            'duration_minutes' => 120,
            'price' => 35.00,
            'active' => true,
        ]);

        $facial = Service::create([
            'category_id' => $beauty->id,
            'name' => 'Facial Treatment',
            'description' => 'Relaxing facial treatment.',
            'duration_minutes' => 60,
            'price' => 20.00,
            'active' => true,
        ]);

        $makeup = Service::create([
            'category_id' => $beauty->id,
            'name' => 'Makeup',
            'description' => 'Professional makeup service.',
            'duration_minutes' => 60,
            'price' => 25.00,
            'active' => true,
        ]);

        $manicure = Service::create([
            'category_id' => $nails->id,
            'name' => 'Manicure',
            'description' => 'Classic manicure service.',
            'duration_minutes' => 45,
            'price' => 10.00,
            'active' => true,
        ]);

        $pedicure = Service::create([
            'category_id' => $nails->id,
            'name' => 'Pedicure',
            'description' => 'Classic pedicure service.',
            'duration_minutes' => 60,
            'price' => 12.00,
            'active' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Staff ↔ Services
        |--------------------------------------------------------------------------
        */

        $sarah->services()->sync([
            $haircut->id,
            $hairColor->id,
            $facial->id,
            $makeup->id,
        ]);

        $lina->services()->sync([
            $haircut->id,
            $hairColor->id,
            $manicure->id,
            $pedicure->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Working Hours
        |--------------------------------------------------------------------------
        |
        | 0 = Sunday
        | 1 = Monday
        | ...
        | 6 = Saturday
        |
        */

        foreach ([$sarah, $lina] as $staff) {
            for ($day = 0; $day <= 6; $day++) {
                $staff->workingHours()->create([
                    'day_of_week' => $day,
                    'start_time' => '09:00',
                    'end_time' => '17:00',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Day Off
        |--------------------------------------------------------------------------
        */

        $sarah->daysOff()->create([
            'date' => Carbon::today()->addDays(3),
            'reason' => 'Personal day',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Customers
        |--------------------------------------------------------------------------
        */

        $customer1 = Customer::create([
            'name' => 'Ahmed Ali',
            'email' => 'ahmed@example.com',
            'phone' => '55520001',
        ]);

        $customer2 = Customer::create([
            'name' => 'Mona Hassan',
            'email' => 'mona@example.com',
            'phone' => '55520002',
        ]);

        $customer3 = Customer::create([
            'name' => 'Omar Khaled',
            'email' => 'omar@example.com',
            'phone' => '55520003',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Bookings
        |--------------------------------------------------------------------------
        */

        Booking::create([
            'customer_id' => $customer1->id,
            'staff_profile_id' => $sarah->id,
            'service_id' => $haircut->id,
            'booking_date' => Carbon::today()->addDay(),
            'start_time' => '10:00',
            'end_time' => '11:00',
            'status' => 'confirmed',
            'notes' => 'Regular appointment.',
        ]);

        Booking::create([
            'customer_id' => $customer2->id,
            'staff_profile_id' => $lina->id,
            'service_id' => $manicure->id,
            'booking_date' => Carbon::today()->addDay(),
            'start_time' => '11:00',
            'end_time' => '11:45',
            'status' => 'confirmed',
            'notes' => null,
        ]);

        Booking::create([
            'customer_id' => $customer3->id,
            'staff_profile_id' => $sarah->id,
            'service_id' => $facial->id,
            'booking_date' => Carbon::today()->addDays(2),
            'start_time' => '14:00',
            'end_time' => '15:00',
            'status' => 'completed',
            'notes' => 'Completed successfully.',
        ]);
    }
}