<?php

namespace App\Service;

use App\Entity\TvShow;
use Symfony\Component\String\Slugger\SluggerInterface;

class Slugger
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     * Return the slug of a string
     *
     * @param string $stringToSlugify The string will be turned into a slug
     * @return string
     */
    public function slugify(string $stringToSlugify): string
    {
        // On utilise maintenant le Slugger du composant String de Symfony
        return strtolower($this->slugger->slug($stringToSlugify));
    }

    /**
     * Create a slug for a TvShow object
     *
     * @param TvShow $tvShow
     * @return void
     */
    public function slugifyTvShow(TvShow $tvShow)
    {
        $title = $tvShow->getTitle();
        $slug = $this->slugify($title);
        $tvShow->setSlug($slug);
    }
}