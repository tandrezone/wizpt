<?php
namespace wizpt\cms\Traits\Utils;

use Session;
use Illuminate\Support\Facades\Input;

trait translatable {

    public $translating_id;
    /**
     * Gets the translation.
     *
     * @param      <string>  $lang   The language
     *
     * @return     <Collection>  The Translation.
     */
	private function getTrans($lang) {

        $translated = $this->modelClass::where('active',1)
            ->where('lang',$lang)
            ->where(function($query){
                $query->where('translate',$this->translating_id)
                    ->orWhere('id',$this->translating_id);
            })
            ->get();  
        return $translated;
        
    }

    /**
     * Determines if it has language.
     *
     * @param      <string>   $lang   The language
     *
     * @return     boolean  True if has translated, False otherwise.
     */
    public function hasLang($lang){
        $translated = $this->getTrans($lang);
        if($translated->isEmpty()) {
            return false;
        } else {
            return true;
        }       
    }

    /**
     * Gets the path.
     *
     * @param      <string>   $lang   The language
     *
     * @return     string  The path.
     */
    public function getPath($lang){
        $translated = $this->getTrans($lang);

        if($translated->isEmpty()) {
            return false;
        } else {
            return $translated[0]->slug."?lang=".$lang;
        }
    }

    public function changeLang($slug) {
        if(Input::get('lang')) {
            Session::put("locale",Input::get('lang'));
            return redirect("/".$slug);
        }
        return false;
    }
    /**
     * Get the resource
     *
     * @param      <string>  $slug   The slug
     *
     * @return     <collection>  ( The resourse or 404 if don't exist )
     */
    public function get($slug) {

	    $translated = $this->modelClass::where('slug',$slug)
			->where('active',1)
			->where('lang',Session::get('locale'))
			->get();

		if(!$translated->isEmpty()){
            if($translated[0]->translate == 0){
                $this->translating_id = $translated[0]->id;
            } else {
                $this->translating_id = $translated[0]->translate;
            }

    	} else {
    		return abort('404');
    	}
		return $translated;
    }
}