<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use App\Models\QuizVersion;
use App\Models\AttemptAnswer;
use App\Models\TrainingAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    public function show(QuizVersion $quizVersion)
    {
        $assignment = TrainingAssignment::where('user_id', auth()->id())
            ->where('training_version_id', $quizVersion->training_version_id)
            ->firstOrFail();

        $attemptsCount = QuizAttempt::where('assignment_id', $assignment->id)
            ->where('quiz_version_id', $quizVersion->id)
            ->count();

        if ($attemptsCount >= $quizVersion->max_attempts) {
            return back()->withErrors('You have reached the maximum number of attempts.');
        }

        $quizVersion->load('questions.options');

        return view('training.quiz', compact('quizVersion', 'assignment'));
    }

    public function submit(Request $request, QuizVersion $quizVersion, \App\Services\AuditService $auditService)
    {
        $assignment = TrainingAssignment::where('user_id', auth()->id())
            ->where('training_version_id', $quizVersion->training_version_id)
            ->firstOrFail();

        $attemptsCount = QuizAttempt::where('assignment_id', $assignment->id)
            ->where('quiz_version_id', $quizVersion->id)
            ->count();

        if ($attemptsCount >= $quizVersion->max_attempts) {
            return back()->withErrors('You have reached the maximum number of attempts.');
        }

        $answers = $request->input('answers', []);
        $correctAnswers = 0;
        $totalQuestions = $quizVersion->questions()->count();

        $attempt = QuizAttempt::create([
            'assignment_id' => $assignment->id,
            'quiz_version_id' => $quizVersion->id,
            'ordinal' => $attemptsCount + 1,
            'submission_key' => Str::random(32),
            'submitted_at' => now(),
            'score' => 0,
            'passed' => false,
        ]);

        foreach ($quizVersion->questions as $question) {
            $selectedOptionId = $answers[$question->id] ?? null;
            $isCorrect = false;

            if ($selectedOptionId) {
                $option = $question->options()->find($selectedOptionId);
                if ($option && $option->is_correct) {
                    $isCorrect = true;
                    $correctAnswers++;
                }

                AttemptAnswer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'selected_option_id' => $selectedOptionId,
                    'is_correct' => $isCorrect,
                ]);
            }
        }

        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;
        $passed = $score >= $quizVersion->pass_threshold;

        $attempt->update([
            'score' => $score,
            'passed' => $passed,
        ]);

        if ($passed) {
            $assignment->update(['status' => 'completed']);
        }

        $auditService->record('quiz.attempt', $passed ? 'success' : 'failure', 'QuizAttempt', $attempt->id, ['score' => $score]);

        return redirect()->route('training.index')->with('success', "Quiz submitted! You scored {$score}%." . ($passed ? ' You passed.' : ' You failed.'));
    }
}
