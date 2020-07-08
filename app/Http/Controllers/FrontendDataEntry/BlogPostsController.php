<?php

namespace App\Http\Controllers\FrontendDataEntry;

use App\AliasPost;
use App\BlogPost;
use App\ListBlog;
use DB;
use Illuminate\Http\Request;

//use App\Http\Requests;
use App\Http\Controllers\Controller;

class BlogPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogpost = BlogPost::with('list_blog')->paginate(25);
        /*echo '<pre>';
        dump($blogpost[0]->list_blog->status);
        echo '</pre>';*/

        return view('admin.frontend_data_entry.blog_posts', ['blogs' => $blogpost]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.frontend_data_entry.create_blog');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $where = $request->only('title', 'name', 'meta_description', 'keywords', 'content', 'user_id');
        BlogPost::firstOrCreate($where);
        $IdBlog = DB::table('blog_posts')
            ->select('id')
            ->where($where)
            ->get();
        $entryArr['id'] = $IdBlog[0]->id;
        $entryArr = $request->only('name', 'status', 'image', 'filepath_0');
        $entryArr['id'] = $IdBlog[0]->id;
        mb_strlen($entryArr['filepath_0']) > 0 ? $entryArr['image'] = null : $entryArr['image'] = $entryArr['filepath_0'];
        unset($entryArr['filepath_0']);
        ListBlog::create($entryArr);
        $aliasCreate = $request->only('alias');
        $aliasCreate['id'] = $entryArr['id'];
        AliasPost::create($aliasCreate);
        return back()->with('message','Post created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blogPost = BlogPost::find($id);
        $listBlog = ListBlog::where('id', $id)->get();
        $aliasBlog = AliasPost::find($id);

        return view('admin.frontend_data_entry.edit_blog', ['blogPost' => $blogPost, 'listBlog' => $listBlog, 'alias' => $aliasBlog]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $blogPost = BlogPost::find($id);
        $blogPost->update($request->only('title', 'name', 'meta_description', 'keywords', 'content', 'user_id'));
        $blogPost->save();
        $where = $request->only('name', 'status', 'image');
        if(empty($where['image'])) $where['image'] = null;
        $listBlog = ListBlog::where('id', $id)->update($where);
        $alias = AliasPost::find($id);
        $alias->update($request->only('alias'));
        $alias->save;

        return back()->with('message', 'Post update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blogPost = BlogPost::destroy($id);
        return 'Remove';
    }
}
