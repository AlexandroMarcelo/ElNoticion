<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    private function petition($params)
    {
        $ch = curl_init(sprintf('%s?access_key=%s&%s', env("MEDIA_STACK_API_URL", ""), env("MEDIA_STACK_API_KEY", ""), $params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);

        curl_close($ch);

        $apiResult = json_decode($json, true);

        return $apiResult;
    }
    public function index()
    {
        $news_data = News::all()->sortByDesc('published_at');
        return view('news', ['news' => $news_data]);
    }
    public function fetchNews()
    {
        $queryString = http_build_query([
            'languages' => 'es,en',
            'countries' => 'mx,us,cn,jp,gb,ca,fr,de',
            'sort' => 'published_desc',
            'limit' => 100
        ]);
        /* Fetch data with params*/
        $news_data = $this->petition($queryString);
        
        /* Store the petition with the news in DB */
        foreach ($news_data["data"] as $news) {
            list($date, $time) = explode("T", $news["published_at"]);
            $splited_time = explode("+", $time);
            $news["published_at"] = $date . " " . $splited_time[0];
            $news = News::firstOrCreate(
                ['url' => $news["url"]],
                $news
            );
        };
        return redirect()->route('news');
    }
}


    //  $news_data = [
    //     "pagination" => [
    //         "limit" => 100,
    //         "offset" => 0,
    //         "count" => 100,
    //         "total" => 10000
    //     ],
    //     "data" => [
    //         0 => [
    //             "author" => "Lily Rosen Marvin, News Reporter",
    //             "title" => "Collective provides support for Latina entrepreneurs in Iowa City",
    //             "description" => "Marlén Mendoza said the idea to start a collective to support Latina entrepreneurs began with a cup of coffee. When she moved back to Iowa City in 2019, Mendoza",
    //             "url" => "ssss",
    //             "source" => "dailyiowan",
    //             "image" => null,
    //             "category" => "general",
    //             "language" => "en",
    //             "country" => "us",
    //             "published_at" => "2021-03-16T03:29:51+00:00"
    //         ],
    //         1 => [
    //             "author" => "Jenna Frisby",
    //             "title" => "Grammy’s recap: Fashionable masks and the winners of the big night",
    //             "description" => "By Jenna Frisby &#124; Social Media Editor The Grammys are one of the most anticipated award ceremonies of the year, honoring the music industry&#8217;s biggest ▶",
    //             "url" => "https://baylorlariat.com/2021/03/15/grammys-recap-fashionable-masks-and-the-winners-of-the-big-night/",
    //             "source" => "baylorlariat",
    //             "image" => "https://baylorlariat.com/wp-content/uploads/2021/03/aptopix-63rd-annual-grammy-awards-640x443.jpg",
    //             "category" => "general",
    //             "language" => "en",
    //             "country" => "us",
    //             "published_at" => "2021-03-16T03:29:36+00:00"
    //         ],
    //         2 => [
    //             "author" => "MATTHEW RENDA",
    //             "title" => "Judge Rules Google Must Face Incognito Mode Privacy Suit",
    //             "description" => "A federal judge in California ruled Google must face privacy violation claims alleging the company tracked web browsing after users opted to use the company’s p ▶",
    //             "url" => "https://www.courthousenews.com/judge-rules-google-must-face-incognito-mode-privacy-suit/",
    //             "source" => "courthousenews",
    //             "image" => null,
    //             "category" => "general",
    //             "language" => "en",
    //             "country" => "us",
    //             "published_at" => "2021-03-16T03:29:30+00:00"
    //         ],
    //         3 => [
    //             "author" => "JC Torres",
    //             "title" => "GTA Online will finally load faster thanks to a player",
    //             "description" => "People might have some stereotypes and preconceived notions of how game developers look and work but, as with any such concepts, reality is far different and so ▶",
    //             "url" => "https://www.slashgear.com/gta-online-will-finally-load-faster-thanks-to-a-player-15663819/",
    //             "source" => "slashgear",
    //             "image" => null,
    //             "category" => "general",
    //             "language" => "en",
    //             "country" => "us",
    //             "published_at" => "2021-03-16T03:29:29+00:00"
    //         ]
    //     ]
    // ];