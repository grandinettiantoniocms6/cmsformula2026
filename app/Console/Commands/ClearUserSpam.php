<?php

namespace App\Console\Commands;


use App\Models\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearUserSpam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:user_spam';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now()->subDays(2)->toDateTimeString();

        $users_ids = \DB::table("model_has_roles")->where("role_id", 5)->get()->pluck("model_id", "model_id")->toArray();

        if(count($users_ids)){
            $users = User::withTrashed()->whereIn("id", $users_ids)
                ->whereRaw("created_at <= '$now'")
                ->where("active", 0)
                ->get();

            if($users){
                foreach ($users as $user){
                    $count_order = Order::where("user_id", $user->id)->count();

                    if($count_order == 0){
                        $user->forceDelete();
                        \DB::table("model_has_roles")->where("role_id", 5)->where("model_id", $user->id)->delete();

                        $this->info("delete force $user->id - $user->email");
                    }
                }
            }
        }

    }
}
