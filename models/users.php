<?php
class users
{
    public function insertUser($email, $password)
    {
        try {
           //code to insert user here.

        } catch (PDOException $e) {
            echo $e->getmessage();
            return false;
        }
    }
}
