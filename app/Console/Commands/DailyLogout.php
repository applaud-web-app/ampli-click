<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Students;

class DailyLogout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily_logout:twice_a_day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $students = Students::Where('status','>=',0)->update(['logged_in_devices' => '0','remember_token'=>NULL]);
        \DB::table('sessions')->where('student_user_id','>',0)->truncate();
    }
}
