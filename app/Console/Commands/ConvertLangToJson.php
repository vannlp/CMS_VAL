<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConvertLangToJson extends Command
{
    protected $signature = 'lang:tojson';

    protected $description = 'Convert language files to JSON format';

    public function handle()
    {
        // Đường dẫn đến thư mục ngôn ngữ
        $langPath = base_path('lang');
        $jsonPath = public_path('lang'); // Thư mục lưu file JSON

        // Kiểm tra thư mục json đã tồn tại chưa, nếu chưa thì tạo
        if (!File::exists($jsonPath)) {
            File::makeDirectory($jsonPath);
        }

        // Duyệt qua các ngôn ngữ (vd: en, vi...)
        foreach (File::directories($langPath) as $langDir) {
            $locale = basename($langDir); // Lấy mã ngôn ngữ (vd: en, vi)
            $translations = [];

            // Đọc tất cả các file trong thư mục ngôn ngữ
            foreach (File::allFiles($langDir) as $file) {
                $fileName = pathinfo($file, PATHINFO_FILENAME);
                $translations[$fileName] = File::getRequire($file); // Lấy nội dung file
            }

            // Lưu file JSON
            File::put($jsonPath . "/{$locale}.json", json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // $this->info("Ngôn ngữ [{$locale}] đã được chuyển thành JSON.");
        }

        $this->info('Tất cả file ngôn ngữ đã được chuyển thành JSON.');
    }
}
