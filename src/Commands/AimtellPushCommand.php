<?php

namespace Collinped\LaravelAimtell\Commands;

use Collinped\Aimtell\Aimtell;
use Illuminate\Console\Command;

class AimtellPushCommand extends Command
{
    public $signature = 'aimtell:push
                            {subscriber : The Subscriber ID to send the sample push}
                            {--site= : The Site ID to send the Notification from}';

    public $description = 'Send a sample push notification to a Subscriber';

    public function handle(Aimtell $aimtell): void
    {
        $siteId = ($this->argument('site') ? $this->argument('site') : config('aimtell.default_site_id'));
        $subscriberId = $this->argument('subscriber');

        $aimtell->site($siteId)
            ->push()
            ->title('Sample Notification')
            ->message('Here is your sample message')
            ->link('https://www.laravel.com')
            ->toSubscriber($subscriberId)
            ->withButton([
                'link' => 'sampleUrl',
                'title' => 'Sample Title 1',
            ])
            ->withButton([
                'link' => 'sampleUrl2',
                'title' => 'Sample Title 2',
            ])
            ->send();

        $this->comment('Successfully sent push notification to subscriber ID: ' . $subscriberId);
    }
}
