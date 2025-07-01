<?php
namespace CleanTalk\Support;

/**
 * Normalizer là lớp dùng để chuẩn hóa chuỗi văn bản.
 * 
 * Nó cung cấp các phương thức để xóa dấu tiếng Việt, chuyển đổi chữ thường,
 * và loại bỏ ký tự đặc biệt nếu cần.
 */
class Normalizer
{
    /**
     * Chuẩn hóa chuỗi: xóa dấu, chuyển thường, biến thể.
     * 
     * @param string $text Chuỗi cần chuẩn hóa
     * @param bool $strict Nếu true, sẽ loại bỏ ký tự đặc biệt và rút gọn ký tự lặp lại.
     * @return string
     */
    public static function normalize($text, $strict = false)
    {
        $text = mb_strtolower($text, 'UTF-8');

        // Loại bỏ dấu tiếng Việt
        $text = self::stripAccents($text);

        if ($strict) {
            // Loại bỏ ký tự đặc biệt thay thế
            $text = preg_replace('/[^a-z0-9\s]/iu', '', $text);

            // Rút gọn ký tự lặp lại (nguooo → ngu)
            $text = preg_replace('/(.)\1{2,}/u', '$1', $text);
        }

        return $text;
    }

    /**
     * Xóa dấu tiếng Việt
     * 
     * @param string $str Chuỗi cần xóa dấu
     * @return string
     */
    public static function stripAccents($str)
    {
        $accents = array(
            'à','á','ạ','ả','ã',
            'â','ầ','ấ','ậ','ẩ','ẫ',
            'ă','ằ','ắ','ặ','ẳ','ẵ',
            'è','é','ẹ','ẻ','ẽ',
            'ê','ề','ế','ệ','ể','ễ',
            'ì','í','ị','ỉ','ĩ',
            'ò','ó','ọ','ỏ','õ',
            'ô','ồ','ố','ộ','ổ','ỗ',
            'ơ','ờ','ớ','ợ','ở','ỡ',
            'ù','ú','ụ','ủ','ũ',
            'ư','ừ','ứ','ự','ử','ữ',
            'ỳ','ý','ỵ','ỷ','ỹ',
            'đ',
        );
        $replacements = array(
            'a','a','a','a','a',
            'a','a','a','a','a','a',
            'a','a','a','a','a','a',
            'e','e','e','e','e',
            'e','e','e','e','e','e',
            'i','i','i','i','i',
            'o','o','o','o','o',
            'o','o','o','o','o','o',
            'o','o','o','o','o','o',
            'u','u','u','u','u',
            'u','u','u','u','u','u',
            'y','y','y','y','y',
            'd',
        );

        return str_replace($accents, $replacements, $str);
    }
}