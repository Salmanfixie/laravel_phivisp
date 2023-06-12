<?php

namespace App\Console\Commands;

use Harishdurga\LaravelQuiz\Models\Question;
use Harishdurga\LaravelQuiz\Models\QuestionOption;
use Harishdurga\LaravelQuiz\Models\Quiz;
use Harishdurga\LaravelQuiz\Models\QuizQuestion;
use Harishdurga\LaravelQuiz\Models\Topic;
use Illuminate\Console\Command;

class createQuestion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'question:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an example question';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // create a topic title Quid Pro Quo Attack.
        $topic_quidproquo = Topic::create([
            'name' => 'Quid Pro Quo Attack',
            'slug' => 'quid-pro-quo-attack',
        ]);

        if ($topic_quidproquo) {
            $brochures = Topic::create([
                'name' => 'Brochures',
                'slug' => 'brochures'
            ]);
            $success_subtopic = $topic_quidproquo->children()->save($brochures);

            // if successfully create the topic and subtopic.
            if ($success_subtopic) {

                // create a question.
                $question_one = Question::create([
                    'name' => 'You received a brochure with a QR Code displayed, asking you to scan it to receive some rewards. What should you do?',
                    'question_type_id' => 2,
                    'is_active' => true,
                    'media_url' => 'url',
                    'media_type' => 'image'
                ]);

                if ($question_one) {
                    $this->info('successfully created question 1');

                    // we attach the topic to this question.
                    $try_attach = $question_one->topics()->attach([$topic_quidproquo->id, $brochures->id]);

                    if ($try_attach) {
                        $this->info('this question belongs to a topic & subtopic now.');
                    } else {
                        $this->info('cant attach this question to the topic & subtopic.');
                    }
                }

                // create some options for the question.
                $question_one_option_one = QuestionOption::create([
                    'question_id' => $question_one->id,
                    'name' => 'Investigate the QR Code before scanning it.',
                    'is_correct' => true,
                    'media_type' => 'image',
                    'media_url' => 'media url'
                ]);

                if ($question_one_option_one) {
                    $this->info('successfully created option 1 for question 1');
                }

                $question_one_option_two = QuestionOption::create([
                    'question_id' => $question_one->id,
                    'name' => 'Scan the QR Code using QR Scanner mobile application on my phone.',
                    'is_correct' => false,
                    'media_type' => 'image',
                    'media_url' => 'media url'
                ]);

                if ($question_one_option_two) {
                    $this->info('successfully created option 2 for question 1');
                }

                if ($question_one_option_one && $question_one_option_two) {

                    $quiz = Quiz::create([
                        'name' => 'Quid Pro Quo Attack Questions',
                        'description' => 'Lets test your knowledge of one of the social engineering attacks - quid pro quo.',
                        'slug' => 'quid-pro-quo-quiz',
                        'time_between_attempts' => 0, //Time in seconds between each attempt
                        'total_marks' => 10,
                        'pass_marks' => 6,
                        'max_attempts' => 1,
                        'is_published' => 1,
                        'valid_from' => now(),
                        'valid_upto' => now()->addDay(5),
                        'media_url' => '',
                        'media_type' => '',
                        'negative_marking_settings' => [
                            'enable_negative_marks' => true,
                            'negative_marking_type' => 'fixed',
                            'negative_mark_value' => 0,
                        ]
                    ]);

                    if ($quiz) {

                        $this->info('done create quiz quid pro quo.');

                        $quiz_question =  QuizQuestion::create([
                            'quiz_id' => $quiz->id,
                            'question_id' => $question_one->id,
                            'marks' => 3,
                            'order' => 1,
                            'negative_marks' => 1,
                            'is_optional' => false
                        ]);

                        // try to fetch question from this newly created quiz.
                        $this->info($quiz->questions);
                    } else {
                        $this->info('failed to create quiz.');
                    }
                }
            } else {
                $this->info('failed to create subtopic.');
            }
        } else {
            $this->info('failed to create topic.');
        }
    }
}
