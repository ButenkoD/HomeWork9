<?php
/**
 * Created by PhpStorm.
 * User: kanni
 * Date: 12/4/13
 * Time: 6:59 PM
 */

namespace Butenko\HomeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Butenko\HomeBundle\Entity\Post;
use Symfony\Component\Yaml\Yaml;

class LoadPostData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $posts = Yaml::parse($this->getPostFile());

        foreach($posts['posts'] as $post){
            $postObject = new Post();
            $postObject->setName($post['name'])
                ->setEmail($post['email'])
                ->setBody($post['body']);
            $manager->persist($postObject);
        }

        $manager->flush();
    }

    public function getPostFile()
    {
        return __DIR__.'/../data/post.yml';
    }

} 