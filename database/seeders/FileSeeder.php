<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\File;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logos = [
            [
                'file_path' => 'WtbxweLh4LdgK5wFFSAEwTuO1YXNEaTl4VZRjbQf.jpg'
            ],
            [
                'file_path' => '2oRrAeFGKPFqRDMlON4BMue8DlK0CHlEkx11eMyr.png'
            ]
        ];

        foreach ($logos as $logo) {
            File::create($logo);
        }
    }
}
