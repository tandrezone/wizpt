<?php

namespace wizpt\cms\Traits\Admin;

use Illuminate\Http\Request;
use Storage;
use Carbon\Carbon;
/**
 * Controller of the server side functions needed by the tinymce
 */
trait tinymce
{
    /**
     * Only Can access this authenticated
     */
	public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Uploads files.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     <string>                    ( The file path )
     */
    public function upload(Request $request){
    	$date = new Carbon();
    	$year = $date->year;
    	$month = $date->month;

        $file = request()->file('file');
        $path = $file->store('media/'.$year."/".$month);

        echo Storage::url($path);
    }
}
