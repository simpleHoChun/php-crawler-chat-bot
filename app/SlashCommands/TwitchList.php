<?php
namespace App\SlashCommands;

use App\Models\SlackMember;
use App\Services\SlackService;
use App\Services\TwitchService;

class TwitchList implements SlashCommandsInterface
{
    use SlashCommandsTrait;

    private $command;
    /** @var SlackMember */
    private $updater;

    /** @var TwitchService */
    private $twitchService;
    /** @var SlackService */
    private $slackService;

    public function __construct(array $command = [], SlackMember $updater)
    {
        $this->command = $command;
        $this->updater = $updater;
        $this->twitchService = app(TwitchService::class);
        $this->slackService = app(SlackService::class);
    }

    public function buildReply()
    {
        $fields = $this->twitchService->buildFollowList();
        return $this->slackService->buildSlashCommandResponse(
            'Twitch追蹤名單',
            "目前共有 {$fields->count()} 位實況主追蹤中",
            $fields->toArray()
        );
    }
}