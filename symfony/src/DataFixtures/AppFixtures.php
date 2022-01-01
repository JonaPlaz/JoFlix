<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Character;
use App\Entity\Episode;
use App\Entity\Season;
use App\Entity\TvShow;
use App\Entity\User;
use App\Service\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use PointPlus\FakerCinema\Provider\Character as FakerCharacter;
use PointPlus\FakerCinema\Provider\Movie;
use PointPlus\FakerCinema\Provider\TvShow as FakerTvShow;
use PointPlus\FakerCinema\Provider\Person;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    // here i use FakerPhp
    $faker = Factory::create();

    // here i user classes of PointPlus faker-cinema-providers
    $faker->addProvider(new FakerCharacter($faker));
    $faker->addProvider(new Movie($faker));
    $faker->addProvider(new FakerTvShow($faker));
    $faker->addProvider(new Person($faker));


    $categories = [];

    // 7 categories created in DB
    for ($i = 0; $i < 7; $i++) {
      $category = new Category;
      $category->setName($faker->unique()->movieGenre());
      $manager->persist($category);

      $categories[] = $category;
    }

    $characters = [];

    // 50 characters created in DB
    for ($i = 0; $i < 150; $i++) {
      $character = new Character();
      $character->setFirstname($faker->firstNameMale());
      $character->setLastname($faker->unique()->lastName());
      $character->setActor($faker->unique()->actor());
      $character->setGender($faker->randomElement(['Homme', 'Femme']));
      $character->setBio($faker->sentence(5));
      $character->setAge(mt_rand(4, 80));
      $manager->persist($character);

      $characters[] = $character;
    }

    // 25 male characters created in DB
    for ($i = 0; $i < 25; $i++) {
      $character = new Character();
      $character->setFirstname($faker->firstNameMale());
      $character->setLastname($faker->unique()->lastName());
      $character->setGender('Homme');
      $character->setAge(mt_rand(4, 80));
      $manager->persist($character);
    }

    // TvShow tvshows created in DB
    for ($i = 0; $i < 10; $i++) {
      $tvShow = new TvShow();
      $tvShow->setTitle($faker->unique()->tvShow());
      $tvShow->setSynopsis($faker->unique()->overview());
      $tvShow->setImage($faker->imageUrl(640, 480, 'Tv Show', true));
      $tvShow->setNbLikes(mt_rand(0, 400000));
      $tvShow->setPublishedAt(new \DateTimeImmutable());
      $tvShow->setCreatedAt(new \DateTimeImmutable());
      $tvShow->setUpdatedAt(new \DateTimeImmutable());
      $tvShow->setSlug($faker->slugifyTvShow($tvShow));
      $tvShow->addCharacter($faker->randomElement($characters));
      $tvShow->addCharacter($faker->randomElement($characters));
      $tvShow->addCharacter($faker->randomElement($characters));
      $tvShow->addCategory($faker->randomElement($categories));
      $tvShow->addCategory($faker->randomElement($categories));

      // seasons by tvshow created in DB
      $seasonOne = new Season();
      $seasonOne->setSeasonNumber(1);
      $seasonOne->setPublishedAt(new \DateTimeImmutable());
      $seasonOne->setCreatedAt(new \DateTimeImmutable());
      $tvShow->addSeason($seasonOne);

      // episodes by season created in DB
      $episodeOne = new Episode();
      $episodeOne->setEpisodeNumber(1);
      $episodeOne->setTitle($faker->words(5, true));
      $episodeOne->setPublishedAt(new \DateTimeImmutable());
      $episodeOne->setCreatedAt(new \DateTimeImmutable());
      $episodeOne->setUpdatedAt(new \DateTimeImmutable());
      $seasonOne->addEpisode($episodeOne);
      $manager->persist($episodeOne);

      $episodeTwo = new Episode();
      $episodeTwo->setEpisodeNumber(2);
      $episodeTwo->setTitle($faker->words(5, true));
      $episodeTwo->setPublishedAt(new \DateTimeImmutable());
      $episodeTwo->setCreatedAt(new \DateTimeImmutable());
      $episodeTwo->setUpdatedAt(new \DateTimeImmutable());
      $seasonOne->addEpisode($episodeTwo);
      $manager->persist($episodeTwo);

      $episodeThree = new Episode();
      $episodeThree->setEpisodeNumber(3);
      $episodeThree->setTitle($faker->words(5, true));
      $episodeThree->setPublishedAt(new \DateTimeImmutable());
      $episodeThree->setCreatedAt(new \DateTimeImmutable());
      $episodeThree->setUpdatedAt(new \DateTimeImmutable());
      $seasonOne->addEpisode($episodeThree);
      $manager->persist($episodeThree);

      $episodeFour = new Episode();
      $episodeFour->setEpisodeNumber(4);
      $episodeFour->setTitle($faker->words(5, true));
      $episodeFour->setPublishedAt(new \DateTimeImmutable());
      $episodeFour->setCreatedAt(new \DateTimeImmutable());
      $episodeFour->setUpdatedAt(new \DateTimeImmutable());
      $seasonOne->addEpisode($episodeFour);
      $manager->persist($episodeFour);
      $manager->persist($seasonOne);


      $seasonTwo = new Season();
      $seasonTwo->setSeasonNumber(2);
      $seasonTwo->setPublishedAt(new \DateTimeImmutable());
      $seasonTwo->setCreatedAt(new \DateTimeImmutable());
      $tvShow->addSeason($seasonTwo);

      // episodes by season created in DB
      $episodeOne = new Episode();
      $episodeOne->setEpisodeNumber(1);
      $episodeOne->setTitle($faker->words(5, true));
      $episodeOne->setPublishedAt(new \DateTimeImmutable());
      $episodeOne->setCreatedAt(new \DateTimeImmutable());
      $episodeOne->setUpdatedAt(new \DateTimeImmutable());
      $seasonTwo->addEpisode($episodeOne);
      $manager->persist($episodeOne);

      $episodeTwo = new Episode();
      $episodeTwo->setEpisodeNumber(2);
      $episodeTwo->setTitle($faker->words(5, true));
      $episodeTwo->setPublishedAt(new \DateTimeImmutable());
      $episodeTwo->setCreatedAt(new \DateTimeImmutable());
      $episodeTwo->setUpdatedAt(new \DateTimeImmutable());
      $seasonTwo->addEpisode($episodeTwo);
      $manager->persist($episodeTwo);

      $episodeThree = new Episode();
      $episodeThree->setEpisodeNumber(3);
      $episodeThree->setTitle($faker->words(5, true));
      $episodeThree->setPublishedAt(new \DateTimeImmutable());
      $episodeThree->setCreatedAt(new \DateTimeImmutable());
      $episodeThree->setUpdatedAt(new \DateTimeImmutable());
      $seasonTwo->addEpisode($episodeThree);
      $manager->persist($episodeThree);

      $episodeFour = new Episode();
      $episodeFour->setEpisodeNumber(4);
      $episodeFour->setTitle($faker->words(5, true));
      $episodeFour->setPublishedAt(new \DateTimeImmutable());
      $episodeFour->setCreatedAt(new \DateTimeImmutable());
      $episodeFour->setUpdatedAt(new \DateTimeImmutable());
      $seasonTwo->addEpisode($episodeFour);
      $manager->persist($episodeFour);
      $manager->persist($seasonTwo);


      $seasonThree = new Season();
      $seasonThree->setSeasonNumber(3);
      $seasonThree->setPublishedAt(new \DateTimeImmutable());
      $seasonThree->setCreatedAt(new \DateTimeImmutable());
      $tvShow->addSeason($seasonThree);

      // episodes by season created in DB
      $episodeOne = new Episode();
      $episodeOne->setEpisodeNumber(1);
      $episodeOne->setTitle($faker->words(5, true));
      $episodeOne->setPublishedAt(new \DateTimeImmutable());
      $episodeOne->setCreatedAt(new \DateTimeImmutable());
      $episodeOne->setUpdatedAt(new \DateTimeImmutable());
      $seasonThree->addEpisode($episodeOne);
      $manager->persist($episodeOne);

      $episodeTwo = new Episode();
      $episodeTwo->setEpisodeNumber(2);
      $episodeTwo->setTitle($faker->words(5, true));
      $episodeTwo->setPublishedAt(new \DateTimeImmutable());
      $episodeTwo->setCreatedAt(new \DateTimeImmutable());
      $episodeTwo->setUpdatedAt(new \DateTimeImmutable());
      $seasonThree->addEpisode($episodeTwo);
      $manager->persist($episodeTwo);

      $episodeThree = new Episode();
      $episodeThree->setEpisodeNumber(3);
      $episodeThree->setTitle($faker->words(5, true));
      $episodeThree->setPublishedAt(new \DateTimeImmutable());
      $episodeThree->setCreatedAt(new \DateTimeImmutable());
      $episodeThree->setUpdatedAt(new \DateTimeImmutable());
      $seasonThree->addEpisode($episodeThree);
      $manager->persist($episodeThree);

      $episodeFour = new Episode();
      $episodeFour->setEpisodeNumber(4);
      $episodeFour->setTitle($faker->words(5, true));
      $episodeFour->setPublishedAt(new \DateTimeImmutable());
      $episodeFour->setCreatedAt(new \DateTimeImmutable());
      $episodeFour->setUpdatedAt(new \DateTimeImmutable());
      $seasonThree->addEpisode($episodeFour);
      $manager->persist($episodeFour);
      $manager->persist($seasonThree);

      $manager->persist($tvShow);
    }

    // 12 TvShow movies created in DB
    for ($i = 0; $i < 12; $i++) {
      $tvShow = new TvShow();
      $tvShow->setTitle($faker->unique()->movie());
      $tvShow->setSynopsis($faker->unique()->overview());
      $tvShow->setImage($faker->imageUrl(640, 480, 'Movie', true));
      $tvShow->setNbLikes(mt_rand(0, 400000));
      $tvShow->setPublishedAt(new \DateTimeImmutable());
      $tvShow->setCreatedAt(new \DateTimeImmutable());
      $tvShow->setUpdatedAt(new \DateTimeImmutable());

      // 1 season created in DB because it's a movie
      $season = new Season();
      $season->setSeasonNumber(1);
      $season->setPublishedAt(new \DateTimeImmutable());
      $season->setCreatedAt(new \DateTimeImmutable());
      $tvShow->addSeason($season);

      // 1 episode created in DB because it's a movie
      $episode = new Episode();
      $episode->setEpisodeNumber(1);
      $episode->setTitle($tvShow->getTitle());
      $episode->setPublishedAt(new \DateTimeImmutable());
      $episode->setCreatedAt(new \DateTimeImmutable());
      $episode->setUpdatedAt(new \DateTimeImmutable());

      $tvShow->addSeason($season);
      $tvShow->addCharacter($faker->unique()->randomElement($characters));
      $tvShow->addCharacter($faker->randomElement($characters));
      $tvShow->addCharacter($faker->randomElement($characters));
      $tvShow->addCharacter($faker->randomElement($characters));
      $tvShow->addCategory($faker->randomElement($categories));
      $tvShow->addCategory($faker->randomElement($categories));
      $tvShow->addCategory($faker->randomElement($categories));
      $tvShow->addCategory($faker->randomElement($categories));
      $season->addEpisode($episode);

      $manager->persist($tvShow);
      $manager->persist($season);
      $manager->persist($episode);
    }

    $manager->flush();
  }
}
