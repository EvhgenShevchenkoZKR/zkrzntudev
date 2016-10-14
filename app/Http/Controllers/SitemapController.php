<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Watson\Sitemap\Facades\Sitemap;
use App\News;
use App\Menu;
use App\Advert;
use App\ChildPage;
use App\Tag;

use App\Http\Requests;

class SitemapController extends Controller
{
    public function index()
    {
        $baseUrl = \URL::to('/');;

        Sitemap::addTag("$baseUrl", '', 'daily','1');

        $menus = Menu::select('*')
            ->where('published', true)
            ->where('url', '<>', '')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($menus as $menu) {
            Sitemap::addTag("$baseUrl/$menu->url", $menu->updated_at, 'monthly','0.9');
        }

        //news
        $material = $this->selectData('News','news');
        $rresult = $this->cycleGet($material,$baseUrl, 'weekly', 0.7);

        //objavas
        $material = $this->selectData('Advert','objava');
        $rresult2 = $this->cycleGet($material,$baseUrl, 'weekly', 0.8);

        //children
        $material = $this->selectData('ChildPage','child');
        $rresult3 = $this->cycleGet($material,$baseUrl, 'weekly', 0.7);

        //tags
        $material = Tag::select('*')
            ->orderBy('created_at', 'desc')
            ->get();
        $material->url = 'tag';

        $rresult4 = $this->cycleGet($material,$baseUrl, 'weekly', 0.7);

        $rresult = array_merge($rresult, $rresult2, $rresult3, $rresult4);

        foreach ($rresult as $res) {
            $url = $res['url'];
            $updated = $res['updated'];
            $freq = $res['freq'];
            $priority = $res['priority'];
            Sitemap::addTag("$url", $updated, $freq, $priority);
        }

        // Return the sitemap to the client.
        return Sitemap::render();
    }

    public function feed(){
        // create new feed
        $feed = \App::make("feed");

        // check if there is cached feed and build new only if is not
        if (!$feed->isCached())
        {
            //news
            $news = $this->selectData('News','news');

            //objavas
            $objavas = $this->selectData('Advert','objava');

            //children
            $children = $this->selectData('ChildPage','child');

            // set your feed's title, description, link, pubdate and language
            $feed->title = 'Your title';
            $feed->description = 'Your description';
            $feed->link = url('feed');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            $feed->pubdate = $news[0]->created_at;
            $feed->lang = 'en';
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(100); // maximum length of description text

            foreach ($news as $post) {
                // set item's title, author, url, pubdate, description, content, enclosure (optional)*
                $feed->add($post->title, $post->author_name, \URL::to($post->slug), $post->created_at, $post->meta_description, $post->body);
            }

            foreach ($objavas as $post) {
                $feed->add($post->title, 'ЗКР ЗНТУ', \URL::to($post->slug), $post->created_at, $post->meta_description, $post->body);
            }

            foreach ($children as $post) {
                $feed->add($post->title, 'ЗКР ЗНТУ', \URL::to($post->slug), $post->created_at, $post->meta_description, $post->body);
            }

        }
        return $feed->render('atom');
    }

    private function selectData($className, $url){
        $class = "\\App\\$className";
        $data = $class::select('*')
            ->where('published', true)
            ->orderBy('created_at', 'desc')
            ->get();
        $result = $data;
        $result->url = $url;

        return $result;
    }

    private function cycleGet($material,$baseUrl, $freq, $priority){
        $result = [];
        foreach ($material as $k => $mat) {
            $result[$k]['url'] = "$baseUrl/$material->url/$mat->slug";
            $result[$k]['updated'] = $mat->updated_at;
            $result[$k]['freq'] = $freq;
            $result[$k]['priority'] = $priority;
        }
        return $result;
    }
}
