<?php

namespace App\Scraper;

use App\Models\StoryChapter;
use App\Models\StoryPost;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Str;

class TruyenFull
{
    protected $story_id = 6;
    protected $chapter_num = 0;

    public function scrape($story_id, $chapter_num, $start_chapter, $stop_chapter = null)
    {
        $this->story_id = $story_id;
        $this->chapter_num = $chapter_num;

        $urlfirst = $start_chapter;

        $client = new Client();
        $client->setServerParameters([
            'HTTP_USER_AGENT' => $this->generateRandomUserAgent(),
            'HTTP_X_FORWARDED_FOR' => $this->generateRandomIP(),
            'HTTP_CLIENT_IP' => $this->generateRandomIP(),
        ]);
        $is_next_chap = true;
        $story = StoryPost::find($this->story_id);

        while ($is_next_chap) {
            $url = $urlfirst;
            
            try {
                $crawler = $client->request('GET', $url, [], [], [
                    'HTTP_X_FORWARDED_FOR' => $this->generateRandomIP(),
                    'HTTP_CLIENT_IP' => $this->generateRandomIP()
                ]);
            } catch (\Exception $e) {
                // Log lỗi hoặc dừng việc crawl nếu cần
                echo "Error accessing $url: " . $e->getMessage();
                break;
            }

            $array = $this->handleHTML($crawler, $url, $story);

            try {
                StoryChapter::create($array);
            } catch (\Exception $e) {
                echo "Error saving chapter: " . $e->getMessage();
                break;
            }

            $this->chapter_num++;

            if (isset($stop_chapter) && $this->chapter_num >= $stop_chapter) {
                $is_next_chap = false;
            }

            if ($array['next_chap'] == 'javascript:void(0)') {
                $is_next_chap = false;
            }

            $urlfirst = $array['next_chap'];
        }
    }

    public function handleHTML($crawler, $url, $story)
    {
        $array = [
            'title' => '',
            'story_id' => $this->story_id,
            'meta_description' => '',
            'description' => '',
            'slug' => '',
            'status' => 1,
            'chapter_num' => $this->chapter_num
        ];

        $next_chap = $crawler->filter('#next_chap')->first();
        $content = $crawler->filter('#chapter-c')->first();
        $title = $crawler->filter('.chapter-title')->first();
        $array['title'] = $title->text();

        if (preg_match('/(\d+:\s.+)/', $array['title'], $matches)) {
            $array['title'] = "Chương {$matches[1]}";
        }

        $meta_description = "Bạn đang đọc truyện {$story->title} chapter {$this->chapter_num}: {$array['title']}";

        if ($next_chap == null) {
            $array['next_chap'] = 'javascript:void(0)';
            return $array;
        }
        
        $array['next_chap'] = $next_chap->attr('href');
        $array['description'] = $content->html();

        $array['meta_description'] = $meta_description;
        $array['slug'] = Str::afterLast(rtrim($url, '/'), '/');
        
        return $array;
    }

    public function generateRandomIP()
    {
        return rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(1, 255);
    }

    public function generateRandomUserAgent()
    {
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (iPad; CPU OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Mobile/15E148 Safari/604.1'
        ];

        return $userAgents[array_rand($userAgents)];
    }
}
