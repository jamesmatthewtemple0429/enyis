<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GetRcCareFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:get-rc-care-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private function getFileName($messageSubject) {
        if(Str::contains($messageSubject, "*ISUSERS")) {
            return "users.csv";
        } else if(Str::contains($messageSubject, "*ISEVENTS")) {
            return "events.csv";
        } else if(Str::contains($messageSubject, "*ISCASES")) {
            return "cases.csv";
        } else if(Str::contains($messageSubject, "*ISCLIENTS")) {
            return "clients.csv";
        }
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $allFolders = json_decode(Http::withToken(User::first()->access_token)->get("https://graph.microsoft.com/v1.0/me/mailFolders")
            ->getBody()
            ->getContents(), true)['value'];

        $isFolder = null;

        foreach($allFolders as $folder) {
            if($folder['displayName'] == "INFOSYS") {
               $isFolder = $folder;
            }
        }

        $allMessages = json_decode(Http::withToken(User::first()->access_token)->get("https://graph.microsoft.com/v1.0/me/mailFolders/" . $isFolder['id'] . "/messages")
            ->getBody()
            ->getContents(), true)['value'];

        foreach($allMessages as $message) {
            $attachments = json_decode(Http::withToken(User::first()->access_token)->get("https://graph.microsoft.com/v1.0/me/messages/" . $message['id'] ."/attachments")
                ->getBody()
                ->getContents(), true)['value'][0];

            Storage::disk('lists')->put(
                $this->getFileName($message['subject']),
                base64_decode($attachments['contentBytes'])
            );

            Http::withToken(User::first()->access_token)->delete("https://graph.microsoft.com/v1.0/me/messages/" . $message['id']);
        }
    }
}
