<?php namespace LZaplata\BrokerTrust\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Http;

/**
 * Blog Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class Posts extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Posts',
            'description' => 'List of posts'
        ];
    }

    /**
     * @link https://docs.octobercms.com/3.x/element/inspector-types.html
     */
    public function defineProperties()
    {
        return [];
    }

    public function posts()
    {
//        $taxonomies = Http::get("https://brokertrust.cz/wp-json/wp/v2/categories");
//
//        dump($taxonomies->json());
//
//        foreach ($taxonomies->json() as $category) {
//            dump($category["name"]);
//        }

        $postsPerPage = 4;
        $page = 1;
        $fields = "title,excerpt,link,featured_media,categories=5,_links";
        $embed = "wp:featuredmedia,wp:term";

        $response = Http::get("https://brokertrust.cz/wp-json/wp/v2/posts?per_page=" . $postsPerPage . "&page=" . $page . "&_fields=" . $fields . "&_embed=" . $embed);

        if ($response->ok()) {
            return $response->json();
        }
    }
}
