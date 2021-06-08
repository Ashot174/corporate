<?php


namespace App\Repositories;

use App\Comment;


class CommentsRepository extends Repository
{
    public function __construct(Comment $comment){
        return $this->model = $comment;
    }

}
