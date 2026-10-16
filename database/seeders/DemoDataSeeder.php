<?php

namespace Database\Seeders;



use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $now = now();

            // Create a demo login only when the users table is empty.
            $user = User::query()->first();
            if (!$user) {
                $user = User::query()->create([
                    'name' => 'Demo Teacher',
                    'email' => 'demo@tdsattendance.test',
                    'password' => Hash::make('Demo@12345'),
                    'email_verified_at' => $now,
                ]);
            }

            $locationData = [
                ['name' => 'TDS Dance Studio - Dehiwala', 'address' => 'No. 24, Hill Street, Dehiwala', 'notes' => 'Main studio with a mirrored dance floor.'],
                ['name' => 'Community Hall - Mount Lavinia', 'address' => 'Community Hall, Mount Lavinia', 'notes' => 'Weekend classes and workshops.'],
                ['name' => 'Nugegoda Practice Studio', 'address' => 'No. 18, High Level Road, Nugegoda', 'notes' => 'Small-group practice sessions.'],
            ];

            $locations = [];
            foreach ($locationData as $row) {
                $locations[] = DB::table('locations')->insertGetId($row + ['status' => true, 'created_at' => $now, 'updated_at' => $now]);
            }

            $classData = [
                ['location_id' => $locations[0], 'name' => 'Kids Beginner Dance', 'monthly_fee' => 2500, 'start_time' => '09:00:00', 'end_time' => '10:00:00', 'days' => [6]],
                ['location_id' => $locations[0], 'name' => 'Junior Dance Group', 'monthly_fee' => 3000, 'start_time' => '10:30:00', 'end_time' => '11:45:00', 'days' => [6]],
                ['location_id' => $locations[0], 'name' => 'Teen Contemporary Dance', 'monthly_fee' => 3500, 'start_time' => '15:30:00', 'end_time' => '17:00:00', 'days' => [2, 5]],
                ['location_id' => $locations[1], 'name' => 'Adult Dance Fitness', 'monthly_fee' => 3000, 'start_time' => '17:30:00', 'end_time' => '18:30:00', 'days' => [3]],
                ['location_id' => $locations[2], 'name' => 'Performance Team', 'monthly_fee' => 4000, 'start_time' => '16:00:00', 'end_time' => '17:30:00', 'days' => [4]],
            ];

            $classes = [];
            foreach ($classData as $row) {
                $days = $row['days'];
                unset($row['days']);
                $classId = DB::table('classes')->insertGetId($row + ['status' => true, 'created_at' => $now, 'updated_at' => $now]);
                $classes[] = ['id' => $classId] + $row + ['days' => $days];
                foreach ($days as $day) {
                    DB::table('class_days')->insert([
                        'class_id' => $classId,
                        'day_of_week' => $day,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }

            $firstNames = ['Amaya', 'Kavindi', 'Senuri', 'Dineth', 'Tharushi', 'Nethmi', 'Sahan', 'Vihanga', 'Minoli', 'Ashen', 'Piumi', 'Hiruni', 'Dulshan', 'Sachini', 'Oneli', 'Ravindu', 'Yasara', 'Keshan', 'Shenali', 'Bimsara', 'Ayesha', 'Malith', 'Sewmi', 'Nimasha', 'Pasindu', 'Hasini', 'Kavishka', 'Nethara', 'Imesha', 'Rashmi', 'Dilan', 'Thilini', 'Janith', 'Sithumi', 'Oshini', 'Lahiru', 'Methuli', 'Chamod', 'Dinuli', 'Akila', 'Sajini', 'Vishwa', 'Mihiri', 'Ruwani', 'Yuhas', 'Shashini', 'Nadun', 'Pavithra', 'Kavish', 'Thejani'];
            $lastNames = ['Perera', 'Fernando', 'Silva', 'Jayasinghe', 'Wijesinghe', 'Bandara', 'Gunasekara', 'Rathnayake', 'Wickramasinghe', 'Senanayake', 'Karunaratne', 'Dissanayake', 'Abeysekara', 'Amarasinghe', 'De Silva'];
            $students = [];

            for ($i = 0; $i < 50; $i++) {
                $studentId = DB::table('students')->insertGetId([
                    'registration_number' => 'TDS-' . str_pad((string) ($i + 1), 5, '0', STR_PAD_LEFT),
                    'name' => $firstNames[$i] . ' ' . $lastNames[$i % count($lastNames)],
                    'date_of_birth' => Carbon::now()->subYears(7 + ($i % 15))->subDays(($i * 13) % 365)->toDateString(),
                    'gender' => $i % 7 === 0 ? 'Other' : ($i % 2 === 0 ? 'Female' : 'Male'),
                    'student_contact_number' => '07' . str_pad((string) (10000000 + ($i * 13791) % 89999999), 8, '0', STR_PAD_LEFT),
                    'address' => ['Dehiwala', 'Mount Lavinia', 'Nugegoda', 'Wellawatte', 'Kohuwala', 'Boralesgamuwa'][$i % 6] . ', Sri Lanka',
                    'notes' => $i % 9 === 0 ? 'Interested in stage performances.' : null,
                    'status' => $i % 17 !== 0,
                    'created_at' => $now->copy()->subDays(20 + ($i % 240)),
                    'updated_at' => $now,
                ]);
                $students[] = ['id' => $studentId, 'active' => $i % 17 !== 0];

                // Give every student one primary class and a few students a second class.
                $primaryIndex = $i % count($classes);
                $primaryClass = $classes[$primaryIndex];
                $registrationDate = $now->copy()->subDays(30 + (($i * 7) % 240))->toDateString();
                DB::table('student_class_registrations')->insert([
                    'student_id' => $studentId,
                    'class_id' => $primaryClass['id'],
                    'is_primary_class' => true,
                    'registration_date' => $registrationDate,
                    'status' => $students[$i]['active'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                if ($i % 4 === 0) {
                    $secondaryIndex = ($primaryIndex + 1 + ($i % (count($classes) - 1))) % count($classes);
                    if ($secondaryIndex !== $primaryIndex) {
                        DB::table('student_class_registrations')->insert([
                            'student_id' => $studentId,
                            'class_id' => $classes[$secondaryIndex]['id'],
                            'is_primary_class' => false,
                            'registration_date' => $registrationDate,
                            'status' => $students[$i]['active'],
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                }
            }

            // Create weekly sessions from three months ago through two months ahead.
            $today = Carbon::today();
            $start = $today->copy()->subMonths(3)->startOfWeek(Carbon::MONDAY);
            $end = $today->copy()->addMonths(2)->endOfWeek(Carbon::SUNDAY);
            $sessionsByClassAndMonth = [];

            foreach ($classes as $class) {
                for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                    if (!in_array($date->dayOfWeekIso, $class['days'], true)) {
                        continue;
                    }

                    $sessionStatus = $date->lt($today) ? 'Completed' : 'Upcoming';
                    $sessionId = DB::table('class_sessions')->insertGetId([
                        'class_id' => $class['id'],
                        'session_date' => $date->toDateString(),
                        'start_time' => $class['start_time'],
                        'end_time' => $class['end_time'],
                        'status' => $sessionStatus,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                    $monthKey = $class['id'] . '-' . $date->year . '-' . $date->month;
                    $sessionsByClassAndMonth[$monthKey] = ($sessionsByClassAndMonth[$monthKey] ?? 0) + 1;

                    // Add attendance to completed sessions only, keeping future sessions unmarked.
                    if ($sessionStatus === 'Completed') {
                        $registered = DB::table('student_class_registrations')
                            ->where('class_id', $class['id'])
                            ->where('status', true)
                            ->whereNull('deleted_at')
                            ->get(['student_id']);

                        foreach ($registered as $registration) {
                            $studentNumber = (int) substr((string) DB::table('students')->where('id', $registration->student_id)->value('registration_number'), -5);
                            $roll = ($studentNumber + $date->day + $class['id']) % 12;
                            $attendanceStatus = $roll < 8 ? 'Present' : ($roll < 10 ? 'Absent' : 'Late');
                            DB::table('attendances')->insert([
                                'class_session_id' => $sessionId,
                                'student_id' => $registration->student_id,
                                'marked_by' => $user->id,
                                'attendance_status' => $attendanceStatus,
                                'marked_at' => $date->copy()->setTimeFromTimeString($class['end_time'])->toDateTimeString(),
                                'remarks' => $attendanceStatus === 'Late' ? 'Arrived a little late.' : null,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]);
                        }
                    }
                }
            }

            // Seed payments for the previous five months and the current month.
            $currentMonth = Carbon::now()->startOfMonth();
            foreach ($classes as $class) {
                $registrations = DB::table('student_class_registrations')
                    ->where('class_id', $class['id'])
                    ->where('status', true)
                    ->whereNull('deleted_at')
                    ->get(['student_id']);

                foreach ($registrations as $registration) {
                    for ($offset = 5; $offset >= 0; $offset--) {
                        $month = $currentMonth->copy()->subMonths($offset);
                        $studentNumber = (int) substr((string) DB::table('students')->where('id', $registration->student_id)->value('registration_number'), -5);
                        $isPaid = (($studentNumber + $month->month + $class['id']) % 10) < ($offset === 0 ? 6 : 8);
                        $paidAmount = $isPaid ? (float) $class['monthly_fee'] : 0;

                        DB::table('student_payments')->insert([
                            'student_id' => $registration->student_id,
                            'class_id' => $class['id'],
                            'payment_month' => $month->month,
                            'payment_year' => $month->year,
                            'monthly_fee' => $class['monthly_fee'],
                            'paid_amount' => $paidAmount,
                            'payment_date' => $isPaid ? $month->copy()->day(min(5 + ($studentNumber % 20), $month->daysInMonth))->toDateString() : null,
                            'payment_status' => $isPaid ? 'Paid' : 'Unpaid',
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                }
            }

            $events = [
                ['title' => 'Contemporary Dance Workshop', 'event_type' => 'Workshop', 'event_date' => $today->copy()->addDays(8)->toDateString(), 'start_time' => '14:00:00', 'end_time' => '16:00:00', 'description' => 'A special workshop focused on movement, rhythm, and stage confidence.'],
                ['title' => 'Annual Student Showcase', 'event_type' => 'Event', 'event_date' => $today->copy()->addDays(24)->toDateString(), 'start_time' => '16:00:00', 'end_time' => '18:30:00', 'description' => 'Students present short routines for family and friends.'],
                ['title' => 'Studio Deep Cleaning', 'event_type' => 'Holiday', 'event_date' => $today->copy()->addDays(15)->toDateString(), 'start_time' => null, 'end_time' => null, 'description' => 'Regular classes are not scheduled on this day.'],
                ['title' => 'New Term Orientation', 'event_type' => 'Event', 'event_date' => $today->copy()->addDays(3)->toDateString(), 'start_time' => '10:00:00', 'end_time' => '11:00:00', 'description' => 'Meet the teacher and review the upcoming term schedule.'],
                ['title' => 'School Holiday Break', 'event_type' => 'Holiday', 'event_date' => $today->copy()->addDays(45)->toDateString(), 'start_time' => null, 'end_time' => null, 'description' => 'Studio closed for the holiday break.'],
                ['title' => 'Stage Performance Practice', 'event_type' => 'Workshop', 'event_date' => $today->copy()->subDays(12)->toDateString(), 'start_time' => '15:00:00', 'end_time' => '17:00:00', 'description' => 'Past workshop used to populate calendar history.'],
            ];
            foreach ($events as $event) {
                DB::table('calendar_events')->insert($event + ['status' => true, 'created_at' => $now, 'updated_at' => $now]);
            }

            DB::table('settings')->insert([
                'teacher_name' => 'Nadeesha Perera',
                'institute_name' => 'TDS Dance Academy',
                'logo' => null,
                'contact_number' => '0771234567',
                'email' => 'hello@tdsdance.example',
                'address' => '24, Hill Street, Dehiwala, Sri Lanka',
                'default_subject' => 'Dancing',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        });

        $this->command?->info('Demo data created: locations, classes, 50 students, registrations, sessions, attendance, payments, calendar events, and settings.');
        $this->command?->info('If no existing user was found, demo login: demo@tdsattendance.test / Demo@12345');
    }
}

