<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Admin',
                'permissions' => '{"users.view" : "1","users.create" : "1","users.edit":"1","users.delete" : "1", "permissions.view" : "1","permissions.edit" : "1", "slider.view" : "1", "slider.create" : "1", "slider.edit" : "1", "slider.delete" : "1", "faq.view" : "1", "faq.create" : "1", "faq.edit" : "1", "faq.delete" : "1", "announcement.view" : "1", "announcement.create" : "1", "announcement.edit" : "1", "announcement.delete" : "1"}'
            ],
            [
                'name' => 'User',
                'permissions' => '{"users.view" : "1","users.create" : "1","users.edit":"1","users.delete" : "1", "permissions.view" : "1","permissions.edit" : "1", "slider.view" : "1", "slider.create" : "1", "slider.edit" : "1", "slider.delete" : "1", "faq.view" : "1", "faq.create" : "1", "faq.edit" : "1", "faq.delete" : "1", "announcement.view" : "1", "announcement.create" : "1", "announcement.edit" : "1", "announcement.delete" : "1"}'
            ]
        ];


        foreach($data as $value)
        {
            UserType::create($value);
        }

    }
}
