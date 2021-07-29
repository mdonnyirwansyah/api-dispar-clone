<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->editor_id) {
            $editor = $this->editor->name;
        } else {
            $editor = null;
        }

        return [
            'title' => $this->title,
            'titele_en' => $this->title_en,
            'category' => $this->newsCategory->name,
            'content' => $this->content,
            'content_en' =>$this->content_en,
            'author' => $this->author->name,
            'editor' => $editor,
            'thumbnail' => $this->thumbnail,
            'source' => $this->source,
            'tags' => $this->tags()->select('name', 'slug')->get(),
            'published_at' => $this->published_at,
            'viewer' => $this->viewer,
            'slug' => $this->slug
        ];
    }
}
