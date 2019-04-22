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
                'name' => 'xyz',
                'password' => 'fdfsdfsd',
            ],
            [
                'name' => 'zyx',
                'password' => 'fdfsdsd',
            ],
            [
                'name' => 'abc',
                'password' => 'fdfassd',
            ],
        ];

        $users = $this->table('users');
        $users->insert($data)
            ->save();
    }
}
