<?php

namespace App\Livewire;

use App\Models\Catatan;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class CatatanForm extends Component implements HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use WithFileUploads;

    protected static ?string $model = Catatan::class; // Menghubungkan form dengan model Catatan

    public ?Catatan $record = null; // Properti untuk menyimpan instance model

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->label('Judul')
                ->required(),
            Textarea::make('content')
                ->label('Cerita Kegiatanmu')
                ->required(),
            DatePicker::make('entry_date')
                ->label('Tanggal')
                ->required(),
            TimePicker::make('time')
                ->label('Waktu')
                ->required(),
            FileUpload::make('image_path')
                ->label('Foto Kegiatan')
                ->image()
                ->directory('catatan-images')
                ->preserveFilenames()
                ->maxSize(2048)
                ->required()
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                ->columnSpanFull(),
        ]);
    }

    public function mount(?Catatan $catatan = null): void
    {
        $this->record = $catatan ?? new Catatan(); // Jika tidak ada record, buat instance baru
        $this->form->fill($this->record->toArray()); // Isi form dengan data dari model
    }

    public function submit()
    {
        $data = $this->form->getState();

        if (isset($data['image_path'])) {
            $data['image_path'] = $data['image_path']->store('catatan-images', 'public');
        }

        $this->record->fill($data); // Isi model dengan data dari form
        $this->record->save(); // Simpan model ke database

        session()->flash('success', 'Diary berhasil ditambahkan!');
        return redirect()->route('catatan.index');
    }

    public function render(): View
    {
        return view('livewire.catatan-form', [
            'form' => static::form($this->form),
        ]);
    }
}
