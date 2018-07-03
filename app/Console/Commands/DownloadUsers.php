<?php

namespace App\Console\Commands;

use Http\Client\Common\Exception\HttpClientNotFoundException;
use Illuminate\Console\Command;
use App\Models\TwitterUsers;

class DownloadUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 't:users';

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
     * @return mixed
     */
    public function handle()
    {
        $this->download();
    }

    private function download()
    {
        $counter = 1;
        foreach (TwitterUsers::get() as $user) {
            $this->info($counter . ': user : http://twitter.com/' . $user->username);
            $this->DownloadUser($user, null, 1, 1);
            $this->updateUserLastDownload($user);
            $counter++;
        }
    }


    private function DownloadUser($user, $max_id = null, $counter = 1, $page = 1)
    {
        $path = $this->CreateDirectoryForUser($user->username);
        $this->comment($path);
        if ($page > 1) {
            $this->comment('page : ' . $page . ' ---> http://twitter.com/' . $user->username);
        }
        try {
            $call_data_array = ['screen_name' => $user->username, 'count' => 20];
            if ($max_id) {
                $call_data_array = array_add($call_data_array, 'max_id', $max_id);
            }
            $tweets = \Twitter::getUserTimeline($call_data_array);


            if (count($tweets) > 0) {
                $last_tweet_id = last($tweets)->id;
                if ($max_id != $last_tweet_id) {
                    foreach ($tweets as $tweet) {
                        if ($user->last_downloaded_id == $tweet->id) return false;
                        if (isset($tweet->extended_entities)) {
                            foreach ($tweet->extended_entities->media as $item) {
                                if ($item->type == 'video') {
                                    $url = last($item->video_info->variants)->url;
                                    $type = last(explode('/', last($item->video_info->variants)->content_type));
                                    $filename = last(explode('/', $url)) . '.' . $type;
                                } else {
                                    $url = $item->media_url;
                                    $filename = last(explode('/', $url));
                                }

                                if (!file_exists($path . "/" . $filename)) {
                                    try {
                                        $this->line($tweet->id . " " . $counter . '- ' . $path . '/' . $filename);
                                        copy($url, $path . "/" . $filename);
                                        $counter++;
                                    } catch (\Exception $exception) {
                                        $this->error("exception : " . $user->username, $exception->getMessage());
                                    }
                                }
                            }
                        }
                    }
                    unset($tweets);
                    $page++;
                    $this->DownloadUser($user, $last_tweet_id, $counter, $page);
                }
            } else {
                return false;
            }

        } catch (\Exception $exception) {
            $this->error($user->username, $exception->getMessage());
        }
    }

    private function CreateDirectoryForUser($user)
    {
        $download_path = env('DOWNLOAD_PATH');
        if (!$download_path) {
            $this->info('you don\'t define download path on env file so it\'s will be in download folder  ' . base_path('download'));
            $download_path = base_path('download');
        }
        if (!file_exists($download_path . "/" . $user)) {
            mkdir($download_path . "/" . $user, 0777, true);
        }
        return $download_path . "/" . $user;
    }

    private function
    updateUserLastDownload($user)
    {
        $tweet = last(\Twitter::getUserTimeline(['screen_name' => $user->username, 'count' => 1]));
        $user->update(['last_downloaded_id' => $tweet->id]);
    }

}
