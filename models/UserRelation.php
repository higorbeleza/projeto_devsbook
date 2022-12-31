<?php
class UserRelation {
    public $id;
    public $user_from;
    public $user_to;
}

interface UserRelationDAO {
    public function insert(UserRelation $u);
    public function delete(UserRelation $u);
    public function getFollwing($id);
    public function getFollowers($id);
    public function isFollowing($id1, $id2);
}
