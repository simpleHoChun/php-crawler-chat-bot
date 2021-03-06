<?php
namespace Tests\Feature\Slack;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SlashCommandTest extends TestCase
{
    use DatabaseTransactions;

    private $responseUrl;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->responseUrl = 'https://hooks.slack.com/services/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';
    }

    public function tearDown()
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    public function testReturn401WhenReplySlashCommandTwitch()
    {
        $data = [];

        $response = $this->post('/api/slack/slash-commands/twitch', $data);

        $response->assertStatus(200);
    }

    public function testReturn401WhenReplySlashCommandComic()
    {
        $data = [];

        $response = $this->post('/api/slack/slash-commands/comic', $data);

        $response->assertStatus(200);
    }

    /**
     * @testdox 回傳指令清單
     */
    public function testReturn200WhenReplySlashCommandTwitchPart1()
    {
        $token = config('services.slack.slash.secretary');
        if (empty($token)) {
            $this->markTestSkipped('none token');
        }
        $data = [
            'token' => $token,
            'team_id'=> '',
            'team_domain'=> '',
            'channel_id'=> '',
            'channel_name'=> '',
            'user_id'=> 'admin',
            'user_name'=> 'admin',
            'command'=> '',
            'text'=> '',
            'response_url'=> $this->responseUrl,
        ];

        $response = $this->post('/api/slack/slash-commands/twitch', $data);

        $response->assertStatus(200);
    }

    /**
     * @testdox 回傳追蹤名單
     */
    public function testReturn200WhenReplySlashCommandTwitchPart2()
    {
        $token = config('services.slack.slash.secretary');
        if (empty($token)) {
            $this->markTestSkipped('none token');
        }
        $data = [
            'token' => $token,
            'team_id'=> '',
            'team_domain'=> '',
            'channel_id'=> '',
            'channel_name'=> '',
            'user_id'=> 'admin',
            'user_name'=> 'admin',
            'command'=> '',
            'text'=> 'list',
            'response_url'=> $this->responseUrl,
        ];

        $response = $this->post('/api/slack/slash-commands/twitch', $data);

        $response->assertStatus(200);
    }

    /**
     * @testdox 新增追蹤名單
     */
    public function testReturn200WhenReplySlashCommandTwitchPart3()
    {
        $token = config('services.slack.slash.secretary');
        if (empty($token)) {
            $this->markTestSkipped('none token');
        }
        $data = [
            'token' => $token,
            'team_id'=> '',
            'team_domain'=> '',
            'channel_id'=> '',
            'channel_name'=> '',
            'user_id'=> 'admin',
            'user_name'=> 'admin',
            'command'=> '',
            'text'=> 'add test testChannelId',
            'response_url'=> $this->responseUrl,
        ];

        $response = $this->post('/api/slack/slash-commands/twitch', $data);

        $response->assertStatus(200);
    }

    /**
     * @testdox 刪除追蹤名單
     */
    public function testReturn200WhenReplySlashCommandTwitchPart4()
    {
        $token = config('services.slack.slash.secretary');
        if (empty($token)) {
            $this->markTestSkipped('none token');
        }
        $data = [
            'token' => $token,
            'team_id'=> '',
            'team_domain'=> '',
            'channel_id'=> '',
            'channel_name'=> '',
            'user_id'=> 'admin',
            'user_name'=> 'admin',
            'command'=> '',
            'text'=> 'delete testChannelId',
            'response_url'=> $this->responseUrl,
        ];

        $response = $this->post('/api/slack/slash-commands/twitch', $data);

        $response->assertStatus(200);
    }

    /**
     * @testdox 刪除不存在的追蹤名單
     */
    public function testReturn200WhenReplySlashCommandTwitchPart5()
    {
        $token = config('services.slack.slash.secretary');
        if (empty($token)) {
            $this->markTestSkipped('none token');
        }
        $data = [
            'token' => $token,
            'team_id'=> '',
            'team_domain'=> '',
            'channel_id'=> '',
            'channel_name'=> '',
            'user_id'=> 'admin2',
            'user_name'=> 'admin2',
            'command'=> '',
            'text'=> 'delete unknownChannelId',
            'response_url'=> $this->responseUrl,
        ];

        $response = $this->post('/api/slack/slash-commands/twitch', $data);

        $response->assertStatus(200);
    }

    /**
     * @testdox 回傳指令清單
     */
    public function testReturn200WhenReplySlashCommandComicPart1()
    {
        $token = config('services.slack.slash.secretary');
        if (empty($token)) {
            $this->markTestSkipped('none token');
        }
        $data = [
            'token' => $token,
            'team_id'=> '',
            'team_domain'=> '',
            'channel_id'=> '',
            'channel_name'=> '',
            'user_id'=> 'admin',
            'user_name'=> 'admin',
            'command'=> '',
            'text'=> '',
            'response_url'=> $this->responseUrl,
        ];

        $response = $this->post('/api/slack/slash-commands/comic', $data);

        $response->assertStatus(200);
    }

    /**
     * @testdox 回傳追蹤名單
     */
    public function testReturn200WhenReplySlashCommandComicPart2()
    {
        $token = config('services.slack.slash.secretary');
        if (empty($token)) {
            $this->markTestSkipped('none token');
        }
        $data = [
            'token' => $token,
            'team_id'=> '',
            'team_domain'=> '',
            'channel_id'=> '',
            'channel_name'=> '',
            'user_id'=> 'admin',
            'user_name'=> 'admin',
            'command'=> '',
            'text'=> 'list',
            'response_url'=> $this->responseUrl,
        ];

        $response = $this->post('/api/slack/slash-commands/comic', $data);

        $response->assertStatus(200);
    }

    /**
     * @testdox 新增追蹤名單
     */
    public function testReturn200WhenReplySlashCommandComicPart3()
    {
        $token = config('services.slack.slash.secretary');
        if (empty($token)) {
            $this->markTestSkipped('none token');
        }
        $data = [
            'token' => $token,
            'team_id'=> '',
            'team_domain'=> '',
            'channel_id'=> '',
            'channel_name'=> '',
            'user_id'=> 'admin',
            'user_name'=> 'admin',
            'command'=> '',
            'text'=> 'add 9527',
            'response_url'=> $this->responseUrl,
        ];

        $response = $this->post('/api/slack/slash-commands/comic', $data);

        $response->assertStatus(200);
    }

    /**
     * @testdox 刪除追蹤名單
     */
    public function testReturn200WhenReplySlashCommandComicPart4()
    {
        $token = config('services.slack.slash.secretary');
        if (empty($token)) {
            $this->markTestSkipped('none token');
        }
        $data = [
            'token' => $token,
            'team_id'=> '',
            'team_domain'=> '',
            'channel_id'=> '',
            'channel_name'=> '',
            'user_id'=> 'admin',
            'user_name'=> 'admin',
            'command'=> '',
            'text'=> 'delete testChannelId',
            'response_url'=> $this->responseUrl,
        ];

        $response = $this->post('/api/slack/slash-commands/comic', $data);

        $response->assertStatus(200);
    }

    /**
     * @testdox 刪除不存在的追蹤名單
     */
    public function testReturn200WhenReplySlashCommandComicPart5()
    {
        $token = config('services.slack.slash.secretary');
        if (empty($token)) {
            $this->markTestSkipped('none token');
        }
        $data = [
            'token' => $token,
            'team_id'=> '',
            'team_domain'=> '',
            'channel_id'=> '',
            'channel_name'=> '',
            'user_id'=> 'admin2',
            'user_name'=> 'admin2',
            'command'=> '',
            'text'=> 'delete unknownChannelId',
            'response_url'=> $this->responseUrl,
        ];

        $response = $this->post('/api/slack/slash-commands/comic', $data);

        $response->assertStatus(200);
    }
}
