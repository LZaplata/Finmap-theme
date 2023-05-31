<?php namespace LZaplata\BrokerTrust\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use RainLab\Blog\Models\Category;
use RainLab\Blog\Models\Post;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use System\Models\File;

/**
 * ImportPosts Command
 *
 * @link https://docs.octobercms.com/3.x/extend/console-commands.html
 */
class ImportPosts extends Command
{
    /**
     * @var string name is the console command name
     */
    protected $name = 'brokertrust:importposts';

    /**
     * @var string description is the console command description
     */
    protected $description = 'Import BrokerTrust posts.';

    /**
     * handle executes the console command
     */
    public function handle()
    {
        $postsPerPage = 4;
        $page = 1;
        $fields = "title,slug,content,excerpt,link,featured_media,categories,_links,date,modified";
        $embed = "wp:featuredmedia,wp:term";
        $today = new \DateTime();

        $response = Http::get("https://brokertrust.cz/wp-json/wp/v2/posts?per_page=" . $postsPerPage . "&page=" . $page . "&_fields=" . $fields . "&_embed=" . $embed . "&after=" . $today->format("Y-m-d") . "T00:00:00");

        if ($response->ok()) {
            foreach ($response->json() as $responsePost) {
                $existingPost = Post::where("slug", $responsePost["slug"])->first();

                $post = $existingPost ?: Post::make();
                $post->title = html_entity_decode($responsePost["title"]["rendered"]);
                $post->slug = html_entity_decode($responsePost["slug"]);
                $post->content = html_entity_decode($responsePost["content"]["rendered"]);
                $post->excerpt = html_entity_decode(strip_tags($responsePost["excerpt"]["rendered"]));
                $post->forceSave();

                $image = $responsePost["_embedded"]["wp:featuredmedia"][0];

                $existingFile = File::where("title", $image["title"]["rendered"])->first();

                $file = $existingFile ?: File::make();
                $file->fromUrl($image["source_url"]);
                $file->field = "featured_images";
                $file->attachment_id = $post->id;
                $file->attachment_type = "RainLab\Blog\Models\Post";
                $file->title = $image["title"]["rendered"];
                $file->description = $image["alt_text"];
                $file->save();

                $categories = $responsePost["_embedded"]["wp:term"][0];
                $postCategories = $post->categories()->allRelatedIds();

                foreach ($categories as $responseCategory) {
                    if ($responseCategory["taxonomy"] == "category") {
                        $existingCategory = Category::where("slug", $responseCategory["slug"])->first();

                        $category = $existingCategory ?: Category::make();
                        $category->name = $responseCategory["name"];
                        $category->slug = $responseCategory["slug"];
                        $category->forceSave();

                        $postCategories[] = $category->id;
                    }
                }

                $post->categories()->sync($postCategories, false);
            }
        }
    }

    /**
     * getArguments get the console command arguments
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * getOptions get the console command options
     */
    protected function getOptions()
    {
        return [];
    }
}
