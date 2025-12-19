<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\FocusSession;
use App\Models\Todo;
use App\Models\CalendarEvent;
use App\Models\Note;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create demo user
        $user = User::first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'Demo User',
                'email' => 'demo@spaces.test',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        // Create Focus Sessions for the past week
        $focusSessions = [
            ['date' => Carbon::now()->subDays(6), 'minutes' => 45, 'mode' => 'focus', 'task' => 'Project Documentation'],
            ['date' => Carbon::now()->subDays(6), 'minutes' => 30, 'mode' => 'focus', 'task' => 'Code Review'],
            ['date' => Carbon::now()->subDays(5), 'minutes' => 60, 'mode' => 'focus', 'task' => 'Feature Development'],
            ['date' => Carbon::now()->subDays(4), 'minutes' => 90, 'mode' => 'focus', 'task' => 'API Integration'],
            ['date' => Carbon::now()->subDays(4), 'minutes' => 25, 'mode' => 'focus', 'task' => 'Bug Fixing'],
            ['date' => Carbon::now()->subDays(3), 'minutes' => 120, 'mode' => 'focus', 'task' => 'Deep Work Session'],
            ['date' => Carbon::now()->subDays(2), 'minutes' => 45, 'mode' => 'focus', 'task' => 'Testing'],
            ['date' => Carbon::now()->subDays(2), 'minutes' => 30, 'mode' => 'focus', 'task' => 'UI Design'],
            ['date' => Carbon::now()->subDays(2), 'minutes' => 15, 'mode' => 'short', 'task' => 'Quick Fix'],
            ['date' => Carbon::now()->subDays(1), 'minutes' => 75, 'mode' => 'focus', 'task' => 'Database Optimization'],
            ['date' => Carbon::now()->subDays(1), 'minutes' => 45, 'mode' => 'focus', 'task' => 'Refactoring'],
            ['date' => Carbon::now(), 'minutes' => 25, 'mode' => 'focus', 'task' => 'Morning Planning'],
            ['date' => Carbon::now(), 'minutes' => 50, 'mode' => 'focus', 'task' => 'Implementation'],
        ];

        foreach ($focusSessions as $session) {
            FocusSession::create([
                'user_id' => $user->id,
                'duration' => $session['minutes'],
                'mode' => $session['mode'],
                'task' => $session['task'],
                'created_at' => $session['date'],
                'updated_at' => $session['date'],
            ]);
        }

        // Create Todos with various statuses
        $todos = [
            ['title' => 'Complete project documentation', 'status' => 'done', 'due_date' => Carbon::now()->subDays(2)],
            ['title' => 'Review pull requests', 'status' => 'done', 'due_date' => Carbon::now()->subDays(1)],
            ['title' => 'Prepare presentation slides', 'status' => 'doing', 'due_date' => Carbon::now()->addDays(2)],
            ['title' => 'Update API endpoints', 'status' => 'doing', 'due_date' => Carbon::now()->addDays(3)],
            ['title' => 'Fix responsive design issues', 'status' => 'todo', 'due_date' => Carbon::now()->addDays(5)],
            ['title' => 'Write unit tests', 'status' => 'todo', 'due_date' => Carbon::now()->addDays(7)],
            ['title' => 'Database optimization', 'status' => 'todo', 'due_date' => Carbon::now()->addDays(10)],
            ['title' => 'Team meeting preparation', 'status' => 'done', 'due_date' => Carbon::now()->subDays(3)],
            ['title' => 'Code refactoring', 'status' => 'doing', 'due_date' => Carbon::now()->addDays(4)],
            ['title' => 'Security audit', 'status' => 'todo', 'due_date' => Carbon::now()->addDays(14)],
            ['title' => 'Update dependencies', 'status' => 'todo', 'due_date' => null],
            ['title' => 'Client feedback review', 'status' => 'done', 'due_date' => Carbon::now()->subDays(1)],
        ];

        foreach ($todos as $todo) {
            Todo::create([
                'user_id' => $user->id,
                'title' => $todo['title'],
                'status' => $todo['status'],
                'due_date' => $todo['due_date'],
            ]);
        }

        // Create Calendar Events
        $events = [
            [
                'title' => 'Team Standup',
                'start' => Carbon::now()->addHours(2),
                'end' => Carbon::now()->addHours(2)->addMinutes(30),
                'color' => '#6366f1',
                'location' => 'Zoom Meeting Room',
            ],
            [
                'title' => 'Client Presentation',
                'start' => Carbon::now()->addDays(1)->setTime(14, 0),
                'end' => Carbon::now()->addDays(1)->setTime(15, 30),
                'color' => '#ef4444',
                'location' => 'Conference Room A',
            ],
            [
                'title' => 'Code Review Session',
                'start' => Carbon::now()->addDays(2)->setTime(10, 0),
                'end' => Carbon::now()->addDays(2)->setTime(11, 0),
                'color' => '#10b981',
                'location' => null,
            ],
            [
                'title' => 'Sprint Planning',
                'start' => Carbon::now()->addDays(3)->setTime(9, 0),
                'end' => Carbon::now()->addDays(3)->setTime(11, 0),
                'color' => '#f59e0b',
                'location' => 'Main Office',
            ],
            [
                'title' => 'Lunch with Team',
                'start' => Carbon::now()->addDays(4)->setTime(12, 0),
                'end' => Carbon::now()->addDays(4)->setTime(13, 30),
                'color' => '#8b5cf6',
                'location' => 'Cafe Downtown',
            ],
            [
                'title' => 'Workshop: New Technologies',
                'start' => Carbon::now()->addDays(5)->setTime(13, 0),
                'end' => Carbon::now()->addDays(5)->setTime(17, 0),
                'color' => '#06b6d4',
                'location' => 'Training Center',
            ],
            [
                'title' => 'Weekly Retrospective',
                'start' => Carbon::now()->addDays(6)->setTime(16, 0),
                'end' => Carbon::now()->addDays(6)->setTime(17, 0),
                'color' => '#ec4899',
                'location' => 'Zoom Meeting Room',
            ],
            [
                'title' => 'Project Deadline',
                'start' => Carbon::now()->addDays(10)->setTime(17, 0),
                'end' => Carbon::now()->addDays(10)->setTime(17, 30),
                'color' => '#ef4444',
                'location' => null,
            ],
        ];

        foreach ($events as $event) {
            CalendarEvent::create([
                'user_id' => $user->id,
                'title' => $event['title'],
                'start_time' => $event['start'],
                'end_time' => $event['end'],
                'color' => $event['color'],
                'location' => $event['location'],
            ]);
        }

        // Create Notes
        $notes = [
            [
                'title' => 'Meeting Notes - Sprint Planning',
                'content' => '<p>Key points from today\'s sprint planning:</p><ul><li>Focus on core features</li><li>Allocate time for testing</li><li>Schedule code reviews</li></ul>',
            ],
            [
                'title' => 'Ideas for Dashboard Improvements',
                'content' => '<p>Some ideas to enhance the dashboard:</p><ol><li>Add more chart types</li><li>Implement real-time updates</li><li>Create custom themes</li><li>Add export functionality</li></ol>',
            ],
            [
                'title' => 'Bug Tracking',
                'content' => '<p><strong>Critical bugs to fix:</strong></p><ul><li>Calendar timezone issue - FIXED ✓</li><li>Task sorting not working - IN PROGRESS</li><li>Notes autosave delay - TODO</li></ul>',
            ],
            [
                'title' => 'Learning Resources',
                'content' => '<p>Useful resources for the project:</p><ul><li>Laravel Documentation</li><li>TailwindCSS Best Practices</li><li>Vue.js 3 Composition API</li><li>Alpine.js Tips & Tricks</li></ul>',
            ],
            [
                'title' => 'Client Feedback Summary',
                'content' => '<p>Feedback received from client meeting:</p><p>✅ Love the dark theme<br>✅ Dashboard is very informative<br>🔄 Need more filter options<br>🔄 Export to PDF feature requested</p>',
            ],
            [
                'title' => 'Quick Commands Reference',
                'content' => '<p><code>php artisan migrate:fresh --seed</code><br><code>npm run dev</code><br><code>php artisan serve</code></p>',
            ],
        ];

        foreach ($notes as $note) {
            Note::create([
                'user_id' => $user->id,
                'title' => $note['title'],
                'content' => $note['content'],
            ]);
        }

        $this->command->info('✅ Demo data seeded successfully!');
        $this->command->info('📊 Created:');
        $this->command->info('   - ' . count($focusSessions) . ' Focus Sessions');
        $this->command->info('   - ' . count($todos) . ' Todos');
        $this->command->info('   - ' . count($events) . ' Calendar Events');
        $this->command->info('   - ' . count($notes) . ' Notes');
    }
}
