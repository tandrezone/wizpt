<?php

namespace wizpt\cms\Traits\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use wizpt\cms\Models\Page;
use View;
use Session;
use App;
use wizpt\cms\Traits\Utils\slugs;

trait PageCtrl 
{
    /**
     * Use slugs trait for creating and validating slugs
     */
    use slugs;

    /**
     * Set var with the modelClass
     *
     * @var        <Model::Class>
     */
    public $modelClass = Page::class;

    /**
     * use middleware auth
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all pages
        $pages = Page::where('translate',0)
            ->get();

        //load the view and pass the pages
        return View::make('admin.pages.index')
            ->with('pages',$pages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $lang = Input::get('lang');
        if($lang == null ) {
            $lang = App::getLocale();
        }
        $id = Input::get('id');
        $pages = Page::all();
        if(!$pages->isEmpty()){
            $pages = $pages[0];
        }
        return View::make('admin.pages.create')
            ->with('pages',$pages)
            ->with('lang',$lang)
            ->with('id',$id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'title'         => 'required',
            'body'          => 'required',
            'description'   => 'required',
            'lang'          => 'required',
            'translate'     => 'numeric',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->route('pages.create');
                
        } else {
            // store
            $page = new Page;
            $page->title        = Input::get('title');
            $page->body         = Input::get('body');
            $page->slug         = $this->getSlug(Input::get('title'));
            $page->description  = Input::get('description');
            $page->keywords     = Input::get('keywords');
            $page->lang         = Input::get('lang');
            $page->translate    = Input::get('translate');
            $page->parent       = Input::get('parent');
            if(Input::get('active')){
                $page->active       = Input::get('active');
            }
            $page->save();

            // redirect
            Session::flash('message', 'Successfully created page!');
            return redirect()->route('pages.index');
        }       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get the page
        $page = Page::find($id);
        
        // show the view and pass the nerd to it
        return View::make('admin.pages.show')
            ->with('page', $page);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the page
        $page = Page::find($id);
        // show the edit form and pass the page
        return View::make('admin.pages.edit')
            ->with('page', $page);
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

        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'title'         => 'required',
            'body'          => 'required',
            'slug'          => 'required',
            'description'   => 'required',
            'lang'          => 'required',
            'translate'     => 'numeric',
            'active'        => 'boolean',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            //var_dump(Input::all());
            return redirect()->route('pages.edit',["id" => $id]);
                
        } else {
            // store
            $page = Page::find($id);
            
            $page->title        = Input::get('title');
            $page->body         = Input::get('body');
            $page->slug         = $this->updateSlug(Input::get('slug'));
            $page->description  = Input::get('description');
            $page->keywords     = Input::get('keywords');
            $page->lang         = Input::get('lang');
            $page->parent       = Input::get('parent');
            $page->translate    = Input::get('translate');
            if(Input::get('active')){
                $page->active       = Input::get('active');
            } else {
                $page->active       = 0;
            }
            $page->save();

            // redirect
            Session::flash('message', 'Successfully created page!');
            return redirect()->route('pages.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // delete
        $page = Page::find($id);
       
        $page->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the page!');
        return redirect()->route('pages.index');
    }
}


















