<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;
use App\Helper;
use App\SiteManagement;
use App\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Mail\GeneralEmailMailable;
use DB;
use Log;

class UserEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Create a new event instance.
     * 
     * @param collection $user returns user
     * 
     * @return void
     */
    public function userCreated(User $user)
    {
        $email_settings = SiteManagement::getMetaValue('settings');
        if (!empty($email_settings[0]['email'])) {
            $email_params = array();
            $template = DB::table('email_types')->select('id')
                ->where('email_type', 'verification_code')->get()->first();
            if (!empty($template->id)) {
                $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                $email_params['verification_code'] = $user->verification_code;
                $email_params['name'] = Helper::getUserName($user->id);
                $email_params['email'] = $user->email;
                Mail::to($user->email)
                    ->send(
                        new GeneralEmailMailable(
                            'verification_code',
                            $template_data,
                            $email_params
                        )
                    );
            }
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
