<?php
    /**
     * class DB là class singleton
     * đảm bảo chỉ có duy nhất 1 kết nối tới database
     */
class DB
{
    private static $conn = null;

    public static function getConnect()
    {
        if (!isset(self::$conn)) {
            try {
                self::$conn = new PDO('mysql:host=localhost;dbname=query-builder;charset=UTF8', 'root', 'password');
            } catch (PDOException $e) {
                echo "Lỗi server ";
                die($e->getMessage());
            }
        }
        return self::$conn;
    }

    public static function closeConnect()
    {
        if (isset(self::$conn)) {
            self::$conn = null;
        }
    }
}
