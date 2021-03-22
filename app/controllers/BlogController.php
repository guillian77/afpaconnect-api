<?php


namespace App\Controller;


use App\Model\PostsModel;

class BlogController extends Controller
{
    public function __construct()
    {
//        dump('Blog constructor');
    }

    public function index(PostsModel $postsModel)
    {
        $posts = $postsModel->findAll();

        $this->render("blog", [
            'posts' => $posts
        ]);
    }

    public function demo(): void
    {
        echo "demo";
    }
}
