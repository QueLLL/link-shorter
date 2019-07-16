<?php


namespace Components;
use PDO;

class Linker
{

    public static function redirect($short)
    {
        $link = self::getFullLink($short);
        if($link) {
            self::registerNewClick($link);
            header('Location: ' . $link);
        } else {
            header('Location: ' . HOST);
        }
    }

    public static function getFullLink($short)
    {
        $conn = Db::getConnection();
        $sql = 'SELECT link FROM `links` WHERE `short_link` = :short';
        $result = $conn->prepare($sql);
        $result->bindParam(':short', $short, PDO::PARAM_STR);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        if (!empty($row['link'])) {
            return $row['link'];
        }
        else {
            return false;
        }
    }

    public static function isLinkExists($link)
    {
        $conn = Db::getConnection();
        $sql = 'SELECT COUNT(short_link) FROM `links` WHERE `link` = :link';
        $result = $conn->prepare($sql);
        $result->bindParam(':link', $link, PDO::PARAM_STR);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_NUM);
        if($row[0] == 0) {
            return false;
        }
        return true;
    }

    public static function addLink($link)
    {
        $short = Rand::getString();
        $conn = Db::getConnection();
        $sql = 'INSERT INTO `links` (link,short_link) VALUES (:link, :short)';
        $result = $conn->prepare($sql);
        $result->bindParam(':link', $link, PDO::PARAM_STR);
        $result->bindParam(':short', $short, PDO::PARAM_STR);
        $result->execute();
        return HOST.$short;
    }

    public static function getShortLink($link)
    {
        $conn = Db::getConnection();
        $sql = 'SELECT short_link FROM `links` WHERE `link` = :link';
        $result = $conn->prepare($sql);
        $result->bindParam(':link', $link, PDO::PARAM_STR);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return HOST. $row['short_link'];
    }

    public static function registerNewClick($link)
    {
        $short = Rand::getString();
        $conn = Db::getConnection();
        $sql = 'UPDATE `links` SET  `clicks` = `clicks` + 1 WHERE  link = :link';
        $result = $conn->prepare($sql);
        $result->bindParam(':link', $link, PDO::PARAM_STR);
        $result->execute();
    }

    public static function getPopularLinks()
    {
        $conn = Db::getConnection();
        $sql = 'SELECT short_link, link, clicks FROM `links` ORDER BY clicks DESC LIMIT 5';
        $result = $conn->prepare($sql);
        $result->execute();
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
}