<?php
require_once "includes/conn.php";

class SlugifyManager {

    // This method generates a slug from a string
    public static function slugify($string) {
        $preps = array('in', 'at', 'on', 'by', 'into', 'off', 'onto', 'from', 'to', 'with', 'a', 'an', 'the', 'using', 'for');
        $pattern = '/\b(?:' . join('|', $preps) . ')\b/i';
        $string = preg_replace($pattern, '', $string);
        $string = preg_replace('~[^\\pL\d]+~u', '-', $string);
        $string = trim($string, '-');
        $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
        $string = strtolower($string);
        $string = preg_replace('~[^-\w]+~', '', $string);
        
        return $string;
    }

    // Method to get candidate details and their slugs
    public static function getDetails() {
        $conn = DBConnect::getConnection();
        $checked = '';
        
        $sql = "SELECT * FROM positions ORDER BY priority ASC";
        $result = mysql_query($sql, $conn);
	$row = mysql_fetch_array($result, MYSQL_BOTH);
        while ($row = mysql_fetch_assoc($result)) {
            $slug = self::slugify($row['description']);
            $sql = "SELECT * FROM candidates WHERE position_id='" . $row['id'] . "'";
            $cquery = mysql_query($sql, $conn);
            while ($crow = $cquery->fetch_assoc()) {
                if (isset($_SESSION['post'][$slug])) {
                    $value = $_SESSION['post'][$slug];

                    if (is_array($value)) {
                        $checked = in_array($crow['id'], $value) ? 'checked' : '';
                    } else {
                        $checked = ($value == $crow['id']) ? 'checked' : '';
                    }
                }
            }
        }
        return $checked;
    }
    
    public static function getVoterId($voter) {
        $conn = DBConnect::getConnection();
        $sql = "SELECT * FROM votes WHERE voters_id = '" . $voter . "'";
						
        $result = mysql_query($sql, $conn);
	$row = mysql_fetch_array($result, MYSQL_BOTH);
        
    }
    
}
?>
