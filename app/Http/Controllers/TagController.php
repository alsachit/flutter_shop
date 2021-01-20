<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    public function index() {
        $tags = Tag::paginate (env('PAGINATION_COUNT'));
        return view('admin.tags.tags')->with([
            'tags' => $tags,
            'showLinks' => true
        ]);
    }

    private function isTagNameExists($tagName){
        $tag = Tag::where('tag', '=' , $tagName)->first();
        if ($tag) {
            Session::flash('error', 'Tag ('. $tag->tag .') is already exists');
            return false;
        }
        return true;
    }

    public function store(Request $request) {
        $request->validate([
            'tag_name' => 'required'
        ]);

        $tagName = $request->input('tag_name');

        if (!$this->isTagNameExists($tagName)){
            return redirect()->back();
        }

        $tag = new Tag();
        $tag->tag = $tagName;
        $tag->save();

        return redirect()->back()->with('success', 'Tag '. $tag->tag . ' has been added successfully');
    }

    public function delete(Request $request) {
        $id = $request->input('tag_id');
        Tag::destroy($id);
        return redirect()->back()->with('success', 'Tag has been deleted successfully');
    }

    public function update(Request $request) {
        $request->validate([
            'tag_name' => 'required'
        ]);

        $tagName = $request->input('tag_name');

        if (!$this->isTagNameExists($tagName)) {
            return redirect()->back();
        }

        $tagID = $request->input('tag_id');
        $tag = Tag::find($tagID);
        $tag->tag = $request->input('tag_name');
        $tag->save();

        return redirect()->back()->with('success', 'Tag ' . $tag->tag . ' has been updated');

    }

    public function search(Request $request){
        $request->validate([
            'tag_search' => 'required'
        ]);

        $searchTerm = $request->input('tag_search');

        $tags = Tag::where('tag', 'LIKE', '%'. $searchTerm . '%')->get();

        if (count($tags) > 0) {
            return view('admin.tags.tags')->with([
                'tags' => $tags,
                'showLinks' => false
            ]);
        }
        return redirect()->back()->with('warning', 'Nothing found!');
    }

}
