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
            ],
            [
                'name' => 'arifuddin',
                'email' => 'arifuddin@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'smhaque',
                'email' => 'smhaque@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'ejaz',
                'email' => 'ejaz@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'tkhan',
                'email' => 'tkhan@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'farhana.islam',
                'email' => 'farhana.islam@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'saiful_alam',
                'email' => 'saiful_alam@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'shaila.rahman',
                'email' => 'shaila.rahman@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'zahid_zaman',
                'email' => 'zahid_zaman@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'aem.saidur',
                'email' => 'aem.saidur@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'sanat',
                'email' => 'sanat@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'shabbir',
                'email' => 'shabbir@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'ashfaqur',
                'email' => 'ashfaqur@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'naureen.quayum',
                'email' => 'naureen.quayum@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'khairul.basher',
                'email' => 'khairul.basher@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'shareef',
                'email' => 'shareef@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'tanvir.husain',
                'email' => 'tanvir.husain@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'aneeq',
                'email' => 'aneeq@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'sizaman',
                'email' => 'sizaman@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'mehadi.ghani',
                'email' => 'mehadi.ghani@grameenphone.com',
                'password' => $password,
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $usersTable = $this->table('users');
        $usersTable->insert($users)
            ->save();
    }
}
