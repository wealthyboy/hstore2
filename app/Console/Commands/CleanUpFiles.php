<?php

namespace App\Console\Commands;

use App\Models\ProductVariation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanUpFiles extends Command
{

    protected $signature = 'cleanup:files';
    protected $description = 'Delete files not present in both folders';

    public function handle()
    {
        $folderPath = public_path('images/products/m');
        $databaseImages = ProductVariation::get();
        //$databaseImages = Image::get();

        // foreach ($databaseImages as $databaseImage) {
        //     $databaseImage->image = str_replace('https://hautesignatures.com', 'https://hautesignatures.com.ng', $databaseImage->image);
        //     $databaseImage->save();
        //     $this->info('Deleted: ' . $databaseImage->image);
        // }



        // foreach ($databaseImages as $databaseImage) {
        //     $databaseImage->image = str_replace('https://hautesignatures.com', 'https://hautesignatures.com.ng', $databaseImage->image);
        //     $databaseImage->save();
        //     $this->info('Deleted: ' . $databaseImage->image);
        // }

        $images = [];
        foreach ($databaseImages as $databaseImage) {
            $images[] = pathinfo($databaseImage->image, PATHINFO_BASENAME);
        }

        //dd(count($images));

        $filesInFolder = File::files($folderPath);

        dd(count($filesInFolder));


        foreach ($filesInFolder as $file) {
            $filename = pathinfo($file, PATHINFO_BASENAME);
            if (!in_array($filename, $images)) {
                File::delete($file);
                $this->info('Deleted: ' . $file);
            }
        }

        $this->info('Cleanup completed successfully.');
    }
}
