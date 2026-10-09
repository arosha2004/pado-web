<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Policy;
use App\Models\PolicyVersion;
use App\Models\TrainingAssignment;
use App\Models\TrainingModule;
use App\Models\TrainingSection;
use App\Models\TrainingVersion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Branch::query()->delete();
        Branch::insert([
            ['name' => 'Colombo Main Branch', 'code' => 'COL-01'],
            ['name' => 'Kandy Distribution Hub', 'code' => 'KDY-02'],
        ]);

        $admin = User::updateOrCreate(['email' => 'admin@jsb.local'], [
            'name' => 'System Administrator',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'job_group' => 'it_admin',
            'branch_id' => 1,
            'status' => 'active',
            'session_version' => 1,
        ]);

        $manager = User::updateOrCreate(['email' => 'manager@jsb.local'], [
            'name' => 'Operations Manager',
            'password' => Hash::make('password123'),
            'role' => 'manager',
            'job_group' => 'management',
            'branch_id' => 1,
            'status' => 'active',
            'session_version' => 1,
        ]);

        $employee = User::updateOrCreate(['email' => 'employee@jsb.local'], [
            'name' => 'Junior Sales Officer',
            'password' => Hash::make('password123'),
            'role' => 'employee',
            'job_group' => 'sales',
            'branch_id' => 1,
            'status' => 'active',
            'session_version' => 1,
        ]);

        $policy = Policy::updateOrCreate(['title' => 'Information Security Acceptable Use Policy'], [
            'category' => 'AUP',
            'owner_id' => $manager->id,
            'status' => 'active',
        ]);

        $version = PolicyVersion::updateOrCreate([
            'policy_id' => $policy->id,
            'version_label' => '1.0',
        ], [
            'purpose' => 'Security baseline',
            'scope' => 'All staff',
            'content' => "Use only your assigned account. Complete training personally. Report incidents in good faith. Use company data responsibly and protect credentials.",
            'effective_date' => now()->toDateString(),
            'review_date' => now()->addMonths(6)->toDateString(),
            'change_summary' => 'Initial publication',
            'state' => 'published',
            'published_by' => $manager->id,
            'published_at' => now(),
            'locked' => true,
        ]);

        $policy->versions()->firstOrCreate([
            'version_label' => '1.0',
        ], [
            'purpose' => 'Security baseline',
            'scope' => 'All staff',
            'content' => "Use only your assigned account. Complete training personally. Report incidents in good faith. Use company data responsibly and protect credentials.",
            'effective_date' => now()->toDateString(),
            'review_date' => now()->addMonths(6)->toDateString(),
            'change_summary' => 'Initial publication',
            'state' => 'published',
            'published_by' => $manager->id,
            'published_at' => now(),
            'locked' => true,
        ]);

        $module = TrainingModule::create([
            'title' => 'Password & account security',
            'topic' => 'Access security',
            'objective' => 'Understand secure password hygiene.',
            'job_group_target' => 'all',
            'duration_minutes' => 15,
            'state' => 'published',
            'published_at' => now(),
        ]);

        $trainingVersion = TrainingVersion::create([
            'module_id' => $module->id,
            'title' => 'Password & account security',
            'topic' => 'Access security',
            'objective' => 'Understand secure password hygiene.',
            'job_group_target' => 'all',
            'duration_minutes' => 15,
            'linked_policy_version_id' => $version->id,
            'state' => 'published',
            'published_at' => now(),
        ]);

        TrainingSection::insert([
            ['training_version_id' => $trainingVersion->id, 'order' => 1, 'title' => 'Create strong passwords', 'content' => 'Use unique passwords and avoid re-use.', 'key_reminders' => 'Unique and strong', 'resource_url' => 'https://example.com'],
            ['training_version_id' => $trainingVersion->id, 'order' => 2, 'title' => 'Protect your account', 'content' => 'Never share credentials or leave accounts unlocked.', 'key_reminders' => 'Never share', 'resource_url' => 'https://example.com'],
        ]);

        $quizVersion = \App\Models\QuizVersion::create([
            'training_version_id' => $trainingVersion->id,
            'title' => 'Password Security Quiz',
            'pass_threshold' => 100,
            'max_attempts' => 3,
            'state' => 'published',
            'published_at' => now(),
        ]);

        $question1 = \App\Models\QuizQuestion::create([
            'quiz_version_id' => $quizVersion->id,
            'question_text' => 'Which of the following is considered a strong password?',
            'sort_order' => 1,
        ]);
        \App\Models\QuizOption::create(['question_id' => $question1->id, 'option_text' => 'password123', 'is_correct' => false]);
        \App\Models\QuizOption::create(['question_id' => $question1->id, 'option_text' => 'MyCatName', 'is_correct' => false]);
        \App\Models\QuizOption::create(['question_id' => $question1->id, 'option_text' => 'A unique, long phrase with mixed characters', 'is_correct' => true]);

        TrainingAssignment::create([
            'user_id' => $employee->id,
            'training_version_id' => $trainingVersion->id,
            'assigned_at' => now(),
            'deadline_at' => now()->addDays(10),
            'status' => 'not_started',
        ]);
    }
}
