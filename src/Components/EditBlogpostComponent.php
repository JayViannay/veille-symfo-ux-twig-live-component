<?php

namespace App\Components;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

#[AsLiveComponent('edit_blogpost')]
final class EditBlogpostComponent extends AbstractController {
    
    use DefaultActionTrait;

    use ValidatableComponentTrait;

    #[LiveProp(exposed: ['title', 'content'])]
    #[Assert\Valid]
    public Blog $blogpost;

    public bool $isSaved = false;

    #[LiveAction]
    public function save(EntityManagerInterface $em) {
        $this->validate();

        $this->isSaved = true;
        $em->flush();
    }
}