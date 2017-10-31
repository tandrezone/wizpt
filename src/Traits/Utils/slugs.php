<?php
namespace wizpt\cms\Traits\Utils;

trait slugs {
	/**
	 * Gets the slug.
	 *
	 * @param      string   $title       The title
	 * @param      integer  $iteraction  The iteraction number
	 *
	 * @return     <string>   The slug.
	 */
	public function getSlug($title, $iteraction = 1){
		if($iteraction == 1) {
			$sufix='';
		} else {
			$sufix = '-'.$iteraction;
		}
		$slug = str_slug($title.$sufix);
		$slugs = $this->modelClass::where('slug',$slug)->get();
		if($slugs->isEmpty()) {
			return $slug;
		} else {
			return $this->getSlug($title,++$iteraction);
		}
	}

	/**
	 * Update the slug
	 *
	 * @param      <string>  $slug   The slug
	 *
	 * @return     <string>  ( Slug validated )
	 */
	public function updateSlug($slug){
		$slugs = $this->modelClass::where('slug',$slug)
			->get();
		if($slugs->count() == 1) {
			return $slug;
		} else {
			return $this->getSlug($slug);
		}		
	}
}