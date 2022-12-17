<?php
require_once 'models/Post.php';
require_once 'dao/UserRelationDaoMysql.php';
require_once 'dao/UserDaoMysql.php';

class PostDaoMysql implements PostDAO {
    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo = $driver;
    }

    public function insert(POST $p) {
        $sql = $this->pdo->prepare("INSERT INTO posts (
            id_user, type, created_at, body
        ) VALUES (
            :id_user, :type, :created_at, :body
        )");

        $sql->bindValue(':id_user', $p->id_user);
        $sql->bindValue(':type', $p->type);
        $sql->bindValue(':created_at', $p->created_at);
        $sql->bindValue(':body', $p->body);
        $sql->execute();
    }

    public function getHomeFeed($id_user) {
        $array = [];

        // Listando os usuarios que eu sigo.
        $urDao = new UserRelationDaoMysql($this->pdo);
        $userList = $urDao->getRelationsFrom($id_user);

        // Pegando os posts ordenados pela data de postagem.
        $sql = $this->pdo->prepare("SELECT * FROM posts WHERE id_user IN (".implode(',', $userList).") ORDER BY created_at DESC");
        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            // Transformando os resultados em objetos.
            $array = $this->_postListToObject($data, $id_user);
        }

        return $array;
    }
    private function _postListToObject($post_list, $id_user) {
        $posts = [];
        $userDao = new UserDaoMysql($this->pdo);

        foreach($post_list as $post_item) {
            $newPost = new Post();
            $newPost->id = $post_item['id'];
            $newPost->id_user = $post_item['id_user'];
            $newPost->type = $post_item['type'];
            $newPost->created_at = $post_item['created_at'];
            $newPost->body = $post_item['body'];
            $newPost->mine = false;

            if($post_item['id_user'] == $id_user) {
                $newPost->mine = true;
            }

            // Pegando informações do usuario.
            $newPost->user = $userDao->findById($post_item['id_user']);


            // Informações sobre likes
            $newPost->likeCount = 0;
            $newPost->liked = false;


            // Informações sobre comments
            $newPost->comments = [];


            $posts[] = $newPost;
        }

        return $posts;
    }
}