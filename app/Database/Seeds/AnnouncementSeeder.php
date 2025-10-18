<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Welcome to the New Academic Year!',
                'content' => 'We are excited to welcome all students to the new academic year. Please make sure to check your enrollment status and course schedules. If you have any questions, feel free to contact the registrar\'s office. We wish you all the best for a successful academic year ahead!',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'title' => 'System Maintenance Notice',
                'content' => 'Please be informed that the student portal will undergo scheduled maintenance this weekend from Saturday 10:00 PM to Sunday 6:00 AM. During this time, the system may be temporarily unavailable. We apologize for any inconvenience this may cause and appreciate your understanding.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'title' => 'Course Registration Deadline Reminder',
                'content' => 'This is a friendly reminder that the deadline for course registration is approaching fast. All students must complete their course enrollment by Friday, 5:00 PM. Late registrations will incur additional fees. Please ensure you have enrolled in all required courses for your program.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert multiple rows
        $this->db->table('announcements')->insertBatch($data);
        
        echo "AnnouncementSeeder completed successfully. " . count($data) . " announcements inserted.\n";
    }
}
