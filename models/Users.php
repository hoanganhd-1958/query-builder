<?php
require_once 'BaseModel.php';
require_once 'connection.php';
/**
 * Model User
 */
class UsersModel extends BaseModel
{
    public function all()
    {
        $user   = new BaseModel();
        $result = $user ->table('users')
                        ->select('id', 'username', 'email', 'status')
                        // ->where('id', '>=', '7')
                        // ->orWhere('username', 'nguyenlinh')
                        // ->orderBy('id')
                        ->get();
        return $result;
    }

    public function find($id)
    {
        $user   = new BaseModel();
        $result = $user ->table('users')
                        ->find($id);
        return $result;
    }

    public function create(array $arr)
    {
        $user   = new BaseModel();
        $result = $user ->table('users')
                        ->insert($arr);
        return $result;
    }

    public function edit($id, array $arr)
    {
        $user   = new BaseModel();
        $result = $user ->table('users')
                        ->where('id', $id)
                        ->update($arr);
        return $result;
    }

    public function delete($id)
    {
        $user   = new BaseModel();
        $result = $user ->table('users')
                        ->where('id', $id)
                        ->delete();
        return $result;
    }

    public function status($id)
    {
        $base = new BaseModel();
        $user = $base->table('users')
                    ->find($id);

        ($user->status == 1) ? $status = 0 : $status = 1;
        
        $user_update = $base->table('users')
                            ->where('id', $id)
                            ->update(['status' => $status]);
        return $user_update;
    }
}
