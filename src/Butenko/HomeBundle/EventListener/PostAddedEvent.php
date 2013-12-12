<?php
/**
 * Created by PhpStorm.
 * User: kanni
 * Date: 12/12/13
 * Time: 1:49 PM
 */

namespace Butenko\HomeBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Butenko\HomeBundle\Entity\Post;


class PostAddedEvent extends Event
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }
} 