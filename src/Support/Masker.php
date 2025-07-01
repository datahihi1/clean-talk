<?php
namespace CleanTalk\Support;

/**
 * Masker là lớp dùng để che các từ tục bằng ký tự mask.
 * 
 * Nó cung cấp các phương thức để che toàn bộ từ hoặc chỉ giữ ký tự đầu/cuối.
 */
class Masker
{
    /**
     * Che toàn bộ từ bằng ký tự mask
     * 
     * Ví dụ: "ngu" → "***", "bẩn" → "***"
     * 
     * @param string $word Từ cần che
     * @param string $maskChar Ký tự dùng để che (mặc định là '*')
     * @return string
     */
    public static function mask($word, $maskChar = '*')
    {
        return str_repeat($maskChar, mb_strlen($word));
    }

    /**
     * Che thông minh: chỉ giữ ký tự đầu/cuối
     * 
     * "ngu" → "n**", "bẩn" → "b**"
     * 
     * @param string $word Từ cần che
     * @param string $maskChar Ký tự dùng để che (mặc định là '*')
     * @return string
     */
    public static function smartMask($word, $maskChar = '*')
    {
        $len = mb_strlen($word);

        if ($len <= 2) {
            return self::mask($word, $maskChar);
        }

        $first = mb_substr($word, 0, 1);
        $last = mb_substr($word, -1);
        $masked = str_repeat($maskChar, $len - 2);

        return $first . $masked . $last;
    }
}