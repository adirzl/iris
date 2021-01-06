<?php

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Modules\User\Entities\User;

class ReleaseIdleSession extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'session:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release idle session';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereNotNull('session_id')->get();
        $prefix = Str::slug(config('app.display_name'), '_') . '_database' . '_' . Str::slug(config('app.display_name'), '_') . '_cache';
        $redis = new \Predis\Client();

        // foreach ($users as $user) {
        //     $idleMinutes = now()->diffInMinutes(\Carbon\Carbon::parse($user->last_activity));
            
        //     if ($idleMinutes > intval(config('parameter.auto_logout'))) {
        //         $deleted = $redis->del($prefix . ':' . $user->session_id);

        //         if ($deleted == 1) {
        //             User::where('id', $user->id)->update(['session_id' => null]);
        //             \Illuminate\Support\Facades\Auth::logout();
        //         }
        //     }
        // }
    }
}
