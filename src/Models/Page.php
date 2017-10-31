<?php

namespace wizpt\cms\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function haveTranslated($lang, $id) {
    	$page = $this::where("translate",$id)
    		->where('lang',$lang)
    		->get();
    	if($page->isEmpty()){
    		return false;
    	} else {
    		return true;
    	}
    }

    public function getTranslatedId($lang, $id) {
    	$page = $this::where('translate',$id)
    		->where('lang', $lang)
    		->get();
    	if($page->isEmpty()){
    		return false;
    	} else {
    		return $page[0]->id;
    	}
    }
    
    public function getOriginalPages(){
        $pagesOriginal = $this::where('translate',0)
        ->get();
        return $pagesOriginal;
    }

    public function getParent($parent_id) { 
        $parent = $this::where("id",$parent_id)
            ->get();
        return $parent;
    }

    public function getChildren($id) {
        $children = $this::where("parent",$id)
            ->get();
        return $children;
    }
}
