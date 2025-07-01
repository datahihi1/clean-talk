<?php
namespace CleanTalk\Support;

/**
 * Dictionary là lớp dùng để quản lý từ điển các từ tục.
 * 
 * Nó cho phép tải từ điển từ file, thêm từ tục mới,
 * lấy danh sách các từ tục và cài đặt danh sách từ tục mới.
 */
class Dictionary
{
    /**
     * @var array
     */
    protected $words;

    /**
     * Khởi tạo từ điển với ngôn ngữ mặc định.
     * Nếu cần, có thể tải từ điển khác bằng phương thức loadLocale.
     * @param string $locale
     */
    public function __construct($locale = 'vi')
    {
        $this->words = array();
        $this->loadLocale($locale);
    }
    /**
     * Tải từ điển từ file tương ứng với ngôn ngữ.
     * 
     * File phải có định dạng: Locale/locale.txt
     * @param string $locale Tên ngôn ngữ (ví dụ: 'vi', 'en', 'fr')
     * @throws \RuntimeException
     */
    public function loadLocale($locale)
    {
        $file = __DIR__ . "/../Locale/{$locale}.txt";

        if (file_exists($file)) {
            $this->words = array_filter(array_map('trim', file($file)));
        } else {
            throw new \RuntimeException("Locale file '{$locale}.txt' not found.");
        }
    }
    /**
     * Thêm từ tục vào từ điển.
     * 
     * Có thể truyền vào một từ (string) hoặc một mảng các từ (array).
     * 
     * @param string|array $word Từ tục hoặc mảng từ tục cần thêm
     */
    public function addWord($word)
    {
        if (is_array($word)) {
            foreach ($word as $w) {
                $this->words[] = strtolower($w);
            }
        } else {
            $this->words[] = strtolower($word);
        }
    }

    /**
     * Lấy danh sách các từ tục trong từ điển.
     * @return array
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * Cài đặt danh sách từ tục mới.
     * @param array $words Danh sách từ tục, mỗi từ là một chuỗi
     * @return void
     */
    public function setWords($words)
    {
        $this->words = array_map('strtolower', $words);
    }
}