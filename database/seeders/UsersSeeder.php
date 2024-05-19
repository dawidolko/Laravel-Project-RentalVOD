<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $adminRoleId = Role::where('name', 'admin')->first()->id;
        $userRoleId = Role::where('name', 'user')->first()->id;

        User::insert([
            ['first_name' => 'Jan', 'last_name' => 'Kowalski', 'email' => 'jan.kowalski@example.com', 'address' => 'ul. Słoneczna 12, Warszawa', 'password' => Hash::make('Admin12345&'), 'role_id' => $adminRoleId],
            ['first_name' => 'Anna', 'last_name' => 'Nowak', 'email' => 'anna.nowak@example.com', 'address' => 'ul. Główna 23, Kraków', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Piotr', 'last_name' => 'Wiśniewski', 'email' => 'piotr.wisniewski@example.com', 'address' => 'ul. Krótka 5, Gdańsk', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Katarzyna', 'last_name' => 'Dąbrowska', 'email' => 'katarzyna.dabrowska@example.com', 'address' => 'ul. Leśna 10, Wrocław', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Michał', 'last_name' => 'Lewandowski', 'email' => 'michal.lewandowski@example.com', 'address' => 'ul. Morska 34, Szczecin', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Agnieszka', 'last_name' => 'Kamińska', 'email' => 'agnieszka.kaminska@example.com', 'address' => 'ul. Wysoka 45, Łódź', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Tomasz', 'last_name' => 'Zieliński', 'email' => 'tomasz.zielinski@example.com', 'address' => 'ul. Akacjowa 56, Poznań', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Marta', 'last_name' => 'Kowalczyk', 'email' => 'marta.kowalczyk@example.com', 'address' => 'ul. Parkowa 67, Katowice', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Jakub', 'last_name' => 'Wojciechowski', 'email' => 'jakub.wojciechowski@example.com', 'address' => 'ul. Ogrodowa 78, Gdynia', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Zofia', 'last_name' => 'Szymańska', 'email' => 'zofia.szymanska@example.com', 'address' => 'ul. Różana 89, Białystok', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Marek', 'last_name' => 'Woźniak', 'email' => 'marek.wozniak@example.com', 'address' => 'ul. Kwiatowa 90, Lublin', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Magdalena', 'last_name' => 'Kozłowska', 'email' => 'magdalena.kozlowska@example.com', 'address' => 'ul. Północna 11, Rzeszów', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Rafał', 'last_name' => 'Jankowski', 'email' => 'rafal.jankowski@example.com', 'address' => 'ul. Zachodnia 22, Częstochowa', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Julia', 'last_name' => 'Mazur', 'email' => 'julia.mazur@example.com', 'address' => 'ul. Południowa 33, Toruń',  'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Krzysztof', 'last_name' => 'Krawczyk', 'email' => 'krzysztof.krawczyk@example.com', 'address' => 'ul. Dolna 44, Kielce', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Ewa', 'last_name' => 'Baran', 'email' => 'ewa.baran@example.com', 'address' => 'ul. Górska 55, Olsztyn', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Adam', 'last_name' => 'Nowicki', 'email' => 'adam.nowicki@example.com', 'address' => 'ul. Nizinna 66, Opole', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Monika', 'last_name' => 'Adamczyk', 'email' => 'monika.adamczyk@example.com', 'address' => 'ul. Wschodnia 77, Gorzów Wielkopolski', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Paweł', 'last_name' => 'Dudek', 'email' => 'pawel.dudek@example.com', 'address' => 'ul. Brzegowa 88, Zielona Góra', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId],
            ['first_name' => 'Barbara', 'last_name' => 'Pawłowska', 'email' => 'barbara.pawlowska@example.com', 'address' => 'ul. Łąkowa 99, Siedlce', 'password' => Hash::make('password12345&A'), 'role_id' => $userRoleId]
        ]);
    }
}
