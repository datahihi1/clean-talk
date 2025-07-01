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

Yêu cầu PHP >= 7.1, <= 8.4

Cài đặt qua [Composer](https://getcomposer.org/):

```bash
composer require datahihi1/clean-talk
```

Để phát triển, cài đặt thêm development dependencies:

```bash
composer install --dev
```

## Sử dụng

```PHP
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
echo $printTest1 . PHP_EOL; // Kết quả: Không có từ tục

// Làm sạch văn bản
$text2 = 'Nhìn anh ấy kìa, anh ấy thật bẩn tính!';
$cleanedText = $censor->clean($text2);
echo $cleanedText . PHP_EOL;  // Kết quả: 'Nhìn anh ấy kìa, anh ấy thật *** tính!'

// Làm sạch văn bản với chế độ null
$cleanedTextNull = $censor->null($text2); // Kết quả: '' (chuỗi rỗng vì có từ tục)
print_utf8($cleanedTextNull);
```

## Demo

Chạy file demo để xem ví dụ sử dụng:

```bash
php demo.php
```

## Testing

Chạy tests (khi có):

```bash
./vendor/bin/phpunit
```

Chạy static analysis:

```bash
./vendor/bin/phpstan analyse src/
```

## Cấu trúc dự án

```
clean-talk/
├── src/
│   ├── Censor.php              # Class chính
│   ├── Support/
│   │   ├── Dictionary.php      # Quản lý từ điển
│   │   ├── Masker.php          # Che từ tục
│   │   └── Normalizer.php      # Chuẩn hóa văn bản
│   └── locale/
│       ├── vi-vietnamese.txt   # Từ điển tiếng Việt
│       └── en-english.txt      # Từ điển tiếng Anh
├── tests/                      # Unit tests
├── composer.json
└── readme.md
```
