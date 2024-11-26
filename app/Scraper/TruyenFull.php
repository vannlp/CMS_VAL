<?php

namespace App\Scraper;

use App\Models\StoryChapter;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Str;


class TruyenFull
{
    protected $story_id = 6;
    
    public function scrape()
    {
        $urlfirst = 'https://truyenfull.tv/vu-dong-can-khon/chuong-1139.html';
        $client = new Client();
        $is_next_chap = true;
        
        while($is_next_chap) {
            $url = $urlfirst;
            $crawler = $client->request('GET', $url);
            $array = $this->handleHTML($crawler, $url);
            StoryChapter::create($array);
            
            if($array['next_chap']  == 'javascript:void(0)') {
                $is_next_chap = false;
            }
            
            $urlfirst = $array['next_chap'];
        }
    }
    
    public function handleHTML($crawler, $url) {
        $array  = [
            'title' => '',
            'story_id' => $this->story_id,
            'meta_description' => '',
            'description' => '',
            'slug' => '',
            'status' => 1
        ];
        
        $next_chap = $crawler->filter('#next_chap')->first();
        $content = $crawler->filter('#chapter-c')->first();
        $title = $crawler->filter('.chapter-title')->first();
        $meta_description = "Bạn đang đọc truyện tại";
        
        if($next_chap == null) {
            $array['next_chap'] = 'javascript:void(0)';
            return $array;
        }
        $array['next_chap'] = $next_chap->attr('href');
        $array['description'] = $content->html();
        $array['title'] = $title->text();
        if (preg_match('/(\d+:\s.+)/', $array['title'], $matches)) {
            $array['title'] = $matches[1];
        }
        $array['meta_description'] = $meta_description;
        $array['slug'] = Str::afterLast(rtrim($url, '/'), '/');
        return $array ;
    }
}
