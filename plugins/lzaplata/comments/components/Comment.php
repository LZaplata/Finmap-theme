<?php namespace LZaplata\Comments\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use October\Rain\Support\Facades\Flash;
use October\Rain\Support\Facades\Input;
use Tailor\Models\EntryRecord;

/**
 * Comment Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class Comment extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Comment Component',
            'description' => 'No description provided yet...'
        ];
    }

    /**
     * @link https://docs.octobercms.com/3.x/element/inspector-types.html
     */
    public function defineProperties()
    {
        return [];
    }

    public function onAddFormSubmit()
    {
        $data = Request::validate([
            "name"      => "required",
            "email"     => "required|email",
            "comment"   => "required",
        ], [
            "name.required"     => "Vyplňte prosím jméno.",
            "email.required"    => "Vyplňte prosím e-mail.",
            "email.email"       => "Špatný formát e-mailu.",
            "comment.required"  => "Vyplňte prosím hodnocení.",
        ]);

        $comment = EntryRecord::inSection("Team\Comment");
        $comment->title = input("name");
        $comment->slug = str_slug(input("name"));
        $comment->content = input("comment");
        $comment->member_id = input("member_id");
        $comment->is_enabled = 0;
        $comment->save();

        Mail::sendTo("info@finmap.cz", "lzaplata.comments::mail.add-comment", Input::all());

        Flash::success("Hodnocení bylo úspěšně odeslano ke schválení.");

        return Redirect::refresh();
    }
}
