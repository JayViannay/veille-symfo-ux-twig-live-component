<?php

namespace App\Components;

use App\Repository\BlogRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('blogpost_search')]
class BlogpostSearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(private BlogRepository $blogRepository) {}

    public function getBlogposts(): array
    {
        return $this->blogRepository->findByQuery($this->query);
    }
}