<?php

namespace Tests\Feature\Pjbl;

use App\Models\User;
use App\Models\book as Book;
use App\Models\category as Category;
use Illuminate\Support\Facades\Schema;

trait P9Data
{
    protected function anggota(string $email = 'student@gmail.com'): User
    {
        return User::create([
            'name' => 'Anggota Uji',
            'email' => $email,
            'password' => bcrypt('12345678'),
            'code' => 'U-001',
        ]);
    }

    protected function admin(): User
    {
        $attrs = [
            'name' => 'Admin Uji',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'code' => 'U-000',
        ];

        if (Schema::hasColumn('users', 'role')) {
            $attrs['role'] = 'admin';
        }

        return User::create($attrs);
    }

    protected function buku(array $overrides = []): Book
    {
        $kategori = Category::firstOrCreate(['name' => 'Fiksi']);

        $attrs = [
            'category_id' => $kategori->id,
            'code' => 'BK-001',
            'title' => 'Buku Uji Satu',
            'writer' => 'Penulis Uji',
            'being_borrowed' => 0,
            'stock' => 5,
        ];

        // v1 masih punya kolom price, v2 sudah menghapusnya.
        if (Schema::hasColumn('books', 'price')) {
            $attrs['price'] = 0;
        }

        return Book::create(array_merge($attrs, $overrides));
    }

    protected function mulaiPinjam(User $user): string
    {
        $this->actingAs($user);
        $this->get('/borrow')->assertRedirect('/cart');

        return (string) session('code_borrow');
    }
}
