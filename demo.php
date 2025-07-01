<?php
require_once __DIR__ . '/src/Censor.php';
require_once __DIR__ . '/src/Support/Dictionary.php';
require_once __DIR__ . '/src/Support/Masker.php';
require_once __DIR__ . '/src/Support/Normalizer.php';

// Khởi tạo đối tượng Censor với từ điển tiếng Việt
use CleanTalk\Censor;
$censor = new Censor('vi'); // 'vi' là tên ngôn ngữ, sẽ tải file vi-vietnamese.txt

// Bật chế độ strict mode nếu cần
// Chế độ strict mode sẽ lọc các biến thể từ tục
$censor->setStrictMode(true);

// Đặt ký tự dùng để che từ tục
$censor->setMaskChar('*');

// Thêm từ tục mới
$censor->addWord('bẩn');

// Kiểm tra văn bản có từ tục hay không
$text1 = 'Đây là một văn bản bình thường.';
$printTest1 = $censor->contains($text1) ? 'Có từ tục' : 'Không có từ tục';

function print_utf8($str) {
    echo mb_convert_encoding($str, 'UTF-8', 'UTF-8') . PHP_EOL;
}
print_utf8($printTest1);
print_utf8($censor->null($text1));

// Làm sạch văn bản
$text2 = 'Đây là một văn bản có từ tục: bẩn.';
$cleanedText = $censor->clean($text2); // Kết quả: 'Đây là một văn bản có từ tục: ****.'
print_utf8($cleanedText);

// Làm sạch văn bản với chế độ null
$cleanedTextNull = $censor->null($text2); // Kết quả: '' (chuỗi rỗng vì có từ tục)
print_utf8($cleanedTextNull);

