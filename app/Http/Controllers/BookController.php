<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataBuku = Book::all();
        return view('layouts.management.book', ['dataBuku' => $dataBuku]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataKategori = Category::all();
        return view('layouts.management.form.add-book', ['dataKategori' => $dataKategori]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'code'    => 'required|string|max:50|unique:books,code',
            'writer'  => 'required|string|max:255',
            'stock'   => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        Book::create([
            'category_id' => $request->category_id,
            'code'        => $request->code,
            'title'       => $request->title,
            'cover'       => '',
            'writer'      => $request->writer,
            'stock'       => $request->stock,
            'being_borrowed' => 0,
            // ✅ price dihapus sepenuhnya
        ]);

        return redirect('book')->with('berhasil', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editBuku = Book::findOrFail($id);
        return view('layouts.management.form.update-book', ['editBuku' => $editBuku]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'code'    => 'required|string|max:50|unique:books,code,' . $id,
            'writer'  => 'required|string|max:255',
            'stock'   => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        $updateBuku = Book::findOrFail($id);
        $updateBuku->update([
            'code'        => $request->code,
            'title'       => $request->title,
            'writer'      => $request->writer,
            'stock'       => $request->stock,
            'category_id' => $request->category_id,
            // ✅ price dihapus
        ]);

        return redirect('book')->with('berhasil', 'Buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteBuku = Book::findOrFail($id);
        $deleteBuku->delete();
        return redirect()->back()->with('message', 'Buku berhasil dihapus!');
    }
}