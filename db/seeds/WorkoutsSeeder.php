<?php


use Phinx\Seed\AbstractSeed;

class WorkoutsSeeder extends AbstractSeed
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
                'user_id' => 1,
                'start_time' => date("Y-m-d H:i:s", mktime(22, 20, 0, 4, 26, 2019)),
                'end_time' => date("Y-m-d H:i:s", mktime(23, 12, 0, 4, 26, 2019)),
                'type' => 'CYCLING',
                'title' => 'Late night ride',
                'message' => 'some message',
                'calories' => 768,
                'distance' => 7256,
                'created_at' => date("Y-m-d H:i:s", mktime(23, 20, 0, 4, 26, 2019))
            ],
            [
                'user_id' => 1,
                'start_time' => date("Y-m-d H:i:s", mktime(7, 2, 0, 4, 28, 2019)),
                'end_time' => date("Y-m-d H:i:s", mktime(7, 45, 0, 4, 28, 2019)),
                'type' => 'RUNNING',
                'title' => 'Early morning run',
                'message' => 'another message',
                'calories' => 256,
                'distance' => 680,
                'created_at' => date("Y-m-d H:i:s", mktime(8, 00, 0, 4, 28, 2019))
            ]
        ];

        $workouts = $this->table('workouts');
        $workouts->insert($data)
            ->save();
    }
}
