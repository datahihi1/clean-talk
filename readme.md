# CleanTalk - Thư viện lọc từ tục tiếng Việt (và đa ngôn ngữ)

CleanTalk là một thư viện PHP giúp phát hiện, kiểm tra và che giấu (mask) các từ tục, từ nhạy cảm trong văn bản. Thư viện hỗ trợ tiếng Việt và có thể mở rộng cho các ngôn ngữ khác.

Có tham khảo từ dự án [vietnamese-offensive-words](https://github.com/blue-eyes-vn/vietnamese-offensive-words)

---

## Tính năng chính

- **Kiểm tra văn bản có chứa từ tục hay không**
- **Làm sạch văn bản bằng cách che các từ tục bằng ký tự tuỳ chọn**
- **Tự động chuẩn hóa văn bản (xóa dấu, chuyển thường, loại bỏ ký tự đặc biệt, rút gọn ký tự lặp)**
- **Thêm từ tục mới vào từ điển**
- **Hỗ trợ nhiều ngôn ngữ (dễ dàng mở rộng)**
- **Chế độ strict mode để lọc biến thể từ tục**
- **Hàm null: Nếu phát hiện có từ tục, trả về chuỗi rỗng**

---

## Cài đặt

Yêu cầu PHP 8.0+

Cài đặt qua Composer:

```bash
composer require datahihi1/clean-talk
```

Sử dụng file loader.php (không cần Composer)

```php
require_once './clean-talk/loader.php';
```

## Sử dụng

```PHP
// Khởi tạo đối tượng Censor với từ điển tiếng Việt
use CleanTalk\Censor;
$censor = new Censor('vi-vietnamese'); // vi-vietnamese là tên tệp từ điển tiếng Việt có trong `src/locale/`

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
echo $printTest1 . PHP_EOL; // Kết quả: Không có từ tục

// Làm sạch văn bản
$text2 = 'Nhìn anh ấy kìa, anh ấy thật bẩn tính!';
$cleanedText = $censor->clean($text2);
echo $cleanedText . PHP_EOL;  // Kết quả: 'Nhìn anh ấy kìa, anh ấy thật *** tính!'

// Làm sạch văn bản với chế độ null
$cleanedTextNull = $censor->null($text2); // Kết quả: ''
```