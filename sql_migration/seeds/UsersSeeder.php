<?php


use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
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
        $password = password_hash('abc@123', PASSWORD_BCRYPT);;
        $users = [
            [
                'name'    => 'Survey Admin',
                'email'    => 'survey_admin@gmail.com',
                'password' => $password,
                'role' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'    => 'Survey User 01',
                'email'    => 'survey_user_01@gmail.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'    => 'Survey User 02',
                'email'    => 'survey_user_02@gmail.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $usersTable = $this->table('users');
        $usersTable->insert($users)
            ->save();
    }
}
