<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
        $data = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'created_at' => date("Y-m-d H:i:s", mktime(22, 20, 0, 4, 24, 2019)),
            ],
            [
                'username' => 'someuser',
                'email' => 'someuser@example.com',
                'created_at' => date("Y-m-d H:i:s", mktime(23, 30, 0, 4, 27, 2019))
            ],
            [
                'username' => 'anotheruser',
                'email' => 'anotheruser@example.com',
                'created_at' => date("Y-m-d H:i:s")
            ],
        ];

        $users = $this->table('users');
        $users->insert($data)
            ->save();
    }
}
