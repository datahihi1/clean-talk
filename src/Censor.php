<?php
namespace CleanTalk;

use CleanTalk\Support\Dictionary;
use CleanTalk\Support\Masker;
use CleanTalk\Support\Normalizer;

/**
 * Censor là một lớp dùng để kiểm tra và làm sạch các từ tục trong văn bản.
 * 
 * Nó sử dụng một từ điển để xác định các từ tục và cung cấp các phương thức để
 * kiểm tra, làm sạch và thêm từ tục vào từ điển.
 */
class Censor{
    protected Dictionary $dictionary;
    protected string $maskChar = '*';
    protected bool $strict = false;

    /**
     * Censor là một lớp dùng để kiểm tra và làm sạch các từ tục trong văn bản.
     * 
     * Khởi tạo với ngôn ngữ mặc định là tiếng Việt ('vi').
     * 
     * Bạn có thể thay đổi ngôn ngữ từ điển bằng phương thức setLocale.
     * @param string $locale Tên ngôn ngữ theo tên file từ điển (ví dụ: 'vi', 'en', 'fr').
     */
    public function __construct(string $locale = 'vi')
    {
        $this->dictionary = new Dictionary($locale);
    }

    /**
     * Kiểm tra nếu chuỗi chứa từ tục.
     * 
     * @param string $text Chuỗi cần kiểm tra
     */
    public function contains(string $text): bool
    {
        $normalized = Normalizer::normalize($text, $this->strict);

        foreach ($this->dictionary->getWords() as $word) {
            if (str_contains($normalized, $word)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Làm sạch chuỗi: thay từ tục bằng dấu `*`
     * 
     * @param string $text Chuỗi cần làm sạch
     */
    public function clean(string $text): string
    {
        $normalized = Normalizer::normalize($text, $this->strict);
        $words = $this->dictionary->getWords();

        // Duyệt từng từ tục và che đi trong văn bản gốc
        foreach ($words as $badWord) {
            $pattern = '/' . preg_quote($badWord, '/') . '/iu';

            $text = preg_replace_callback($pattern, function ($matches) {
                return Masker::mask($matches[0], $this->maskChar);
            }, $text);
        }

        return $text;
    }

    /**
     * Thêm một hoặc nhiều từ vào danh sách từ tục.
     * 
     * @param string|array $word Từ tục hoặc mảng từ tục cần thêm
     */
    public function addWord(string|array $word): void
    {
        $this->dictionary->addWord($word);
    }

    /**
     * Đặt ký tự che (default: *)
     * 
     * @param string $char Ký tự dùng để che các từ tục
     */
    public function setMaskChar(string $char): void
    {
        $this->maskChar = $char;
    }

    /**
     * Bật/tắt strict mode (lọc biến thể).
     * 
     * @param bool $strict Nếu true, sẽ loại bỏ ký tự đặc biệt và rút gọn ký tự lặp lại.
     *                    Nếu false, chỉ so sánh từ tục đã chuẩn hóa.
     */
    public function setStrictMode(bool $strict): void
    {
        $this->strict = $strict;
    }

    /**
     * Đổi ngôn ngữ từ điển
     * 
     * @param string $locale Tên ngôn ngữ theo tên file từ điển (ví dụ: 'vi', 'en', 'fr')
     * @throws \RuntimeException Nếu không tìm thấy file từ điển tương ứng
     */
    public function setLocale(string $locale): void
    {
        $this->dictionary->loadLocale($locale);
    }

    /**
     * Nếu phát hiện đoạn text có ít nhất 1 từ tục sẽ trả về chuỗi rỗng, ngược lại trả về text gốc.
     *
     * @param string $text Chuỗi cần kiểm tra
     * @return string
     */
    public function null(string $text): string
    {
        return $this->contains($text) ? '' : $text;
    }
}