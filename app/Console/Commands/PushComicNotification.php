<?php

namespace App\Console\Commands;

use App\Helper;
use App\Models\Comic;
use App\Services\ComicService;
use App\Services\CrawlerService;
use App\Services\LineBotService;
use App\Services\SlackService;
use App\Transformers\Slack\PushComicTransformer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PushComicNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:push-99770-comic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '推送當天最新的追蹤漫畫';


    private $path;

    /** @var CrawlerService  */
    private $crawlerService;

    /** @var LineBotService  */
    private $lineBotService;

    /** @var SlackService  */
    private $slackService;

    /** @var ComicService  */
    private $comicService;

    /**
     * @var array 追蹤的動畫清單
     */
    protected static $comicList = [
        'onePiece' => '170',
        'tokyoGhoul' => '25010',
    ];

    /**
     * PushComicNotification constructor.
     * @param CrawlerService $crawlerService
     * @param LineBotService $lineBotService
     * @param SlackService $slackService
     */
    public function __construct(
        CrawlerService $crawlerService,
        LineBotService $lineBotService,
        SlackService $slackService,
        ComicService $comicService
    ) {
        parent::__construct();
        $this->path = config('services.url.comic99770');
        $this->crawlerService = $crawlerService;
        $this->lineBotService = $lineBotService;
        $this->slackService = $slackService;
        $this->comicService = $comicService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $broadcastList = $this->comicService->getAll()->transform(function (Comic $comic) {
            return $comic->comic_id;
        })->toArray();
        $filterDays = [
            now()->format('Y-m-d'),
            now()->subDay()->format('Y-m-d'),
        ];

        $targets = [];
        foreach ($broadcastList as $key => $value) {
            $path = $this->path . $value;
            $crawler = $this->crawlerService->getOriginalData($path);
            $target = $this->crawlerService->getNewEpisodeFromComic99770($crawler);

            if (in_array($target['date'], $filterDays, true)) {
                $targets[] = $target;
            }
        }
        if (empty($targets)) {
            echo "There is no comic today!\n";
            return;
        }

        $message = now()->format('m/d') . " 最新的追蹤漫畫來囉！";

        $messageBuilders = $this->lineBotService->buildTemplateMessageBuilder(
            $this->getTargetsForLine($targets),
            $message
        );

        foreach ($messageBuilders as $target) {
            $this->lineBotService->pushMessage($target);
        }

        $targets = array_map(function ($target) {
            return Helper::slackTransform(PushComicTransformer::class, $target);
        }, $targets);

        $this->slackService->sendMessage($message, $targets, '#comic', '動漫外送員');


        echo "Push comic done!\n";
    }

    /**
     * @deprecated Line的Template要換一個
     * @param array $targets
     * @return array
     */
    private function getTargetsForLine(array $targets): array
    {
        return array_map(function ($target) {
            $target['imagePath'] = 'https://i.imgur.com/3eue6GG.gif';
            return $target;
        }, $targets);
    }
}
