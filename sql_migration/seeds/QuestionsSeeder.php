<?php


use Phinx\Seed\AbstractSeed;

class QuestionsSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $questions = [
            [
                'survey_id'    => 1,
                'question'    => 'Office entry without ID card (Retina scan, proximity sensor etc.)',
                'impact_group_size'    => 10,
                'occurrence_frequency' => 10,
                'experience_impact' => 10,
                'business_impact' => 10,
                'financial_feasibility' => 10,
                'technical_feasibility' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'survey_id'    => 1,
                'question'    => 'Virtual personal assistant for every employees',
                'impact_group_size'    => 10,
                'occurrence_frequency' => 10,
                'experience_impact' => 10,
                'business_impact' => 10,
                'financial_feasibility' => 10,
                'technical_feasibility' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'survey_id'    => 1,
                'question'    => 'Deep Curated learning based on role, skill and aspiration',
                'impact_group_size'    => 10,
                'occurrence_frequency' => 10,
                'experience_impact' => 10,
                'business_impact' => 10,
                'financial_feasibility' => 10,
                'technical_feasibility' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'survey_id'    => 1,
                'question'    => 'Washroom clean-up based on censors',
                'impact_group_size'    => 10,
                'occurrence_frequency' => 10,
                'experience_impact' => 10,
                'business_impact' => 10,
                'financial_feasibility' => 10,
                'technical_feasibility' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'survey_id'    => 1,
                'question'    => 'Meeting minutes on voice command and sent to recipients',
                'impact_group_size'    => 10,
                'occurrence_frequency' => 10,
                'experience_impact' => 10,
                'business_impact' => 10,
                'financial_feasibility' => 10,
                'technical_feasibility' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $questionsTable = $this->table('questions');
        $questionsTable->insert($questions)
            ->save();
    }
}
