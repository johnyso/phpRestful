<?php

class NewsController extends AbstractController
{
    /**
     * News file.
     *
     * @var variable type
     */
    protected $articles_file = './data/news.txt';

    /**
     * resources for manual alignment.
     *
     * @var variable type
     */
    protected $left = "left";
    protected $right = "right";
    protected $up = "up";
    protected $down = "down";

    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */
    public function get($request)
    {
        $articles = $this->readArticles();
        $count = count($request->elements)-1;
        switch (count($request->elements[0])) {
            case 1:
                return $articles;
            break;
            case 2:
                $article_id = $request->elements[$count][1];
                return $articles[$article_id];
            break;
        }
    }

    /**
     * PUT method.
     *
     * @param  Request $request
     * @return string
     */
    public function put($request){
        switch ($request->elements[1][0]){
            case $this->left:
                var_dump("Resource: " . $this->left . " degree " . $request->elements[1][1]);
                break;
            case $this->right:
                var_dump("Resource: " . $this->right . " degree " . $request->elements[1][1]);
                break;
            case $this->up:
                var_dump("Resource: " . $this->up . " degree " . $request->elements[1][1]);
                break;
            case $this->down:
                var_dump("Resource: " . $this->down . " degree " . $request->elements[1][1]);
                break;
            default:
                header('HTTP/1.1 404 Not Found');
                return 'Unknown request: ' . $request->elements[1][0];
        }
/*        switch (count($request->elements[0])) {

        }
*/
    }

    /**
     * Read articles.
     *
     * @return array
     */
    protected function readArticles()
    {
        $articles = unserialize(file_get_contents($this->articles_file));
        if (empty($articles)) {
            $articles = array(
                1 => array(
                    'id' => 1,
                    'title' => 'Test Article',
                    'content' => 'Welcome to your new API framework!',
                    'published' => date('c', mktime(18, 35, 48, 1, 13, 2012))
                )
            );
            $this->writeArticles($articles);
        }
        return $articles;
    }
    
    /**
     * Write articles.
     *
     * @param  string $articles
     * @return boolean
     */
    protected function writeArticles($articles)
    {
        file_put_contents($this->articles_file, serialize($articles));
        return true;
    }
}