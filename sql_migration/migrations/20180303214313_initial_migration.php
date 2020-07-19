<?php


use Phinx\Migration\AbstractMigration;

class InitialMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $usersTable = $this->table('users')
            ->addColumn('name', 'string', ['default' => null, 'null' => true])
            ->addColumn('email', 'string')
            ->addColumn('password', 'string', ['default' => null, 'null' => true])
            ->addColumn('role', 'string', ['default' => null, 'null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addIndex('email', ['unique' => true, 'name' => 'iux_users_email'])
            ->create();

        $surveys = $this->table('surveys')
            ->addColumn('name', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $usersSurveys = $this->table('users_surveys')
            ->addColumn('survey_id', 'integer')
            ->addColumn('user_id', 'integer')
            ->addColumn('score', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addForeignKey(['user_id'], 'users', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey(['survey_id'], 'surveys', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create();

        $questions = $this->table('questions')
            ->addColumn('survey_id', 'integer')
            ->addColumn('question', 'string')
            ->addColumn('impact_group_size', 'integer')
            ->addColumn('occurrence_frequency', 'integer')
            ->addColumn('experience_impact', 'integer')
            ->addColumn('business_impact', 'integer')
            ->addColumn('financial_feasibility', 'integer')
            ->addColumn('technical_feasibility', 'integer')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addForeignKey(['survey_id'], 'surveys', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create();

        $answers = $this->table('answers')
            ->addColumn('user_id', 'integer')
            ->addColumn('survey_id', 'integer')
            ->addColumn('question_id', 'integer')
            ->addColumn('impact_group_size', 'string')
            ->addColumn('occurrence_frequency', 'string')
            ->addColumn('experience_impact', 'string')
            ->addColumn('business_impact', 'string')
            ->addColumn('financial_feasibility', 'string')
            ->addColumn('technical_feasibility', 'string')
            ->addColumn('average_score', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addForeignKey(['user_id'], 'users', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey(['question_id'], 'questions', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey(['survey_id'], 'surveys', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create();
    }
}
